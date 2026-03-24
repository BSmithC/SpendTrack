<script setup>
import { ref, watch, computed } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
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
    roles: Object,
    label: String,
    error: String
})

const emit = defineEmits(['update:modelValue'])

const isOpen = ref(false)
const search = ref('')
const selectedIds = ref([...props.modelValue])

watch(
    () => props.modelValue,
    (val) => {
        selectedIds.value = [...val]
    }
)

watch(search, (value) => {
    router.get(window.location.pathname, { search: value }, {
        preserveState: true,
        replace: true,
        only: ['roles']
    })
})

const toggleRole = (role) => {
    const index = selectedIds.value.indexOf(role.id)

    if (index === -1) {
        selectedIds.value.push(role.id)
    } else {
        selectedIds.value.splice(index, 1)
    }

    emit('update:modelValue', selectedIds.value)
}

const isSelected = (id) => selectedIds.value.includes(id)

const selectedLabel = computed(() => {
    if (!selectedIds.value.length) return 'Seleccionar roles...'
    return `${selectedIds.value.length} rol(es) seleccionados`
})

const capitalize = (value) =>
    value ? value.charAt(0).toUpperCase() + value.slice(1) : ''
</script>

<template>
    <div class="space-y-2">
        <Label>{{ label || 'Roles' }}</Label>

        <Dialog v-model:open="isOpen" >
            <DialogTrigger as-child>
                <Button variant="outline" class="w-full justify-start font-normal bg-background border-input hover:bg-accent hover:text-accent-foreground">
                    <Check v-if="selectedIds.length" class="mr-2 h-4 w-4 text-green-500" />
                    <span>{{ selectedLabel }}</span>
                </Button>
            </DialogTrigger>

            <DialogContent class="sm:max-w-125 bg-background text-foreground border-border shadow-lg">
                <DialogHeader>
                    <DialogTitle>Seleccionar roles</DialogTitle>
                </DialogHeader>

                <div class="space-y-4">
                    <div class="relative">
                        <Search class="absolute left-3 top-3 h-4 w-4" />
                        <Input v-model="search" placeholder="Buscar rol..." class="pl-10" />
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
                                <TableRow
                                    v-for="role in roles.data"
                                    :key="role.id"
                                    @click="toggleRole(role)"
                                    :class="[
                                        'cursor-pointer',
                                        isSelected(role.id) ? 'bg-primary/10' : 'hover:bg-accent'
                                    ]"
                                >
                                    <TableCell>
                                        <Check v-if="isSelected(role.id)" class="h-4 w-4 text-green-500" />
                                    </TableCell>
                                    <TableCell>{{ role.id }}</TableCell>
                                    <TableCell>{{ capitalize(role.name) }}</TableCell>
                                </TableRow>

                                <TableRow v-if="roles.data.length === 0">
                                    <TableCell colspan="3" class="text-center py-8">
                                        No se encontraron roles
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
