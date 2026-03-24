<script setup>
import { ref, computed, watch } from 'vue'

import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogTrigger
} from '@/Components/ui/dialog'

import {
    Card,
    CardHeader,
    CardContent
} from '@/Components/ui/card'

import { Input } from '@/Components/ui/input'
import { Button } from '@/Components/ui/button'

import { Search } from 'lucide-vue-next'

import AddIcon from './Icons/AddIcon.vue'
import DeleteIcon from './Icons/DeleteIcon.vue'
import EditIcon from './Icons/EditIcon.vue'
import PrintIcon from './Icons/PrintIcon.vue'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
/* ======================
   Props / Emits
====================== */
const props = defineProps({
    recipes: {
        type: Array,
        default: () => []
    },
    label: String,
    current_view: String
})

const emit = defineEmits(['select'])


/* ======================
   State
====================== */
const isOpen = ref(false)
const manualSearch = ref('')
const currentPage = ref(1)

const itemsPerPage = 10
const error = ref('')

const openRecipe = ref(null)
const tooltipSide = ref('right')


/* ======================
   Helpers
====================== */
const formatCurrency = (value) =>
    new Intl.NumberFormat('es-DO', {
        style: 'currency',
        currency: 'DOP'
    }).format(value ?? 0)

const formatDate = (date) =>
    new Date(date).toLocaleDateString()


/* ======================
   Filtering
====================== */
const filteredRecipes = computed(() => {
    const search = manualSearch.value.toLowerCase().trim()

    if (!search) return props.recipes

    return props.recipes.filter(r =>
        r.title?.toLowerCase().includes(search) ||
        String(r.id).includes(search)
    )
})


/* ======================
   Pagination
====================== */
const totalPages = computed(() =>
    Math.max(1, Math.ceil(filteredRecipes.value.length / itemsPerPage))
)

const paginatedRecipes = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage
    return filteredRecipes.value.slice(start, start + itemsPerPage)
})

watch(manualSearch, () => {
    currentPage.value = 1
})


/* ======================
   Actions
====================== */
const selectFromTable = (recipe) => {
    emit('select', recipe)
    isOpen.value = false
    manualSearch.value = ''
    error.value = ''
}

const confirmDelete = (id) => {
    console.log('delete', id)
}

const print = (recipe) => {
    console.log('print', recipe)
}


/* ======================
   Tooltip
====================== */
const handleMouseEnter = (event, recipeId) => {
    openRecipe.value = recipeId

    const rect = event.currentTarget.getBoundingClientRect()
    const tooltipWidth = 300

    tooltipSide.value =
        window.innerWidth - rect.right < tooltipWidth ? 'left' : 'right'
}
</script>


<template>
    <div class="space-y-2">
        <Dialog v-model:open="isOpen">
            <DialogTrigger as-child>
                <Button class="bg-green-500 hover:bg-green-600 text-white cursor-pointer">
                    <AddIcon />
                </Button>
            </DialogTrigger>

            <DialogContent class="sm:max-w-300 bg-background">
                <DialogHeader>
                    <DialogTitle class="text-xl font-bold">
                        Buscar Receta
                    </DialogTitle>
                </DialogHeader>

                <!-- Search -->
                <div class="relative mb-4">
                    <Search class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4" />
                    <Input v-model="manualSearch" placeholder="Buscar por nombre o código..." class="pl-10" />
                </div>


                <div
                    class="max-h-[85vh] overflow-y-auto p-4 space-y-4 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-transparent">

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                        <div v-for="recipe in paginatedRecipes" :key="recipe.id" class="relative group"
                            @mouseenter="handleMouseEnter($event, recipe.id)" @mouseleave="openRecipe = null">

                            <Card
                                class="h-full border border-gray-100 bg-white rounded-xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden cursor-pointer"
                                @click="selectFromTable(recipe)">

                                <CardHeader class="p-0 relative h-48 overflow-hidden">
                                    <img :src="recipe.img ? `/storage/${recipe.img}` : 'https://static.spotapps.co/website_images/ab_websites/174603_website_v1/menu.jpg'"
                                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                        alt="Recipe Image" />

                                    <div
                                        class="absolute top-2 right-2 w-8 h-8 rounded-full bg-white border flex items-center justify-center text-sm font-bold shadow">
                                        {{ recipe.id }}
                                    </div>

                                    <div
                                        class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300">
                                    </div>
                                </CardHeader>

                                <CardContent class="p-5 flex flex-col justify-between h-[calc(100%-12rem)]">
                                    <div>
                                        <h3 class="font-bold text-lg text-gray-800 leading-tight mb-1 line-clamp-2"
                                            :title="recipe.title">
                                            {{ recipe.title }}
                                        </h3>
                                        <p class="text-xs text-gray-400 flex items-center gap-1 mb-4">
                                            {{ formatDate(recipe.created_at) }}
                                        </p>
                                    </div>

                                    <div class="flex items-end justify-between border-t border-gray-100 pt-3 mt-2">
                                        <div class="flex flex-col">
                                            <span class="text-xs text-gray-500 uppercase tracking-wide">Costo</span>
                                            <span class="font-medium text-gray-600">{{ formatCurrency(recipe.cost)
                                            }}</span>
                                        </div>
                                        <div class="flex flex-col items-end">
                                            <span class="text-xs text-gray-500 uppercase tracking-wide">Precio</span>
                                            <span class="font-bold text-lg text-emerald-600">{{
                                                formatCurrency(recipe.price) }}</span>
                                        </div>
                                    </div>
                                </CardContent>
                            </Card>
                        </div>
                    </div>
                </div>


                <!-- Pagination -->
                <div class="flex justify-between items-center mt-4">
                    <span class="text-sm">
                        {{t('page')}} {{ currentPage }} {{t('of')}} {{ totalPages }}
                    </span>

                    <div class="flex gap-2">
                        <Button variant="outline" size="sm" :disabled="currentPage === 1" @click="currentPage--">
                            {{t('former')}}
                        </Button>

                        <Button variant="outline" size="sm" :disabled="currentPage >= totalPages"
                            @click="currentPage++">
                            {{t('next')}}
                        </Button>
                    </div>
                </div>
            </DialogContent>
        </Dialog>
    </div>
</template>
