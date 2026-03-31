<template>
    <AuthenticatedLayout>
        <template #header>
            <div v-if="flash?.success" class="bg-green-800 text-white p-5 rounded mb-2">
                {{ flash.success }}
            </div>
            <h2 class="text-xl font-semibold">
                Categories
            </h2>
            <Button class="ml-auto text-gray-700 bg-gray-50 border-b-2 border-gray-200">
                <Link :href="route('Category.create')">
                New Category
                </Link>
            </Button>
        </template>

        <template #default>
            <div class="mx-auto max-w-7xl justify-center py-10">
                <div>

                </div>
                <div class="overflow-auto rounded-xl shadow">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b-2 border-gray-200">
                            <tr class="p-3 text-sm font-semibold tracking-wider text-left">
                                <th scope="col" class="px-6 py-3 font-medium">
                                    ID
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Description
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody v-for="category in categories.data">
                            <tr class="bg-white">
                                <th class="p-3 text-sm text-gray-700">
                                    {{ category.id }}
                                </th>
                                <td class="p-3 text-sm text-gray-700">
                                    {{ category.name }}
                                </td>
                                <td class="p-3 text-sm text-gray-700">
                                    {{ category.description }}
                                </td>
                                <td class="p-3 text-sm text-gray-700">
                                    <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium"
                                        :class="category.status
                                            ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                                            : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'">
                                        {{ category.status ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="p-3 text-sm text-gray-700">
                                    <Button class="text-blue-500" variant="default">
                                        <Link :href="route('Category.show', category.id)">
                                        <EyeIcon />
                                        </Link>
                                    </Button>
                                    <Button class="text-yellow-500">
                                        <Link :href="route('Category.edit', category.id)">
                                        <EditIcon />
                                        </Link>
                                    </Button>
                                    <Button class="text-red-500">
                                        <DeleteIcon />
                                    </Button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-if="categories.total > categories.per_page" class="flex items-center justify-between px-4 py-4">
                    <!-- Texto -->
                    <p class="text-sm text-muted-foreground">
                        Mostrando
                        <strong>{{ categories.from }}</strong>
                        a
                        <strong>{{ categories.to }}</strong>
                        de
                        <strong>{{ categories.total }}</strong>
                        resultados
                    </p>
                    <!-- Controles -->
                    <div class="flex items-center gap-1">

                        <!-- First -->
                        <Button size="sm" variant="outline" as-child :disabled="categories.current_page === 1">
                            <Link :href="categories.first_page_url" preserve-scroll>
                            «
                            </Link>
                        </Button>

                        <!-- Prev -->
                        <Button size="sm" variant="outline" as-child :disabled="!categories.prev_page_url">
                            <Link v-if="categories.prev_page_url" :href="categories.prev_page_url" preserve-scroll>
                            ‹
                            </Link>
                        </Button>

                        <!-- Pages -->
                        <Button v-for="link in categories.links.slice(1, -1)" :key="link.label" size="sm"
                            :variant="link.active ? 'default' : 'outline'" as-child>
                            <Link v-if="link.url" :href="link.url" preserve-scroll v-html="link.label" />
                        </Button>

                        <!-- Next -->
                        <Button size="sm" variant="outline" as-child :disabled="!categories.next_page_url">
                            <Link v-if="categories.next_page_url" :href="categories.next_page_url" preserve-scroll>
                            ›
                            </Link>
                        </Button>

                        <!-- Last -->
                        <Button size="sm" variant="outline" as-child
                            :disabled="categories.current_page === categories.last_page">
                            <Link :href="categories.last_page_url" preserve-scroll>
                            »
                            </Link>
                        </Button>
                    </div>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>

<script>
import AddIcon from '@/Components/Icons/AddIcon.vue';
import DeleteIcon from '@/Components/Icons/DeleteIcon.vue';
import RestoreIcon from '@/Components/Icons/RestoreIcon.vue';
import EditIcon from '@/Components/Icons/EditIcon.vue';
import EyeIcon from '@/Components/Icons/EyeIcon.vue';
import Button from '@/Components/ui/button/Button.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
export default {
    components: {
        AuthenticatedLayout,
        Head,
        Link,
        EditIcon,
        Button,
        EyeIcon,
        AddIcon,
        DeleteIcon,
        RestoreIcon
    },
    props: {
        categories: Object,
    },
    data() {
        return {
            searchTerm: ref(''),
            filteredExpenses: this.categories
        }
    },
    computed: {
        flash() {
            return this.$page.props.flash
        }
    },
    methods: {
        sumbitFilters() {
            if (!this.searchTerm) return this.categories
            this.filteredExpenses = this.categories.filter(e =>
                (e.title)
                    .toLowerCase()
                    .includes(this.searchTerm.toLocaleLowerCase())
            );
        }
    },
}
</script>
