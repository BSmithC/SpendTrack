<script setup>
import { ref, computed, watch } from 'vue'
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
import InputError from './InputError.vue'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
const props = defineProps({
    modelValue: [String, Number, Object],
    suppliers: {
        type: Array,
        required: true
    },
    label: String,
    error: String,
    emitAs: {
        type: String,
        default: 'id'
    }
})

const emit = defineEmits(['update:modelValue'])

const isOpen = ref(false)
const manualSearch = ref('')
const selectedName = ref('Seleccionar suplidor...')
const currentPage = ref(1)
const itemsPerPage = 10

const getSupplierId = (value) => {
    return typeof value === 'object' && value !== null
        ? value.id
        : value
}

const updateSelectedName = (value) => {
    const id = getSupplierId(value)
    if (!id) return

    const supplier = props.suppliers.find(s => s.id === id)
    if (supplier) {
        selectedName.value = `${supplier.first_name} ${supplier.last_name}`
    }
}

watch(() => props.modelValue, (newVal) => {
    if (!newVal) {
        selectedName.value = 'Seleccionar suplidor...'
    } else {
        updateSelectedName(newVal)
    }
}, { immediate: true })

const filteredSuppliers = computed(() => {
    const search = manualSearch.value.toLowerCase().trim()
    if (!search) return props.suppliers

    return props.suppliers.filter(spl => {
        const first = (spl.first_name || '').toLowerCase()
        const last = (spl.last_name || '').toLowerCase()
        const full = `${first} ${last}`.trim()

        return (
            first.includes(search) ||
            last.includes(search) ||
            full.includes(search)
        )
    })
})


const paginatedSuppliers = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage
    return filteredSuppliers.value.slice(start, start + itemsPerPage)
})

const totalPages = computed(() =>
    Math.ceil(filteredSuppliers.value.length / itemsPerPage)
)

watch(manualSearch, () => {
    currentPage.value = 1
})

const selectSupplier = (supplier) => {
    emit(
        'update:modelValue',
        props.emitAs === 'id' ? supplier.id : supplier
    )

    selectedName.value = `${supplier.first_name} ${supplier.last_name}`
    isOpen.value = false
    manualSearch.value = ''
}
</script>
<template>
    <div class="space-y-2">
        <Label class="text-foreground">
            {{ label || 'Suplidor' }} <span class="text-red-500">*</span>
        </Label>

        <Dialog v-model:open="isOpen">
            <DialogTrigger as-child>
                <Button variant="outline"
                    class="w-full justify-start font-normal bg-background border-input hover:bg-accent">
                    <Check v-if="modelValue" class="mr-2 h-4 w-4 text-green-500" />
                    <span :class="!modelValue ? 'text-muted-foreground' : ''">
                        {{ selectedName }}
                    </span>
                </Button>
            </DialogTrigger>

            <DialogContent class="sm:max-w-[600px] bg-background border-border">
                <DialogHeader>
                    <DialogTitle class="text-xl font-bold">
                        {{t('search')}} {{t('supplier')}}
                    </DialogTitle>
                </DialogHeader>

                <div class="space-y-4">
                    <!-- Buscador -->
                    <div class="relative">
                        <Search class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground" />
                        <Input v-model="manualSearch" :placeholder="t('search')+' '+t('suppliers')+'...'" class="pl-10" />
                    </div>

                    <!-- Tabla -->
                    <div class="rounded-md border border-border bg-card overflow-hidden">
                        <div class="max-h-80 overflow-auto">
                            <Table>
                                <TableHeader class="bg-muted/50 sticky top-0">
                                    <TableRow>
                                        <TableHead class="w-[80px]">#</TableHead>
                                        <TableHead>{{t('name')}}</TableHead>
                                    </TableRow>
                                </TableHeader>

                                <TableBody>
                                    <TableRow v-for="spl in paginatedSuppliers" :key="spl.id"
                                        class="cursor-pointer hover:bg-accent transition-colors"
                                        @click="selectSupplier(spl)">
                                        <TableCell class="text-muted-foreground">
                                            {{ spl.id }}
                                        </TableCell>
                                        <TableCell class="font-medium">
                                            {{ spl.first_name }} {{ spl.last_name }}
                                        </TableCell>
                                    </TableRow>

                                    <TableRow v-if="filteredSuppliers.length === 0">
                                        <TableCell colspan="2" class="text-center py-8 text-muted-foreground">
                                            {{t('no_suppliers')}}
                                        </TableCell>
                                    </TableRow>
                                </TableBody>
                            </Table>
                        </div>

                        <!-- Paginación -->
                        <div class="flex items-center justify-between p-2">
                            <span class="text-sm text-muted-foreground">
                                {{t('page')}} {{ currentPage }} {{t('of')}} {{ totalPages }}
                            </span>
                            <div class="flex gap-2">
                                <Button variant="outline" size="sm" :disabled="currentPage === 1"
                                    @click="currentPage--">
                                    {{t('former')}}
                                </Button>
                                <Button variant="outline" size="sm" :disabled="currentPage >= totalPages"
                                    @click="currentPage++">
                                    {{t('next')}}
                                </Button>
                            </div>
                        </div>
                    </div>


                </div>
            </DialogContent>
        </Dialog>

        <InputError :message="error" />
    </div>
</template>
