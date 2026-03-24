<template>
    <AuthenticatedLayout>
        <template #header>
            <div v-if="flash?.success" class="bg-green-800 text-white p-5 rounded mb-2">
                {{ flash.success }}
            </div>
        </template>
        <template #default>
            <div class="">

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
