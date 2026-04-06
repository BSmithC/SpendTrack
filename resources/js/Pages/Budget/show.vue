<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold">
                    Budget Details
                </h2>
            </div>
        </template>

        <template #default>
            <div class="mx-auto max-w-7xl justify-center py-8">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="border-t border-gray-200">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800">
                                Budget Information
                            </h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Amount</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Quantity</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Total</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <tr v-for="detail in budget.details" :key="detail.id">
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ detail.name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900">${{ detail.amount }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ detail.quantity }}</td>
                                        <td class="px-6 py-4 text-sm font-semibold text-green-600">${{ detail.total }}
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot class="bg-gray-50">
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-right font-semibold text-gray-900">Grand
                                            Total:</td>
                                        <td class="px-6 py-4 text-sm font-bold text-green-600">${{ budget.total }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                        <Button variant="outline">
                            <Link :href="route('Budget.index')">
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
        budget: Object,
    }
}
</script>
