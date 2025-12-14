<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { App, Head } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({
    kpis: Object,
    expensesByCategory: Array,
})
const series = computed(() => [{
    data: props.expensesByCategory.map(item => ({
        x: item.category,
        y: item.total
    }))
}])
const chartOptions = computed(() => ({
    chart: {
        type: 'bar',
        height: 350,
        toolbar: { show: false }
    },
    plotOptions: {
        bar: {
            columnWidth: '45%',
            distributed: true,
        }
    },
    dataLabels: {
        enabled: false,
    },
    legend: {
        show: false
    },
    colors: [
        '#22c55e', '#84cc16', '#eab308',
        '#f97316', '#14b8a6', '#3b82f6'
    ],
    xaxis: {
        type: 'category',
        labels: {
            style: {
                fontSize: '12px'
            }
        }
    },
    tooltip: {
        y: {
            formatter: val =>
                new Intl.NumberFormat('es-DO', {
                    style: 'currency',
                    currency: 'DOP'
                }).format(val)
        }
    }
}))

const formatCurrency = (value) => {
    return new Intl.NumberFormat('es-DO', {
        style: 'currency',
        currency: 'DOP'
    }).format(value)
}
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">

                <!-- KPIs -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                    <!-- Total Expenses -->
                    <div class="bg-red-100 dark:bg-red-900 rounded-xl p-6 shadow">
                        <p class="text-sm text-red-800 dark:text-red-200">
                            Total Expenses
                        </p>
                        <p class="text-2xl font-bold text-green-900 dark:text-white">
                            {{ formatCurrency(kpis.totalExpenses) }}
                        </p>
                    </div>

                    <!-- Expenses Count -->
                    <div class="bg-blue-50 dark:bg-blue-800 rounded-xl p-6 shadow">
                        <p class="text-sm text-blue-700 dark:text-blue-200">
                            Expenses Count
                        </p>
                        <p class="text-2xl font-bold text-green-900 dark:text-white">
                            {{ kpis.expensesCount }}
                        </p>
                    </div>

                    <!-- Categories -->
                    <div class="bg-yellow-100 dark:bg-yellow-500 rounded-xl p-6 shadow">
                        <p class="text-sm text-yellow-800 dark:text-yellow-200">
                            Categories
                        </p>
                        <p class="text-2xl font-bold text-yellow-900 dark:text-white">
                            {{ kpis.categoriesCount }}
                        </p>
                    </div>

                    <!-- Expenses This Month -->
                    <div class="bg-green-200 dark:bg-green-700 rounded-xl p-6 shadow">
                        <p class="text-sm text-green-800 dark:text-green-200">
                            Expenses This Month
                        </p>
                        <p class="text-2xl font-bold text-green-900 dark:text-white">
                            {{ formatCurrency(kpis.expensesThisMonth) }}
                        </p>
                    </div>

                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">
                        Expenses by Category
                    </h3>

                    <apexchart type="bar" height="350" :options="chartOptions" :series="series" />
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
