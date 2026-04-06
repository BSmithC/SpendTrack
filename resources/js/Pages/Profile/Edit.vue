<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <div class="text-sm text-gray-500 mb-1">
                    Account Settings
                </div>
                <h2 class="text-2xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                    My Profile
                </h2>
            </div>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <!-- Profile Information Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md">
                    <div class="border-b border-gray-100 bg-gradient-to-r from-gray-50/50 to-transparent px-6 py-4">
                        <h3 class="text-lg font-semibold text-gray-900">Profile Information</h3>
                        <p class="text-sm text-gray-500 mt-1">Update your account's profile information and email address</p>
                    </div>
                    <div class="p-6">
                        <UpdateProfileInformationForm
                            :must-verify-email="mustVerifyEmail"
                            :status="status"
                            class="max-w-xl"
                        />
                    </div>
                </div>

                <!-- Update Password Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-md">
                    <div class="border-b border-gray-100 bg-gradient-to-r from-gray-50/50 to-transparent px-6 py-4">
                        <h3 class="text-lg font-semibold text-gray-900">Update Password</h3>
                        <p class="text-sm text-gray-500 mt-1">Ensure your account is using a long, random password to stay secure</p>
                    </div>
                    <div class="p-6">
                        <UpdatePasswordForm class="max-w-xl" />
                    </div>
                </div>

                <!-- Delete Account Card -->
                <div class="bg-white rounded-xl shadow-sm border border-red-100 overflow-hidden transition-all duration-300 hover:shadow-md">
                    <div class="border-b border-red-100 bg-gradient-to-r from-red-50/30 to-transparent px-6 py-4">
                        <h3 class="text-lg font-semibold text-red-600">Delete Account</h3>
                        <p class="text-sm text-gray-500 mt-1">Permanently delete your account and all associated data</p>
                    </div>
                    <div class="p-6">
                        <DeleteUserForm class="max-w-xl" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
