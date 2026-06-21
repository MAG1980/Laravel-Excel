<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4">
        <AppCard>
            <h2 class="text-3xl font-extrabold text-center text-gray-900">Новый пароль</h2>
            <form @submit.prevent="submit" class="mt-8 space-y-6">
                <AppInput v-model="form.email" label="Email" type="email" :error="errors.email" />
                <AppInput v-model="form.password" label="Пароль" type="password" :error="errors.password" />
                <AppInput v-model="form.password_confirmation" label="Подтверждение пароля" type="password" />
                <input type="hidden" v-model="form.token" />
                <AppButton :loading="loading">Сохранить пароль</AppButton>
            </form>
        </AppCard>
    </div>
</template>

<script setup lang="ts">
import { reactive, ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/auth';

const authStore = useAuthStore();
const route = useRoute();
const router = useRouter();
const form = reactive({ email: '', password: '', password_confirmation: '', token: '' });
const errors = ref({});
const loading = ref(false);

onMounted(() => {
    form.token = route.query.token;
    form.email = route.query.email || '';
});

const submit = async () => {
    errors.value = {};
    loading.value = true;
    const result = await authStore.resetPassword(form);
    if (result.success) {
        router.push({ name: 'login' });
    } else {
        errors.value = result.errors || {};
    }
    loading.value = false;
};
</script>
