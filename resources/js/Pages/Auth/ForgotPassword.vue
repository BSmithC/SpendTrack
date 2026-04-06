<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import MailIcon from '@/Components/Icons/MailIcon.vue';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>

    <Head title="Forgot Password" />

    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-emerald-50 via-white to-teal-50">
        <div class="w-full max-w-md px-6">
            <!-- Logo -->
            <div class="text-center mb-8">
                <div
                    class="text-white inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-emerald-600 to-teal-600 rounded-2xl shadow-lg mb-4">
                    <MailIcon />
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Reset Password</h2>
                <p class="text-gray-500 text-sm mt-1">Enter your email to reset</p>
            </div>

            <!-- Status -->
            <div v-if="status" class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 p-3 text-center">
                <p class="text-sm text-emerald-800">{{ status }}</p>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <p class="text-sm text-gray-600 mb-6">
                    Forgot your password? Enter your email and we'll send you a reset link.
                </p>

                <form @submit.prevent="submit">
                    <div class="mb-6">
                        <InputLabel for="email" value="Email" class="text-gray-700 font-medium mb-2" />
                        <TextInput id="email" type="email"
                            class="w-full rounded-xl border-gray-200 focus:border-emerald-400 focus:ring-emerald-400"
                            v-model="form.email" required autofocus placeholder="your@email.com" />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <PrimaryButton
                        class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 rounded-xl py-3 font-semibold"
                        :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Send Reset Link
                    </PrimaryButton>

                    <div class="mt-6 text-center">
                        <Link :href="route('login')" class="text-sm text-emerald-600 hover:text-emerald-700">
                            Back to Login
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
