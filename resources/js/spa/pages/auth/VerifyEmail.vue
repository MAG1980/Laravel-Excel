<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4">
        <AppCard>
            <div class="text-center">
                <svg class="mx-auto h-12 w-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h2 class="mt-4 text-3xl font-extrabold text-gray-900">Подтвердите email</h2>
                <p class="mt-2 text-sm text-gray-600">
                    Мы отправили ссылку на ваш email. Если вы не получили письмо, нажмите кнопку ниже.
                </p>
                <AppButton @click="resend" :loading="sending" class="mt-6">Выслать повторно</AppButton>
                <p v-if="resent" class="mt-2 text-sm text-green-600">Новое письмо отправлено!</p>
            </div>
        </AppCard>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useRoute } from 'vue-router';
import AppButton from '@spa/components/ui/AppButton.vue';
import AppCard from '@spa/components/ui/AppCard.vue';
import { useAuthStore } from '@/stores/auth';

const authStore = useAuthStore();
const route = useRoute();
const sending = ref(false);
const resent = ref(false);

const resend = async () => {
    sending.value = true;
    await authStore.resendVerification();
    resent.value = true;
    sending.value = false;
};

// Автоматическая верификация при переходе по ссылке из письма
if (route.params.id && route.params.hash) {
    authStore.verifyEmail(route.params.id, route.params.hash);
}
</script>
