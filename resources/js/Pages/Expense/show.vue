<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold">
                    Expense Details
                </h2>

            </div>
        </template>

        <template #default>
            <div class="mx-auto max-w-7xl justify-center py-8">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <!-- Header -->
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">
                            Expense Information
                        </h3>
                    </div>

                    <!-- Content -->
                    <div class="px-6 py-4">
                        <div class="space-y-4">
                            <!-- ID -->
                            <div class="flex items-center py-2 border-b border-gray-100">
                                <div class="w-1/3">
                                    <span class="text-sm font-medium text-gray-500">ID</span>
                                </div>
                                <div class="w-2/3">
                                    <span class="text-sm text-gray-900">{{ expense.id }}</span>
                                </div>
                            </div>

                            <!-- Name -->
                            <div class="flex items-center py-2 border-b border-gray-100">
                                <div class="w-1/3">
                                    <span class="text-sm font-medium text-gray-500">Name</span>
                                </div>
                                <div class="w-2/3">
                                    <span class="text-sm text-gray-900">{{ expense.name }}</span>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="flex items-center py-2 border-b border-gray-100">
                                <div class="w-1/3">
                                    <span class="text-sm font-medium text-gray-500">Description</span>
                                </div>
                                <div class="w-2/3">
                                    <span class="text-sm text-gray-900">{{ expense.description || 'No description'
                                        }}</span>
                                </div>
                            </div>

                            <!-- Price -->
                            <div class="flex items-center py-2 border-b border-gray-100">
                                <div class="w-1/3">
                                    <span class="text-sm font-medium text-gray-500">Price</span>
                                </div>
                                <div class="w-2/3">
                                    <span class="text-sm font-semibold text-green-600">${{ expense.price }}</span>
                                </div>
                            </div>

                            <!-- Category -->
                            <div class="flex items-center py-2 border-b border-gray-100">
                                <div class="w-1/3">
                                    <span class="text-sm font-medium text-gray-500">Category</span>
                                </div>
                                <div class="w-2/3">
                                    <span class="text-sm text-gray-900">{{ expense.category?.name || 'N/A' }}</span>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="flex items-center py-2 border-b border-gray-100">
                                <div class="w-1/3">
                                    <span class="text-sm font-medium text-gray-500">Status</span>
                                </div>
                                <div class="w-2/3">
                                    <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium"
                                        :class="expense.status
                                            ? 'bg-green-100 text-green-800'
                                            : 'bg-red-100 text-red-800'">
                                        {{ expense.status ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Created At -->
                            <div class="flex items-center py-2 border-b border-gray-100">
                                <div class="w-1/3">
                                    <span class="text-sm font-medium text-gray-500">Created At</span>
                                </div>
                                <div class="w-2/3">
                                    <span class="text-sm text-gray-900">{{ expense.created_at?.slice(0, 10) }}</span>
                                </div>
                            </div>

                            <!-- Updated At -->
                            <div class="flex items-center py-2">
                                <div class="w-1/3">
                                    <span class="text-sm font-medium text-gray-500">Last Updated</span>
                                </div>
                                <div class="w-2/3">
                                    <span class="text-sm text-gray-900">{{ expense.updated_at?.slice(0, 10) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                        <Button variant="outline">
                            <Link :href="route('Expense.index')">
                            Close
                            </Link>
                        </Button>
                    </div>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Button from '@/Components/ui/button/Button.vue';
import EditIcon from '@/Components/Icons/EditIcon.vue';

export default {
    components: {
        AuthenticatedLayout,
        Link,
        Head,
        Button,
        EditIcon,
    },
    props: {
        expense: Object,
    }
}
</script>
