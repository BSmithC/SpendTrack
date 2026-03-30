<script setup>
import CashIcon from '@/Components/Icons/CashIcon.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

const isScrolled = ref(false);

onMounted(() => {
    window.addEventListener('scroll', () => {
        isScrolled.value = window.scrollY > 50;
    });
});
</script>

<template>

    <Head title="SpendTrack | Inteligencia Financiera" />

    <div class="min-h-screen bg-white">
        <!-- Header -->
        <header class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
            :class="isScrolled ? 'bg-white/90 backdrop-blur-md shadow-sm py-3' : 'bg-transparent py-5'">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <Link href="/" class="flex items-center gap-2">
                        <div
                            class="w-8 h-8 rounded-lg  bg-emerald-600 bg-gradient-to-br  flex items-center justify-center">
                            <CashIcon class="h-4 w-4 text-white" />
                        </div>
                        <span class="text-xl font-semibold">Spend<span class="text-emerald-600">Track</span></span>
                    </Link>

                    <div v-if="canLogin" class="flex items-center gap-3">
                        <template v-if="$page.props.auth.user">
                            <Link :href="route('dashboard')"
                                class="px-5 py-2 text-sm font-medium text-gray-700 hover:text-emerald-600">
                                Dashboard
                            </Link>
                        </template>
                        <template v-else>
                            <Link :href="route('login')" class="px-5 py-2 text-sm text-gray-600 hover:text-gray-900">
                                Iniciar sesión
                            </Link>
                            <Link v-if="canRegister" :href="route('register')"
                                class="px-5 py-2 text-sm text-white bg-emerald-600 rounded-lg hover:bg-emerald-700">
                                Crear cuenta
                            </Link>
                        </template>
                    </div>
                </div>
            </div>
        </header>

        <!-- Hero -->
        <section class="relative pt-32 pb-20">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-50/50 via-white to-teal-50/30"></div>
            <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    <div class="space-y-8">
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-50 rounded-full">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute h-full w-full rounded-full bg-emerald-400"></span>
                                <span class="relative h-2 w-2 rounded-full bg-emerald-500"></span>
                            </span>
                            <span class="text-xs font-medium text-emerald-700">Plataforma líder</span>
                        </div>

                        <h1 class="text-4xl lg:text-5xl font-bold tracking-tight">
                            Toma el control de
                            <span class="text-emerald-600">tus finanzas</span>
                            con inteligencia real
                        </h1>

                        <p class="text-lg text-gray-500 max-w-lg">
                            Diseño elegante y análisis avanzado para decisiones financieras más inteligentes.
                        </p>

                        <div class="flex flex-wrap gap-4">
                            <Link v-if="canRegister && !$page.props.auth.user" :href="route('register')"
                                class="px-6 py-3 bg-emerald-600 text-white font-medium rounded-lg hover:bg-emerald-700 shadow-md">
                                Comienza gratis
                            </Link>
                            <Link v-else-if="$page.props.auth.user" :href="route('dashboard')"
                                class="px-6 py-3 bg-emerald-600 text-white font-medium rounded-lg">
                                Dashboard
                            </Link>
                            <a href="#soluciones"
                                class="px-6 py-3 border border-gray-300 rounded-lg hover:border-emerald-300 hover:bg-emerald-50">
                                Ver más
                            </a>
                        </div>

                        <div class="flex gap-8 pt-4">
                            <div>
                                <div class="text-2xl font-bold">+5K</div>
                                <div class="text-xs text-gray-500">Usuarios</div>
                            </div>
                            <div class="w-px h-10 bg-gray-200"></div>
                            <div>
                                <div class="text-2xl font-bold">98%</div>
                                <div class="text-xs text-gray-500">Satisfacción</div>
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="bg-white rounded-2xl shadow-xl border p-6">
                            <div class="flex justify-between items-end mb-6">
                                <div>
                                    <p class="text-sm text-gray-500">Balance total</p>
                                    <p class="text-3xl font-bold">$12,845.50</p>
                                </div>
                                <div class="px-3 py-1 bg-emerald-50 rounded-lg"><span
                                        class="text-sm text-emerald-600">+24%</span></div>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <div class="flex justify-between text-sm mb-2">
                                        <span>Ingresos</span><span>$5,240</span>
                                    </div>
                                    <div class="h-2 bg-gray-100 rounded-full">
                                        <div class="w-3/4 h-full bg-emerald-500 rounded-full"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-sm mb-2">
                                        <span>Gastos</span><span>$3,240</span>
                                    </div>
                                    <div class="h-2 bg-gray-100 rounded-full">
                                        <div class="w-1/2 h-full bg-teal-400 rounded-full"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Soluciones - 3 cards -->
        <section id="soluciones" class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="text-center mb-12">
                    <span class="text-sm text-emerald-600 uppercase tracking-wide">Soluciones</span>
                    <h2 class="text-3xl font-bold mt-2">Para cada etapa de tu vida</h2>
                </div>

                <div class="grid md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition">
                        <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold mb-2">Para principiantes</h3>
                        <p class="text-gray-500 text-sm">Aprende los fundamentos y establece tus primeros hábitos
                            financieros.
                        </p>
                    </div>

                    <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition">
                        <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold mb-2">Para profesionales</h3>
                        <p class="text-gray-500 text-sm">Optimiza ingresos, gestiona inversiones y planifica tu futuro.
                        </p>
                    </div>

                    <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition">
                        <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold mb-2">Para emprendedores</h3>
                        <p class="text-gray-500 text-sm">Controla flujo de caja y proyecta el crecimiento de tu negocio.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA final simple -->
        <section class="py-16">
            <div class="max-w-3xl mx-auto px-6 lg:px-8">
                <div class="bg-gradient-to-r from-emerald-600 to-teal-600 rounded-2xl p-10 text-center text-white">
                    <h2 class="text-2xl font-bold mb-3">¿Listo para empezar?</h2>
                    <p class="text-emerald-100 mb-6 text-sm">Únete gratis y toma el control de tus finanzas</p>
                    <Link v-if="canRegister && !$page.props.auth.user" :href="route('register')"
                        class="inline-block px-6 py-2.5 bg-white text-emerald-600 font-medium rounded-lg hover:bg-gray-50">
                        Crear cuenta gratis
                    </Link>
                    <Link v-else-if="$page.props.auth.user" :href="route('dashboard')"
                        class="inline-block px-6 py-2.5 bg-white text-emerald-600 font-medium rounded-lg">
                        Ir al Dashboard
                    </Link>
                </div>
            </div>
        </section>

        <!-- Footer simple -->
        <footer class="border-t py-8">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-gray-400">
                    <div class="flex items-center gap-2">
                        <div
                            class="w-8 h-8 rounded-lg  bg-emerald-600 bg-gradient-to-br  flex items-center justify-center">
                            <CashIcon class="h-4 w-4 text-white" />
                        </div>
                        <span>SpendTrack</span>
                        <span>© 2026</span>
                    </div>
                    <div class="flex gap-6">
                        <a href="#" class="hover:text-emerald-600">Privacidad</a>
                        <a href="#" class="hover:text-emerald-600">Términos</a>
                        <span class="font-mono text-xs">Laravel v{{ laravelVersion }} · PHP v{{ phpVersion }}</span>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<style scoped>
html {
    scroll-behavior: smooth;
}
</style>
