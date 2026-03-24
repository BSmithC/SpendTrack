<script setup>
import { ref, watch } from 'vue'
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogTrigger } from '@/Components/ui/dialog'
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/Components/ui/table'
import { Input } from '@/Components/ui/input'
import { Button } from '@/Components/ui/button'
import { Search } from 'lucide-vue-next'
import ProductIcon from './Icons/ProductIcon.vue'
import { computed } from 'vue'
import AddIcon from './Icons/AddIcon.vue'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
const props = defineProps({
    products: Object,
    label: String,
    current_view: String
})
const emit = defineEmits(['select'])

const isOpen = ref(false)
const manualSearch = ref('')
const currentPage = ref(1);
const itemsPerPage = 10;
const error = ref('');
const selectFromTable = (product) => {
    if (product.stock == 0 && props.current_view == 'bill') {
        error.value = t('errors.stock');
        return
    }
    emit('select', product)
    isOpen.value = false
    manualSearch.value = ''
    error.value = ''
}
const filteredProducts = computed(() => {
    const search = manualSearch.value.toLowerCase().trim()

    if (!search) return props.products

    return props.products.filter(prd => {
        return prd.name.toLowerCase().includes(search) ||
            prd.code.toLowerCase().includes(search) ||
            (prd.barcode && prd.barcode.toLowerCase().includes(search))
    })
})
const paginatedProducts = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage
    const end = start + itemsPerPage
    return filteredProducts.value.slice(start, end)
})
const totalPages = computed(() => {
    return Math.ceil(filteredProducts.value.length / itemsPerPage)
})
watch(manualSearch, () => {
    currentPage.value = 1
})
</script>

<template>
    <div class="space-y-2">
        <Dialog v-model:open="isOpen">
            <DialogTrigger as-child>
                <Button  class="bg-green-500 hover:bg-green-600 hover:text-white ">
                    <AddIcon />
                </Button>
            </DialogTrigger>

            <DialogContent class="sm:max-w-[700px] bg-background text-foreground border-border shadow-lg">
                <DialogHeader>
                    <DialogTitle class="text-xl font-bold">{{ t('search') +' '+ t('products') }}</DialogTitle>
                </DialogHeader>

                <div class="space-y-4">
                    <div class="relative">
                        <Search class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-muted-foreground" />
                        <Input v-model="manualSearch" :placeholder=" t('search') +' '+ t('products') +'...'"
                            class="pl-10 bg-background border-input" />
                    </div>

                    <div class="rounded-md border border-border bg-card overflow-hidden">
                        <div class="max-h-80 overflow-auto">
                            <Table>
                                <TableHeader class="bg-muted/50 sticky top-0 z-10">
                                    <TableRow class="border-border">
                                        <TableHead class="w-[100px]">{{t('code')}}</TableHead>
                                        <TableHead>{{t('product')}}</TableHead>
                                        <TableHead>{{t('price')}}</TableHead>
                                        <TableHead class="text-center">Stock</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    <TableRow v-for="prd in paginatedProducts" :key="prd.id"
                                        class="cursor-pointer border-border hover:bg-accent transition-colors"
                                        @click="selectFromTable(prd)">
                                        <TableCell class="font-mono text-xs text-muted-foreground">
                                            {{ prd.code }}
                                        </TableCell>
                                        <TableCell class="font-medium">
                                            {{ prd.name }}
                                        </TableCell>
                                        <TableCell class="whitespace-nowrap">
                                            RD$ {{ Number(prd.price).toLocaleString() }}
                                        </TableCell>
                                        <TableCell class="text-center">
                                            <span
                                                class="inline-flex bg-foreground items-center justify-center px-2.5 py-0.5 rounded-full text-xs font-bold"
                                                :class="{
                                                    'bg-red-100 text-red-700  dark:text-red-400': prd.state === 'agotado',
                                                    'bg-yellow-100 text-yellow-700  dark:text-yellow-400': prd.state === 'agotando',
                                                    'bg-green-100 text-green-700  dark:text-green-400': prd.state !== 'agotado' && prd.state !== 'agotando',
                                                }">
                                                {{ prd.stock }}
                                            </span>
                                        </TableCell>
                                    </TableRow>

                                    <TableRow v-if="filteredProducts.length === 0">
                                        <TableCell colspan="4" class="text-center text-muted-foreground py-10">
                                            {{t('no_products')}}
                                        </TableCell>
                                    </TableRow>
                                </TableBody>
                            </Table>
                        </div>
                         <div class="flex items-center justify-between py-2">
                                        <span class="text-sm text-muted-foreground">
                                            {{t('page')}} {{ currentPage }} de {{ totalPages }}
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

                    <p v-if="error" class="text-sm text-destructive font-semibold animate-pulse">
                        {{ error }}
                    </p>


                </div>
            </DialogContent>
        </Dialog>
    </div>
</template>
