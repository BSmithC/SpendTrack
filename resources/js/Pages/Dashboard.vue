<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({
    expense_total: Number,
    expense_count: Number,
    categories_count: Number,
    expenses_this_month: Number,
    expenses_by_category: Object,
})

// Preparar datos para el gráfico
const series = computed(() => [{
    name: 'Expenses',
    data: Object.values(props.expenses_by_category || {})
}])

const chartOptions = computed(() => ({
    chart: {
        type: 'bar',
        height: 350,
        toolbar: {
            show: true,
            tools: {
                download: false
            }
        },
        animations: {
            enabled: true,
            easing: 'easeinout',
            speed: 800
        }
    },
    plotOptions: {
        bar: {
            borderRadius: 10,
            columnWidth: '55%',
            distributed: false,
            dataLabels: {
                position: 'top'
            }
        }
    },
    dataLabels: {
        enabled: true,
        formatter: (val) => {
            return new Intl.NumberFormat('es-DO', {
                style: 'currency',
                currency: 'DOP',
                minimumFractionDigits: 0
            }).format(val)
        },
        offsetY: -20,
        style: {
            fontSize: '12px',
            colors: ["#304758"]
        }
    },
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
    },
    title: {
        text: 'Expenses Distribution by Category',
        align: 'center',
        style: {
            fontSize: '16px',
            fontWeight: 'bold',
            color: '#263238'
        }
    },
    grid: {
        borderColor: '#e7e7e7',
        row: {
            colors: ['#f3f3f3', 'transparent'],
            opacity: 0.5
        },
    },
    markers: {
        size: 4,
        colors: ["#FFA41B"],
        strokeColors: "#fff",
        strokeWidth: 2,
        hover: {
            size: 7,
        }
    },
    xaxis: {
        categories: Object.keys(props.expenses_by_category || {}),
        title: {
            text: 'Categories',
            style: {
                fontSize: '14px',
                fontWeight: 'bold'
            }
        },
        labels: {
            style: {
                fontSize: '12px',
                fontWeight: '500'
            },
            rotate: -45,
            trim: true
        }
    },
    yaxis: {
        title: {
            text: 'Amount (DOP)',
            style: {
                fontSize: '14px',
                fontWeight: 'bold'
            }
        },
        labels: {
            formatter: (val) => {
                return new Intl.NumberFormat('es-DO', {
                    style: 'currency',
                    currency: 'DOP',
                    minimumFractionDigits: 0
                }).format(val)
            }
        }
    },
    tooltip: {
        y: {
            formatter: (val) => {
                return new Intl.NumberFormat('es-DO', {
                    style: 'currency',
                    currency: 'DOP'
                }).format(val)
            }
        },
        theme: 'dark'
    },
    colors: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#EC4899'],
    fill: {
        opacity: 1,
        gradient: {
            shade: 'light',
            type: "vertical",
            shadeIntensity: 0.5,
            gradientToColors: undefined,
            inverseColors: true,
            opacityFrom: 0.85,
            opacityTo: 0.95,
            stops: [0, 100]
        }
    }
}))

const formatCurrency = (value) => {
    if (!value && value !== 0) return '$0.00'
    return new Intl.NumberFormat('es-DO', {
        style: 'currency',
        currency: 'DOP',
        minimumFractionDigits: 2
    }).format(value)
}
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col space-y-2">
                <h2 class="text-2xl font-bold bg-gradient-to-r">
                    Dashboard
                </h2>
                <div class="text-sm text-gray-500">
                    {{ new Date().toLocaleDateString('es-DO', {
                        weekday: 'long', year: 'numeric', month: 'long', day:
                            'numeric'
                    }) }}
                </div>
            </div>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-8">

                <!-- KPIs Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                    <!-- Total Expenses Card -->
                    <div
                        class="relative overflow-hidden bg-gradient-to-br from-red-500 to-red-600 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full">
                        </div>
                        <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-20 h-20 bg-white opacity-10 rounded-full">
                        </div>
                        <div class="p-6 relative z-10">
                            <div class="flex items-center justify-between mb-3">
                                <p class="text-sm font-medium text-red-100">Total Expenses</p>
                                <svg class="w-8 h-8 text-red-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </div>
                            <p class="text-3xl font-bold text-white">{{ formatCurrency(expense_total) }}</p>
                            <p class="text-xs text-red-200 mt-2">Total accumulated</p>
                        </div>
                    </div>

                    <!-- Expenses Count Card -->
                    <div
                        class="relative overflow-hidden bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full">
                        </div>
                        <div class="p-6 relative z-10">
                            <div class="flex items-center justify-between mb-3">
                                <p class="text-sm font-medium text-blue-100">Expenses Count</p>
                                <svg class="w-8 h-8 text-blue-200" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                            </div>
                            <p class="text-3xl font-bold text-white">{{ expense_count }}</p>
                            <p class="text-xs text-blue-200 mt-2">Total transactions</p>
                        </div>
                    </div>

                    <!-- Categories Card -->
                    <div
                        class="relative overflow-hidden bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full">
                        </div>
                        <div class="p-6 relative z-10">
                            <div class="flex items-center justify-between mb-3">
                                <p class="text-sm font-medium text-yellow-100">Categories</p>
                                <svg class="w-8 h-8 text-yellow-200" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z">
                                    </path>
                                </svg>
                            </div>
                            <p class="text-3xl font-bold text-white">{{ categories_count }}</p>
                            <p class="text-xs text-yellow-200 mt-2">Active categories</p>
                        </div>
                    </div>

                    <!-- Expenses This Month Card -->
                    <div
                        class="relative overflow-hidden bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full">
                        </div>
                        <div class="p-6 relative z-10">
                            <div class="flex items-center justify-between mb-3">
                                <p class="text-sm font-medium text-green-100">This Month</p>
                                <svg class="w-8 h-8 text-green-200" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <p class="text-3xl font-bold text-white">{{ formatCurrency(expenses_this_month) }}</p>
                            <p class="text-xs text-green-200 mt-2">{{ new Date().toLocaleString('es-DO', {
                                month: 'long'
                            }) }}
                                expenses</p>
                        </div>
                    </div>
                </div>

                <!-- Chart Section -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl">
                    <div
                        class="border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800 px-6 py-4">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                            Expenses by Category
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Distribution of expenses across
                            different
                            categories</p>
                    </div>
                    <div class="p-6">
                        <apexchart v-if="Object.keys(expenses_by_category || {}).length > 0" type="bar" height="400"
                            :options="chartOptions" :series="series" />
                        <div v-else class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">No expense data available</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
