<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-lg text-gray-800">
                Edit expense
            </h2>
        </template>
        <template #default>
            <div class="p-6 max-w-4xl mx-auto ">
                <form @submit.prevent="submit">
                    <div class="rounded-xl border-foregroundbg-background p-6 space-y-6">

                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <Label for="name">Name<span class="text-red-500"> *</span></Label>
                                <Input id="name" v-model="form.name" type="text" placeholder="Name" />
                                <InputError :message="form.errors.name" />
                            </div>

                            <div>
                                <Label for="description">Description<span class="text-red-500"> *</span></Label>
                                <Textarea id="description" v-model="form.description" type="text"
                                    placeholder="Detalles de la description..." />
                                <InputError :message="form.errors.description" />
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-x-6">
                        <Button class="bg-gray-100" type="submit">
                            Save
                        </Button>
                        <Button class="bg-gray-100">
                            <Link :href="route('expense.index')">
                            Cancel
                            </Link>
                        </Button>
                    </div>
                </form>
            </div>
        </template>
    </AuthenticatedLayout>
</template>
<script>
import InputError from '@/Components/InputError.vue';
import Button from '@/Components/ui/button/Button.vue';
import Input from '@/Components/ui/input/Input.vue';
import Label from '@/Components/ui/label/Label.vue';
import Textarea from '@/Components/ui/textarea/Textarea.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';


export default {
    components: {
        AuthenticatedLayout,
        Head,
        Link,
        Button,
        InputError,
        Label,
        Textarea,
        Input
    },
    props: {
        expense: Object,
    },
    data() {
        return {
            form: useForm({
                name: this.expense.name || '',
                description: this.expense.description || '',
            })
        };
    },
    methods: {
        submit() {
            this.form.put(route('Expense.update', this.expense));
        }
    },
}

</script>
