<script setup>
import { ref, onMounted } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import { switchTheme, setThemeOnLoad } from '../theme.js';
import HomeIcon from '@/Components/Icons/HomeIcon.vue';
import ProductIcon from '@/Components/Icons/ProductIcon.vue';
import CategoryIcon from '@/Components/Icons/CategoryIcon.vue';
import CashIcon from '@/Components/Icons/CashIcon.vue';
import SidebarIcon from '@/Components/Icons/SidebarIcon.vue';
import SidebarFilledIcon from '@/Components/Icons/SidebarFilledIcon.vue';
import LightIcon from '@/Components/Icons/LightIcon.vue';
import DarkIcon from '@/Components/Icons/DarkIcon.vue';

const isDark = ref(false);
const sidebarExpanded = ref(true);
const showingNavigationDropdown = ref(false);

const toggleSidebar = () => {
    sidebarExpanded.value = !sidebarExpanded.value;
    localStorage.setItem('sidebarExpanded', sidebarExpanded.value);
};

onMounted(() => {
    const savedSidebarState = localStorage.getItem('sidebarExpanded');
    if (savedSidebarState !== null) {
        sidebarExpanded.value = savedSidebarState === 'true';
    }

    // Corrección: Llamar a setThemeOnLoad para sincronizar el tema
    setThemeOnLoad();

    // Detectar el tema inicial
    if (
        localStorage.theme === 'dark' ||
        (!('theme' in localStorage) &&
            window.matchMedia('(prefers-color-scheme: dark)').matches)
    ) {
        isDark.value = true;
        // Si el tema es oscuro, aplicar la clase dark al html
        document.documentElement.classList.add('dark');
    } else {
        isDark.value = false;
        document.documentElement.classList.remove('dark');
    }
});

