<template>
    <AuthenticatedLayout>
        <template #header>
            <div v-if="flash?.success" class="bg-green-800 text-white p-5 rounded mb-2">
                {{ flash.success }}
            </div>
            <h2 class="text-lg text-gray-900">
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
                        <tbody v-for="expense in expenses">
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
                                    {{ expense.created_at.slice(0,10) }}
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
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>

<script>
import AddIcon from '@/Components/Icons/AddIcon.vue';
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
        AddIcon
    },
    props: {
        expenses: Object,
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
