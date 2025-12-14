<template>
    <AuthenticatedLayout>
        <template #header>
            <div v-if="flash?.success" class="bg-green-800 text-white p-5 rounded mb-2">
                {{ flash.success }}
            </div>
        </template>
        <template #default>
            <div class="mb-4 flex flex-col rounded-md mt-5 bg-gray-800">
                <div class="-m-1.5 overflow-x-auto">
                    <div class="p-1.5 min-w-full inline-block align-middle">
                        <div class="overflow-hidden">
                            <div class="flex mt-4 justify-between mx-2 ">

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
                                            Name</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-start text-xs font-medium text-white uppercase">
                                            Description</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-end text-xs font-medium text-white uppercase">
                                            Action </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                                            {{ category.id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                                            {{ category.name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                                            {{ category.description }}
                                        </td>
                                        <td
                                            class=" flex items-center justify-end gap-2 px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                            <Link :href="route('Category.edit', category.id)">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                                                stroke-width="1.5" class="size-6 text-yellow-500 hover:text-yellow-800"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                            </svg>
                                            </Link>
                                            <button @click="deleteCategory()" type="button">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    stroke="currentColor" stroke-width="1.5"
                                                    class="size-6 inline-flex items-center text-red-500 hover:text-red-800"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21q.512.078 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48 48 0 0 0-3.478-.397m-12 .562q.51-.089 1.022-.165m0 0a48 48 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a52 52 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a49 49 0 0 0-7.5 0" />
                                                </svg>
                                            </button>
                                            <button @click="restoreCategory()" type="button">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    stroke="currentColor" stroke-width="1.5"
                                                    class="size-6 text-green-500 hover:text-green-800"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-4 gap-5">
                <div v-for="expenses in category.expense" class="bg-gray-800 max-w-sm rounded shadow-lg px-6 py-4">
                    <div class="flex justify-between">
                        <div class=" text-white font-bold text-xl mb-2"> Expense #{{ expenses.id }}</div>
                        <Link :href="route('Expense.edit', expenses.id)">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="1.5"
                            class="size-6 text-yellow-600 hover:text-yellow-800" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                        </svg>
                        </Link>
                    </div>

                    <ul role="list" class="divide-y divide-default">
                        <li class="py-4 sm:py-4">
                            <div class="flex items-center gap-2">
                                <div class="flex-1 min-w-0 ms-2">
                                    <p class="text-white font-medium text-heading truncate">
                                        {{ expenses.title }}
                                    </p>
                                    <p class="text-white text-sm text-body truncate">
                                        {{ expenses.date }}
                                    </p>
                                </div>
                                <div class=" text-white inline-flex items-center font-medium text-heading">
                                    {{ expenses.amount }}
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

        </template>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router} from '@inertiajs/vue3';
import ApexCharts from 'apexcharts'

export default {
    components: {
        AuthenticatedLayout,
        Head,
        Link,
        ApexCharts,
    },
    computed: {
        flash() {
            return this.$page.props.flash
        }
    },
    props: {
        category: Object,
    },
    methods: {
        deleteCategory() {
            router.delete('Category.destroy');
        },
        restoreCategory() {
            router.put('Category.update', { status: 1 });
        }
    }
}
</script>
