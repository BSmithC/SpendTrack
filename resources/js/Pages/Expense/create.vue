<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold">
                Create Expense
            </h2>
        </template>
        <template #default>
            <div class="p-6 max-w-4xl mx-auto ">
                <form @submit.prevent="submit">
                    <div class="rounded-xl border-foregroundbg-background p-6 space-y-6">

                        <div class="grid grid-cols-3 gap-2">
                            <div>
                                <Label for="name">Name<span class="text-red-500"> *</span></Label>
                                <Input id="name" v-model="form.name" type="text" placeholder="Name" />
                                <InputError :message="form.errors.name" />
                            </div>

                            <div>
                                <Label for="Price">Price<span class="text-red-500"> *</span></Label>
                                <Input id="Price" v-model="form.price" type="number" placeholder="0.00" />
                                <InputError :message="form.errors.description" />
                            </div>

                            <div>
                                <Label for="category">Category <span class="text-red-500"> *</span></Label>
                                <Select v-model="form.category_id">
                                    <SelectTrigger class="w-full ">
                                        <SelectValue placeholder="Select the category for the expense" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem v-for="category in categories" :key="category.id"
                                            :value="category.id">{{ category.name }}</SelectItem>
                                    </SelectContent>
                                </Select>
                            </div>
                        </div>

                        <div>
                            <Label for="description">Description<span class="text-red-500"> *</span></Label>
                            <Textarea id="description" v-model="form.description" type="text"
                                placeholder="Detalles de la description..." />
                            <InputError :message="form.errors.description" />
                        </div>

                    </div>

                    <div class="mt-6 flex items-center justify-end gap-x-6">
                        <Button variant="outline" as-child>
                            <Link :href="route('Expense.index')">
                            Cancel
                            </Link>
                        </Button>

                        <Button variant="outline" type="submit">
                            Save
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
import Select from '@/Components/ui/select/Select.vue';
import SelectContent from '@/Components/ui/select/SelectContent.vue';
import SelectItem from '@/Components/ui/select/SelectItem.vue';
import SelectTrigger from '@/Components/ui/select/SelectTrigger.vue';
import SelectValue from '@/Components/ui/select/SelectValue.vue';
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
        Input,
        Select,
        SelectContent,
        SelectTrigger,
        SelectValue,
        SelectItem
    },
    props: {
        categories: Object
    },

    data() {
        return {
            form: useForm({
                name: '',
                description: '',
                price: 0,
                category_id: null,
            })
        };
    },
    methods: {
        submit() {
            this.form.post(route('Expense.store'));
        }
    },
}

</script>
