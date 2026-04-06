<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Register" />

    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-emerald-50 via-white to-teal-50">
        <div class="relative w-full max-w-md px-6 py-8">
            <!-- Logo / Brand -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-emerald-600 to-teal-600 rounded-2xl shadow-lg mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Create Account</h2>
                <p class="text-gray-500 mt-2">Join SpendTrack and start tracking your expenses</p>
            </div>

            <!-- Register Form -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl p-8 border border-emerald-100">
                <form @submit.prevent="submit">
                    <!-- Name Field -->
                    <div class="mb-6">
                        <InputLabel for="name" value="Full Name" class="text-gray-700 font-medium mb-2" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <TextInput
                                id="name"
                                type="text"
                                class="pl-10 block w-full rounded-xl border-gray-200 focus:border-emerald-400 focus:ring-emerald-400 transition-all duration-200"
                                v-model="form.name"
                                required
                                autofocus
                                autocomplete="name"
                                placeholder="John Doe"
                            />
                        </div>
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <!-- Email Field -->
                    <div class="mb-6">
                        <InputLabel for="email" value="Email Address" class="text-gray-700 font-medium mb-2" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                </svg>
                            </div>
                            <TextInput
                                id="email"
                                type="email"
                                class="pl-10 block w-full rounded-xl border-gray-200 focus:border-emerald-400 focus:ring-emerald-400 transition-all duration-200"
                                v-model="form.email"
                                required
                                autocomplete="username"
                                placeholder="john@example.com"
                            />
                        </div>
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <!-- Password Field -->
                    <div class="mb-6">
                        <InputLabel for="password" value="Password" class="text-gray-700 font-medium mb-2" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <TextInput
                                id="password"
                                type="password"
                                class="pl-10 block w-full rounded-xl border-gray-200 focus:border-emerald-400 focus:ring-emerald-400 transition-all duration-200"
                                v-model="form.password"
                                required
                                autocomplete="new-password"
                                placeholder="••••••••"
                            />
                        </div>
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="mb-8">
                        <InputLabel for="password_confirmation" value="Confirm Password" class="text-gray-700 font-medium mb-2" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <TextInput
                                id="password_confirmation"
                                type="password"
                                class="pl-10 block w-full rounded-xl border-gray-200 focus:border-emerald-400 focus:ring-emerald-400 transition-all duration-200"
                                v-model="form.password_confirmation"
                                required
                                autocomplete="new-password"
                                placeholder="Confirm your password"
                            />
                        </div>
                        <InputError class="mt-2" :message="form.errors.password_confirmation" />
                    </div>

                    <!-- Password Strength Indicator (optional) -->
                    <div class="mb-8">
                        <div class="flex items-center gap-2">
                            <div class="h-1 flex-1 rounded-full bg-gray-200 overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-300"
                                    :class="{
                                        'w-0 bg-gray-200': form.password.length === 0,
                                        'w-1/4 bg-red-500': form.password.length > 0 && form.password.length < 4,
                                        'w-1/2 bg-yellow-500': form.password.length >= 4 && form.password.length < 8,
                                        'w-3/4 bg-blue-500': form.password.length >= 8 && !/(?=.*[A-Z])(?=.*[0-9])/.test(form.password),
                                        'w-full bg-emerald-500': form.password.length >= 8 && /(?=.*[A-Z])(?=.*[0-9])/.test(form.password)
                                    }"
                                ></div>
                            </div>
                            <span class="text-xs text-gray-500" v-if="form.password.length > 0">
                                <span v-if="form.password.length < 4">Weak</span>
                                <span v-else-if="form.password.length >= 4 && form.password.length < 8">Fair</span>
                                <span v-else-if="form.password.length >= 8 && !/(?=.*[A-Z])(?=.*[0-9])/.test(form.password)">Good</span>
                                <span v-else-if="form.password.length >= 8 && /(?=.*[A-Z])(?=.*[0-9])/.test(form.password)">Strong</span>
                            </span>
                        </div>
                        <p class="text-xs text-gray-400 mt-2">Use 8+ characters with at least 1 uppercase & 1 number</p>
                    </div>

                    <!-- Submit Button -->
                    <PrimaryButton
                        class="w-full justify-center bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 rounded-xl py-3 font-semibold transition-all duration-200 transform hover:scale-[1.02]"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        <svg v-if="!form.processing" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        <svg v-else class="w-5 h-5 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Create Account
                    </PrimaryButton>

                    <!-- Login Link -->
                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-600">
                            Already have an account?
                            <Link :href="route('login')" class="font-medium text-emerald-600 hover:text-emerald-700 transition-colors duration-200">
                                Sign in here
                            </Link>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="text-center mt-6">
                <p class="text-xs text-gray-400">
                    &copy; 2026 SpendTrack. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Smooth transitions */
.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 200ms;
}
</style>
