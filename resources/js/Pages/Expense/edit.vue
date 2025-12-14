<template>
    <AuthenticatedLayout>
        <template #header>

        </template>
        <template #default>
            <form @submit.prevent="submit">
                <div class="space-y-12">
                    <div class="border-b border-white/10 pb-12">
                        <div class=" mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-4">
                                <label for="username" class="block text-sm/6 font-medium text-white">Title</label>
                                <div class="mt-2">
                                    <div
                                        class="flex items-center rounded-md bg-white/5 pl-3 outline-1 -outline-offset-1 outline-white/10 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-500">
                                        <input type="text" v-model="form.title"
                                            class="block min-w-0 grow bg-transparent py-1.5 pr-3 pl-1 text-base text-white placeholder:text-gray-500 focus:outline-none sm:text-sm/6"
                                            placeholder="janesmith" />
                                    </div>
                                </div>
                            </div>
                            <div class="sm:col-span-2">
                                <label for="username" class="block text-sm/6 font-medium text-white">Date</label>
                                <div class="mt-2">
                                    <div
                                        class="flex items-center rounded-md bg-white/5 pl-3 outline-1 -outline-offset-1 outline-white/10 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-500">
                                        <input type="date" v-model="form.date"
                                            class="block min-w-0 grow bg-transparent py-1.5 pr-3 pl-1 text-base text-white placeholder:text-gray-500 focus:outline-none sm:text-sm/6"
                                            placeholder="janesmith" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-full">
                                <label for="about" class="block text-sm/6 font-medium text-white">Amount</label>
                                <div class="mt-2">
                                    <input type="number" v-model="form.amount"
                                        class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6"></input>
                                </div>
                                <p class="mt-3 text-sm/6 text-gray-400">Write a few sentences about yourself.</p>
                            </div>
                            <select v-model="form.category_id">
                                <option v-for="category in categories" :key="category.id" :value="category.id">
                                    {{ category.name }}
                                </option>
                            </select>

                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <button type="button" class="text-sm/6 font-semibold text-white">Cancel</button>
                    <button type="submit"
                        class="rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Save</button>
                </div>
            </form>
        </template>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

export default {
    components: {
        AuthenticatedLayout,
        Head,
    },
    props: {
        expense: Object,
        categories: Object,
    },
    data() {
        return {
            form: useForm({
                category_id: this.expense.category_id || '',
                title: this.expense.title || '',
                amount: this.expense.amount || '',
                date: this.expense.date || '',
            })
        };
    },
    methods: {
        submit() {
            this.form.put(route('Expense.update', this.expense));
        }
    }
}
</script>
