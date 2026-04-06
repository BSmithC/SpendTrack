<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;
    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;
    form.clearErrors();
    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <div class="bg-red-50 rounded-lg p-4 border border-red-100">
            <p class="text-sm text-red-700">
                Warning: This action cannot be undone. All your data will be permanently deleted.
            </p>
        </div>

        <DangerButton
            @click="confirmUserDeletion"
            class="bg-red-600 hover:bg-red-700 focus:ring-red-500 transition-all duration-200"
        >
            <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
            Delete Account
        </DangerButton>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6 bg-white rounded-xl">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2 bg-red-100 rounded-full">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900">
                        Delete Account
                    </h2>
                </div>

                <p class="text-sm text-gray-600 mb-4">
                    Are you sure you want to delete your account? Once deleted, all data will be permanently removed.
                </p>

                <div class="mb-6">
                    <InputLabel for="password" value="Password" class="text-sm font-medium text-gray-700" />
                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500"
                        placeholder="Enter your password to confirm"
                        @keyup.enter="deleteUser"
                    />
                    <InputError :message="form.errors.password" class="mt-2" />
                </div>

                <div class="flex justify-end gap-3">
                    <SecondaryButton
                        @click="closeModal"
                        class="px-4 py-2 rounded-lg border-gray-300 hover:bg-gray-50 transition-all duration-200"
                    >
                        Cancel
                    </SecondaryButton>
                    <DangerButton
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                        class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg transition-all duration-200"
                    >
                        Yes, Delete Account
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
