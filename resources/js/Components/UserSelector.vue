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
    users: Object,
    initialName: String,
    error: String,
    label: String
})

const emit = defineEmits(['update:modelValue'])

const isOpen = ref(false)
const search = ref('')
const selectedName = ref(props.initialName || 'Seleccionar usuario...')
const fetchUsers = (url) => {
    if (!url) return
    router.get(url, { search: search.value }, {
        preserveState: true,
        preserveScroll: true,
        only: ['users']
    })
}

watch(search, (value) => {
    router.get(window.location.pathname, { search: value }, {
        preserveState: true,
        replace: true,
        only: ['users']
    })
})
watch(() => props.modelValue, (newVal) => {
    if (!newVal) selectedName.value = 'Seleccionar usuario...'
})
const selectUser = (product) => {
    emit('update:modelValue', product.id)
    selectedName.value = product.name
    isOpen.value = false
}
</script>

<template>
    <div class="space-y-2">
        <Label class="text-foreground">{{ label || 'Usuario' }}</Label>

        <Dialog v-model:open="isOpen">
            <DialogTrigger as-child>
                <Button variant="outline"
                    class="w-full justify-start font-normal bg-background border-input hover:bg-accent hover:text-accent-foreground">
                    <Check v-if="modelValue" class="mr-2 h-4 w-4 text-green-500" />
                    <span :class="!modelValue ? 'text-muted-foreground' : 'text-foreground'">
                        {{ selectedName }}
                    </span>
                </Button>
            </DialogTrigger>

            <DialogContent class="sm:max-w-[500px] bg-background text-foreground border-border shadow-lg">
                <DialogHeader>
                    <DialogTitle class="text-foreground">{{t('search')}} {{t('User')}}</DialogTitle>
                </DialogHeader>

                <div class="py-4 space-y-4">
                    <div class="relative">
                        <Search class="absolute left-3 top-3 h-4 w-4 text-muted-foreground" />
                        <Input v-model="search" :placeholder="t('search') + ' '+ $t('users')+'...'"
                            class="pl-10 bg-background border-input" />
                    </div>

                    <div class="rounded-md border border-border bg-card overflow-hidden">
                        <Table>
                            <TableHeader class="bg-muted/50">
                                <TableRow class="border-border">
                                    <TableHead class="w-[70px]">#</TableHead>
                                    <TableHead>{{t('name')}}</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow v-for="usr in users.data" :key="usr.id" @click="selectUser(usr)"
                                    class="cursor-pointer border-border hover:bg-accent transition-colors">
                                    <TableCell class="font-medium text-muted-foreground">{{ usr.id }}</TableCell>
                                    <TableCell>{{ usr.first_name }}</TableCell>
                                </TableRow>

                                <TableRow v-if="users.data.length === 0">
                                    <TableCell colspan="2" class="text-center py-8 text-muted-foreground">
                                       {{t('no_users')}}
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </div>

                    <div class="flex items-center justify-center space-x-4">
                        <Button variant="outline" size="sm" :disabled="!users.prev_page_url"
                            @click="fetchUsers(users.prev_page_url)" class="border-border hover:bg-secondary">
                            {{t('former')}}
                        </Button>
                        <span class="text-sm font-medium text-muted-foreground">
                            {{t('page')}} {{ users.current_page }}
                        </span>
                        <Button variant="outline" size="sm" :disabled="!users.next_page_url"
                            @click="fetchUsers(users.next_page_url)" class="border-border hover:bg-secondary">
                            {{t('next')}}
                        </Button>
                    </div>
                </div>
            </DialogContent>
        </Dialog>

        <p v-if="error" class="text-sm text-destructive font-medium">{{ error }}</p>
    </div>
</template>
