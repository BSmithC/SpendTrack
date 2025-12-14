<template>
    <AuthenticatedLayout>
        <template #header>
            <div v-if="flash?.success" class="bg-green-800 text-white p-5 rounded mb-2">
                {{ flash.success }}
            </div>
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

                                <Link :href="route('Category.create')"
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
                                    <tr v-for="category in filteredCategories">
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
                                            <Link :href="route('Category.show', category.id)">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                                                stroke-width="1.5" class="size-6 text-blue-500 hover:text-blue-800"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.036 12.322a1 1 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
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
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

export default {
    components: {
        AuthenticatedLayout,
        Head,
        Link,
    },
    computed: {
        flash() {
            return this.$page.props.flash
        }
    },
    props: {
        categories: Object,
    },
    data() {
        return {
            searchTerm: ref(''),
            filteredCategories: this.categories
        }
    },
    methods: {
        sumbitFilters() {
            if (!this.searchTerm) return this.categories
            this.filteredCategories = this.categories.filter(c =>
                (c.name || c.description).toLowerCase().includes(this.searchTerm.toLocaleLowerCase())
            );
            console.log(this.filteredCategories);
        },

        deleteCategory() {
            router.delete('Category.destroy');
        },
        restoreCategory() {
            router.put('Category.update', { status: 1 });
        }
    }
}
</script>
