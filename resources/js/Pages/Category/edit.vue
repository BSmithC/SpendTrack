<template>
    <AuthenticatedLayout>
        <template #header>

        </template>
        <template #default>
            <div class="max-w-sm space-y-3 mx-auto p-5 bg-gray-800 rounded-lg text-white">
                <form @submit.prevent="submit">
                    <div class="relative">
                        <input type="text" v-model="form.name"
                            class="peer py-2.5 sm:py-3 pe-0 ps-8 block w-full bg-transparent border-t-transparent border-b-2 border-x-transparent border-b-gray-200 sm:text-sm focus:border-t-transparent focus:border-x-transparent focus:border-b-purple-500 focus:ring-0 disabled:opacity-50 disabled:pointer-events-none dark:border-b-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 dark:focus:border-b-neutral-600"
                            placeholder="Enter name">
                        <div
                            class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-2 peer-disabled:opacity-50 peer-disabled:pointer-events-none">
                            <svg class="shrink-0 size-4  " xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                    </div>

                    <div class="relative">
                        <input type="text" v-model="form.description"
                            class="peer py-2.5 sm:py-3 pe-0 ps-8 block w-full bg-transparent border-t-transparent border-b-2 border-x-transparent border-b-gray-200 sm:text-sm focus:border-t-transparent focus:border-x-transparent focus:border-b-purple-500 focus:ring-0 disabled:opacity-50 disabled:pointer-events-none dark:border-b-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 dark:focus:border-b-neutral-600"
                            placeholder="Enter password">
                        <div
                            class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-2 peer-disabled:opacity-50 peer-disabled:pointer-events-none">
                            <svg class="shrink-0 size-4  " xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 18v3c0 .6.4 1 1 1h4v-3h3v-3h2l1.4-1.4a6.5 6.5 0 1 0-4-4Z"></path>
                                <circle cx="16.5" cy="7.5" r=".5"></circle>
                            </svg>
                        </div>
                    </div>
                    <div class="flex justify-end gap-2">
                        <Link :href="route('Category.index')"
                            class="py-3 px-4 mt-5 flex  items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-purple-600 text-white hover:bg-purple-700 focus:outline-hidden focus:bg-purple-700 focus:outline-hidden focus:bg-purple-700 disabled:opacity-50 disabled:pointer-events-none">
                        Cancelar
                        </Link>

                        <button type="submit"
                            class="py-3 px-4 mt-5 flex  items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-purple-600 text-white hover:bg-purple-700 focus:outline-hidden focus:bg-purple-700 focus:outline-hidden focus:bg-purple-700 disabled:opacity-50 disabled:pointer-events-none">
                            Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </template>
    </AuthenticatedLayout>
</template>
<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

export default {
    components: {
        AuthenticatedLayout,
        Head
    },
    props: {
        category: Object,
    },
    methods: {
        submit() {
            this.form.put(route('Category.update',this.category));
        }
    },
    data() {
        return {
            form: useForm({
                name: this.category.name || '',
                description: this.category.description || '',
            })
        };
    }
}
</script>
