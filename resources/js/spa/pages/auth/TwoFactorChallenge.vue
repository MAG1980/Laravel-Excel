<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4">
        <AppCard>
            <h2 class="text-3xl font-extrabold text-center text-gray-900">Двухфакторная аутентификация</h2>
            <p class="mt-2 text-center text-sm text-gray-600">Введите код из вашего аутентификатора</p>
            <form @submit.prevent="submit" class="mt-8 space-y-6">
                <AppInput v-model="code" label="Код подтверждения" placeholder="123456" :error="error" />
                <AppButton :loading="loading">Подтвердить</AppButton>
                <p v-if="error" class="text-sm text-red-600 text-center">{{ error }}</p>
            </form>
        </AppCard>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import AppButton from '@spa/components/ui/AppButton.vue';
import AppCard from '@spa/components/ui/AppCard.vue';
import AppInput from '@spa/components/ui/AppInput.vue';
import { useAuthStore } from '@/stores/auth';

const authStore = useAuthStore();
const router = useRouter();
const code = ref('');
const loading = ref(false);
const error = ref('');

const submit = async () => {
    error.value = '';
    loading.value = true;
    try {
        await authStore.confirmTwoFactor(code.value);
        router.push({ name: 'dashboard' });
    } catch (err) {
        error.value = err.response?.data?.message || 'Неверный код';
    } finally {
        loading.value = false;
    }
};
</script>