// Función para cambiar el tema
const toggleTheme = () => {
    switchTheme();
    isDark.value = !isDark.value;
};
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <aside
                class="hidden sm:flex flex-col h-screen fixed left-0 top-0 bottom-0 border-r dark:border-gray-700 shadow-md transition-all duration-300 ease-in-out z-20 bg-white dark:bg-gray-800"
                :class="{ 'w-64': sidebarExpanded, 'w-20': !sidebarExpanded }">

                <div class="bg-gray-800 dark:bg-gray-900 h-16 border-b dark:border-gray-700 flex items-center px-4" :class="{
                    'justify-between': sidebarExpanded,
                    'justify-center': !sidebarExpanded
                }">
                    <Link :href="route('dashboard')" class="flex items-center gap-3">
                        <!-- Logo Icon -->
                        <div class="flex items-center justify-center rounded-lg bg-purple-600 transition-all duration-300"
                            :class="sidebarExpanded ? 'h-10 w-10' : 'h-8 w-8'">
                            <CashIcon class="text-white" :class="sidebarExpanded ? 'h-6 w-6' : 'h-4 w-4'" />
                        </div>

                        <!-- Logo Text (only shows when expanded) -->
                        <div v-if="sidebarExpanded" class="transition-all duration-300">
                            <h1 class="text-lg font-bold text-white dark:text-white leading-tight">
                                Spend<span class="text-purple-600">Track</span>
                            </h1>
                            <p class="text-xs text-gray-400 dark:text-gray-400">
                                Sistema de Gestión De Gasto Personales
                            </p>
                        </div>
                    </Link>
                </div>

                <!-- Navigation Links -->
                <div class="flex-1 overflow-y-auto py-6 space-y-1">
                    <div class="px-3">
                        <Link :href="route('dashboard')" :class="[
                            route().current('dashboard')
                                ? 'bg-purple-600 text-white font-semibold'
                                : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-purple-600 dark:hover:text-purple-400',
                            'group flex items-center px-3 py-3 text-sm rounded-md transition-all',
                            { 'justify-center': !sidebarExpanded }
                        ]">
                            <HomeIcon :class="route().current('dashboard') ? 'text-white' : 'text-gray-700 dark:text-gray-300 group-hover:text-purple-600 dark:group-hover:text-purple-400'" class="h-5 w-5" />
                            <span v-if="sidebarExpanded" class="ml-3" :class="route().current('dashboard') ? 'text-white' : ''">Inicio</span>
                        </Link>
                    </div>

                    <div class="px-3">
                        <Link :href="route('Expense.index')" :class="[
                            route().current('Expense.index') || route().current('Expense.create') || route().current('Expense.edit') || route().current('Expense.show')
                                ? 'bg-purple-600 text-white font-semibold'
                                : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-purple-600 dark:hover:text-purple-400',
                            'group flex items-center px-3 py-3 text-sm rounded-md transition-all',
                            { 'justify-center': !sidebarExpanded }
                        ]">
                            <ProductIcon :class="route().current('Expense.index') || route().current('Expense.create') || route().current('Expense.edit') || route().current('Expense.show') ? 'text-white' : 'text-gray-700 dark:text-gray-300 group-hover:text-purple-600 dark:group-hover:text-purple-400'" class="h-5 w-5" />
                            <span v-if="sidebarExpanded" class="truncate ml-3" :class="route().current('Expense.index') || route().current('Expense.create') || route().current('Expense.edit') || route().current('Expense.show') ? 'text-white' : ''">Productos</span>
                        </Link>
                    </div>

                    <div class="px-3">
                        <Link :href="route('Category.index')" :class="[
                            route().current('Category.index') || route().current('Category.create') || route().current('Category.edit') || route().current('Category.show')
                                ? 'bg-purple-600 text-white font-semibold'
                                : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-purple-600 dark:hover:text-purple-400',
                            'group flex items-center px-3 py-3 text-sm rounded-md transition-all',
                            { 'justify-center': !sidebarExpanded }
                        ]">
                            <CategoryIcon :class="route().current('Category.index') || route().current('Category.create') || route().current('Category.edit') || route().current('Category.show') ? 'text-white' : 'text-gray-700 dark:text-gray-300 group-hover:text-purple-600 dark:group-hover:text-purple-400'" class="h-5 w-5" />
                            <span v-if="sidebarExpanded" class="truncate ml-3" :class="route().current('Category.index') || route().current('Category.create') || route().current('Category.edit') || route().current('Category.show') ? 'text-white' : ''">Categorías</span>
                        </Link>
                    </div>
                </div>
            </aside>

            <div class="flex flex-col flex-1 transition-all duration-300"
                :class="{ 'sm:ml-64': sidebarExpanded, 'sm:ml-20': !sidebarExpanded }">

                <!-- Top bar (solo para móviles) -->
                <nav class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 sm:hidden">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex justify-between h-16">
                            <div class="flex">
                                <!-- Logo -->
                                <div class="shrink-0 flex items-center">
                                    <Link :href="route('dashboard')">
                                        <div class="flex items-center gap-2">
                                            <div class="h-8 w-8 rounded-lg bg-purple-600 flex items-center justify-center">
                                                <CashIcon class="h-4 w-4 text-white" />
                                            </div>
                                            <span class="text-lg font-bold text-gray-900 dark:text-white">
                                                Spend<span class="text-purple-600">Track</span>
                                            </span>
                                        </div>
                                    </Link>
                                </div>
                            </div>

                            <!-- Hamburger -->
                            <div class="-me-2 flex items-center sm:hidden">
                                <button
                                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out"
                                    @click="showingNavigationDropdown = !showingNavigationDropdown">
                                    <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                        <path
                                            :class="{ 'hidden': showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h16" />
                                        <path
                                            :class="{ 'hidden': !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Responsive Navigation Menu -->
                    <div :class="{ 'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown }"
                        class="sm:hidden">
                        <div class="pt-2 pb-3 space-y-1">
                            <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                Inicio
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('Expense.index')"
                                :active="route().current('Expense.index')">
                                Productos
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('Category.index')"
                                :active="route().current('Category.index')">
                                Categorías
                            </ResponsiveNavLink>
                        </div>
                        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-700">
                            <div class="mt-3 space-y-1">
                                <ResponsiveNavLink :href="route('profile.edit')"
                                    :active="route().current('profile.edit')">
                                    Perfil
                                </ResponsiveNavLink>

                                <button @click="toggleTheme" class="flex items-center w-full px-4 py-2 text-sm font-medium rounded-md transition
                                   text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                                    <component :is="isDark ? LightIcon : DarkIcon" class="w-5 h-5 mr-2" />
                                    <span>{{ isDark ? 'Modo Claro' : 'Modo Oscuro' }}</span>
                                </button>

                                <ResponsiveNavLink method="post" :href="route('logout')">
                                    Cerrar sesión
                                </ResponsiveNavLink>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- Top bar escritorio -->
                <nav class="border-b hidden md:flex h-16 justify-between px-5 dark:border-gray-700 bg-white dark:bg-gray-800">
                    <button @click="toggleSidebar"
                        class="cursor-pointer text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white p-2 rounded-md transition-colors">
                        <transition name="icon-fade" mode="out-in">
                            <SidebarIcon v-if="sidebarExpanded" :key="'expanded'" class="h-5 w-5" />
                            <SidebarFilledIcon v-else :key="'collapsed'" class="h-5 w-5" />
                        </transition>
                    </button>

                    <div class="hidden lg:ms-6 lg:flex md:flex items-center ml-auto gap-2">
                        <button @click="toggleTheme"
                            class="text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full p-2 cursor-pointer transition-colors">
                            <component :is="isDark ? LightIcon : DarkIcon" class="w-5 h-5" />
                        </button>

                        <div class="relative">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <span class="inline-flex rounded-md">
                                        <button type="button"
                                            class="inline-flex items-center cursor-pointer rounded-md bg-white dark:bg-gray-800 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white border border-gray-300 dark:border-gray-600">
                                            {{ $page.props.auth.user.name }}
                                            <svg class="-me-0.5 ms-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </span>
                                </template>
                                <template #content>
                                    <DropdownLink class="rounded-t-xl" :href="route('profile.edit')">Perfil
                                    </DropdownLink>
                                    <DropdownLink class="rounded-b-xl" :href="route('logout')" method="post"
                                        as="button">Cerrar Sesión
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>
                    </div>
                </nav>

                <!-- Page Heading -->
                <header class="bg-white shadow dark:bg-gray-800" v-if="$slots.header">
                    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                        <slot name="header" />
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 transition-all duration-300">
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>

<style scoped>
.icon-fade-enter-active,
.icon-fade-leave-active {
    transition: opacity 0.2s ease;
}

.icon-fade-enter-from,
.icon-fade-leave-to {
    opacity: 0;
}
</style>
