<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4">
        <AppCard>
            <h2 class="text-3xl font-extrabold text-center text-gray-900">Сброс пароля</h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Введите ваш email, и мы отправим ссылку для восстановления
            </p>
            <form @submit.prevent="submit" class="mt-8 space-y-6">
                <AppInput v-model="email" label="Email" type="email" :error="errors.email" />
                <AppButton :loading="loading">Отправить ссылку</AppButton>
                <p v-if="success" class="text-sm text-green-600 text-center">
                    Ссылка отправлена! Проверьте вашу почту.
                </p>
            </form>
            <p class="mt-4 text-center text-sm text-gray-600">
                <router-link :to="{name:'auth.login'}" class="text-indigo-600 hover:text-indigo-500">Вернуться ко входу</router-link>
            </p>
        </AppCard>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import AppButton from '@spa/components/ui/AppButton.vue';
import AppCard from '@spa/components/ui/AppCard.vue';
import AppInput from '@spa/components/ui/AppInput.vue';
import { useAuthStore } from '@spa/stores/auth';

const authStore = useAuthStore();
const email = ref('');
const errors = ref({});
const loading = ref(false);
const success = ref(false);

const submit = async () => {
    errors.value = {};
    loading.value = true;
    const result = await authStore.sendPasswordResetLink(email.value);
    if (result.success) {
        success.value = true;
    } else {
        errors.value = result.errors || {};
    }
    loading.value = false;
};
</script>
