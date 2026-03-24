<script setup>
import { ref, watch } from 'vue'
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
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
const props = defineProps({
    modelValue: [String, Number],
    categories: Object,
    initialName: String,
    error: String,
    label: String
})

const emit = defineEmits(['update:modelValue'])

const isOpen = ref(false)
const search = ref('')
const selectedName = ref(props.initialName || 'Seleccionar categoría...')
const fetchCategories = (url) => {
    if (!url) return
    router.get(url, { search: search.value }, {
        preserveState: true,
        preserveScroll: true,
        only: ['categories']
    })
}

watch(search, (value) => {
    router.get(window.location.pathname, { search: value }, {
        preserveState: true,
        replace: true,
        only: ['categories']
    })
})
watch(() => props.modelValue, (newVal) => {
    if (!newVal) selectedName.value = 'Seleccionar categoría...'
})
const selectCategory = (category) => {
    emit('update:modelValue', category.id)
    selectedName.value = category.name
    isOpen.value = false
}
</script>

<template>
    <div class="space-y-2">
        <Label class="text-foreground">{{  $t('category') }}</Label>

        <Dialog v-model:open="isOpen">
            <DialogTrigger as-child>
                <Button
                    variant="outline"
                    class="w-full justify-start font-normal bg-background border-input hover:bg-accent hover:text-accent-foreground"
                >
                    <Check v-if="modelValue" class="mr-2 h-4 w-4 text-green-500" />
                    <span :class="!modelValue ? 'text-muted-foreground' : 'text-foreground'">
                        {{ selectedName }}
                    </span>
                </Button>
            </DialogTrigger>

            <DialogContent class="sm:max-w-125 bg-background text-foreground border-border shadow-lg">
                <DialogHeader>
                    <DialogTitle class="text-foreground">{{  $t('search') }} {{  $t('category') }}</DialogTitle>
                </DialogHeader>

                <div class="py-4 space-y-4">
                    <div class="relative">
                        <Search class="absolute left-3 top-3 h-4 w-4 text-muted-foreground" />
                        <Input
                            v-model="search"
                            placeholder="Escribe para buscar..."
                            class="pl-10 bg-background border-input focus:ring-ring"
                        />
                    </div>

                    <div class="rounded-md border border-border  h-96 overflow-scroll">
                        <Table>
                            <TableHeader class="bg-muted/50">
                                <TableRow class="border-border hover:bg-transparent">
                                    <TableHead class="w-20">#</TableHead>
                                    <TableHead>{{  $t('name') }}</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow
                                    v-for="cat in categories.data"
                                    :key="cat.id"
                                    @click="selectCategory(cat)"
                                    class="cursor-pointer border-border hover:bg-accent hover:text-accent-foreground transition-colors"
                                >
                                    <TableCell class="font-medium text-muted-foreground">{{ cat.id }}</TableCell>
                                    <TableCell>{{ cat.name }}</TableCell>
                                </TableRow>

                                <TableRow v-if="categories.data.length === 0">
                                    <TableCell colspan="2" class="text-center py-8 text-muted-foreground">
                                       {{  $t('no_categories') }}
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </div>

                    <div class="flex items-center justify-center space-x-4 pt-2">
                        <Button
                            variant="outline"
                            size="sm"
                            :disabled="!categories.prev_page_url"
                            @click="fetchCategories(categories.prev_page_url)"
                            class="border-border hover:bg-secondary"
                        >
                            {{t('former')}}
                        </Button>
                        <span class="text-sm font-medium text-muted-foreground">
                            {{t('page')}} {{ categories.current_page }}
                        </span>
                        <Button
                            variant="outline"
                            size="sm"
                            :disabled="!categories.next_page_url"
                            @click="fetchCategories(categories.next_page_url)"
                            class="border-border hover:bg-secondary"
                        >
                            {{t('next')}}
                        </Button>
                    </div>
                </div>
            </DialogContent>
        </Dialog>

        <p v-if="error" class="text-sm text-destructive font-medium">{{ error }}</p>
    </div>
</template>
