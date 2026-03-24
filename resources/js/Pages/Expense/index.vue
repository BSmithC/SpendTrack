<template>
    <AuthenticatedLayout>
        <template #Head>

        </template>
        <template #default>
            <div class="flex justify-center">
                <div class="flex grid-colum">
                    <table class="w-full ">
                        <thead class="">
                            <tr>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Product name
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Color
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Category
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Price
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Stock
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="">
                                <th scope="row" class="">
                                    Apple MacBook Pro 17"
                                </th>
                                <td class="px-6 py-4">
                                    Silver
                                </td>
                                <td class="px-6 py-4">
                                    Laptop
                                </td>
                                <td class="px-6 py-4">
                                    $2999
                                </td>
                                <td class="px-6 py-4">
                                    231
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
