<template>
    <AuthenticatedLayout>
        <template #Head>

        </template>
        <template #default>
            <div class="flex flex-col rounded-md mt-5 bg-gray-800">
                <div class="-m-1.5 overflow-x-auto">
                    <div class="p-1.5 min-w-full inline-block align-middle">
                        <div class="overflow-hidden">
                            <div class="flex mt-4 justify-between mx-2 ">
                                <input type="text" v-model="searchTerm" @input="sumbitFilters()"
                                    class="  px-4 block border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-900 dark:border-gray-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                    placeholder="Search...">

                                <Link :href="route('Expense.create')"
                                    class="py-1 px-3 mt-2   items-center gap-x-2 text-xl font-medium rounded-lg border border-transparent bg-purple-600 text-white hover:bg-purple-700 focus:outline-hidden focus:bg-purple-700 focus:outline-hidden focus:bg-purple-700 disabled:opacity-50 disabled:pointer-events-none">
                                +</Link>

                            </div>
                            <table class="min-w-full overflow-scroll divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-start text-xs font-medium text-white uppercase">
                                            #</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-start text-xs font-medium text-white uppercase">
                                            Title</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-start text-xs font-medium text-white uppercase">
                                            Amount</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-start text-xs font-medium text-white uppercase">
                                            Date</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-end text-xs font-medium text-white uppercase">
                                            Action </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <tr v-for="expense in filteredExpenses">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                                            {{ expense.id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                                            {{ expense.title }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                                            {{ expense.amount }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                                            {{ expense.date }}
                                        </td>
                                        <td
                                            class=" flex items-center justify-end gap-2 px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                            <Link :href="route('Expense.edit', expense.id)">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                                                stroke-width="1.5" class="size-6 text-yellow-500 hover:text-yellow-800"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                            </svg>
                                            </Link>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
export default {
    components: {
        AuthenticatedLayout,
        Head,
        Link,
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
