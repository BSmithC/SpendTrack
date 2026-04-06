<template>
    <AuthenticatedLayout>
        <template #header>
            <div v-if="flash?.success" class="bg-green-800 text-white p-5 rounded mb-2">
                {{ flash.success }}
            </div>
            <h2 class="text-xl font-semibold">
                Expenses
            </h2>
            <Button class="ml-auto text-gray-700 bg-gray-50 border-b-2 border-gray-200">
                <Link :href="route('Expense.create')">
                New Expense
                </Link>
            </Button>
        </template>

        <template #default>
            <div class="mx-auto max-w-7xl justify-center py-10">
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
                                    Price
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Category
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Created At
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody v-for="expense in expenses.data">
                            <tr class="bg-white">
                                <th class="p-3 text-sm text-gray-700">
                                    {{ expense.id }}
                                </th>
                                <td class="p-3 text-sm text-gray-700">
                                    {{ expense.name }}
                                </td>
                                <td class="p-3 text-sm text-gray-700">
                                    {{ expense.description }}
                                </td>
                                <td class="p-3 text-sm text-gray-700">
                                    {{ expense.price }}
                                </td>
                                <td class="p-3 text-sm text-gray-700">
                                    {{ expense.name }}
                                </td>
                                <td class="p-3 text-sm text-gray-700">
                                    {{ expense.created_at.slice(0, 10) }}
                                </td>
                                <td class="p-3 text-sm text-gray-700">
                                    <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium"
                                        :class="expense.status
                                            ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                                            : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'">
                                        {{ expense.status ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="p-3 text-sm text-gray-700">
                                    <Button class="text-blue-500" variant="default">
                                        <Link :href="route('Expense.show', expense.id)">
                                        <EyeIcon />
                                        </Link>
                                    </Button>
                                    <Button class="text-yellow-500">
                                        <Link :href="route('Expense.edit', expense.id)">
                                        <EditIcon />
                                        </Link>
                                    </Button>
                                    <Button class="text-red-500">
                                        <Link :href="route('Expense.destroy', expense.id)" method="delete">
                                        <DeleteIcon />
                                        </Link>
                                    </Button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-if="expenses.total > expenses.per_page" class="flex items-center justify-between px-4 py-4">
                    <!-- Texto -->
                    <p class="text-sm text-muted-foreground">
                        Mostrando
                        <strong>{{ expenses.from }}</strong>
                        a
                        <strong>{{ expenses.to }}</strong>
                        de
                        <strong>{{ expenses.total }}</strong>
                        resultados
                    </p>
                    <!-- Controles -->
                    <div class="flex items-center gap-1">

                        <!-- First -->
                        <Button size="sm" variant="outline" as-child :disabled="expenses.current_page === 1">
                            <Link :href="expenses.first_page_url" preserve-scroll>
                            «
                            </Link>
                        </Button>

                        <!-- Prev -->
                        <Button size="sm" variant="outline" as-child :disabled="!expenses.prev_page_url">
                            <Link v-if="expenses.prev_page_url" :href="expenses.prev_page_url" preserve-scroll>
                            ‹
                            </Link>
                        </Button>

                        <!-- Pages -->
                        <Button v-for="link in expenses.links.slice(1, -1)" :key="link.label" size="sm"
                            :variant="link.active ? 'default' : 'outline'" as-child>
                            <Link v-if="link.url" :href="link.url" preserve-scroll v-html="link.label" />
                        </Button>

                        <!-- Next -->
                        <Button size="sm" variant="outline" as-child :disabled="!expenses.next_page_url">
                            <Link v-if="expenses.next_page_url" :href="expenses.next_page_url" preserve-scroll>
                            ›
                            </Link>
                        </Button>

                        <!-- Last -->
                        <Button size="sm" variant="outline" as-child
                            :disabled="expenses.current_page === expenses.last_page">
                            <Link :href="expenses.last_page_url" preserve-scroll>
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
import EditIcon from '@/Components/Icons/EditIcon.vue';
import EyeIcon from '@/Components/Icons/EyeIcon.vue';
import RestoreIcon from '@/Components/Icons/RestoreIcon.vue';
import Button from '@/Components/ui/button/Button.vue';
import { Pagination } from '@/Components/ui/pagination';
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
        Pagination,
        DeleteIcon,
        RestoreIcon
    },
    props: {
        expenses: Object,
        filter: Object,
    },
    data() {
        return {
            searchTerm: ref(''),
            filteredExpenses: this.expenses
        }
    },
    computed: {
        flash() {
            return this.$page.props.flash
        }
    },
    methods: {
        sumbitFilters() {
            if (!this.searchTerm) return this.expenses
            this.filteredExpenses = this.expenses.filter(e =>
                (e.title)
                    .toLowerCase()
                    .includes(this.searchTerm.toLocaleLowerCase())
            );
        }
    },
}
</script>
