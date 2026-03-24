<script setup>
import { ref, watch, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/Components/ui/dialog'
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/Components/ui/table'
import { Input } from '@/Components/ui/input'
import { Button } from '@/Components/ui/button'
import { Label } from '@/Components/ui/label'
import { Search, Check } from 'lucide-vue-next'

const props = defineProps({
    modelValue: {
        type: Array,
        default: () => []
    },
    branches: Object,
    label: String,
    error: String
})

const emit = defineEmits(['update:modelValue'])

const isOpen = ref(false)
const search = ref('')
const normalize = (arr) => [...new Set(arr.map(id => Number(id)))]
const selectedIds = ref(normalize(props.modelValue))

watch(
    () => props.modelValue,
    (val) => {
        selectedIds.value = normalize(val)
    },
    { immediate: true }
)


watch(search, (value) => {
    router.get(window.location.pathname, { search: value }, {
        preserveState: true,
        replace: true,
        only: ['branches']
    })
})

const toggleBranch = (branch) => {
    const id = Number(branch.id)
    const set = new Set(selectedIds.value)

    if (set.has(id)) {
        set.delete(id)
    } else {
        set.add(id)
    }

    selectedIds.value = [...set]
    emit('update:modelValue', selectedIds.value)
}



const isSelected = (id) => selectedIds.value.includes(id)

const selectedLabel = computed(() => {
    const total = new Set(selectedIds.value).size
    if (!total) return 'Seleccionar sucursales...'
    return `${total} sucursal(es) seleccionadas`
})

</script>

<template>
    <div class="space-y-2">
        <Label>{{ label || 'Sucursales' }}</Label>

        <Dialog v-model:open="isOpen">
            <DialogTrigger as-child>
                <Button variant="outline"
                    class="w-full justify-start font-normal bg-background border-input hover:bg-accent hover:text-accent-foreground">
                    <Check v-if="selectedIds.length" class="mr-2 h-4 w-4 text-green-500" />
                    <span>{{ selectedLabel }}</span>
                </Button>
            </DialogTrigger>

            <DialogContent class="sm:max-w-125 bg-background text-foreground border-border shadow-lg">
                <DialogHeader>
                    <DialogTitle class="text-foreground text-lg font-semibold">Seleccionar sucursales</DialogTitle>
                </DialogHeader>

                <div class="space-y-4">
                    <div class="relative">
                        <Search class="absolute left-3 top-3 h-4 w-4" />
                        <Input v-model="search" placeholder="Buscar sucursal..." class="pl-10" />
                    </div>

                    <div class="border rounded-md h-96 overflow-auto">
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead class="w-8"></TableHead>
                                    <TableHead>#</TableHead>
                                    <TableHead>Nombre</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow v-for="branch in branches.data" :key="branch.id" @click="toggleBranch(branch)"
                                    :class="[
                                        'cursor-pointer',
                                        isSelected(branch.id) ? 'bg-primary/10' : 'hover:bg-accent'
                                    ]">
                                    <TableCell>
                                        <Check v-if="isSelected(branch.id)" class="h-4 w-4 text-green-500" />
                                    </TableCell>
                                    <TableCell>{{ branch.id }}</TableCell>
                                    <TableCell>{{ branch.name }}</TableCell>
                                </TableRow>

                                <TableRow v-if="branches.data.length === 0">
                                    <TableCell colspan="3" class="text-center py-8">
                                        No se encontraron sucursales
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </div>
                </div>
            </DialogContent>
        </Dialog>

        <p v-if="error" class="text-sm text-destructive">{{ error }}</p>
    </div>
</template>
