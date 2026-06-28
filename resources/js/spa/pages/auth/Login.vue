<template>
    <div
        class="flex min-h-screen items-center justify-center bg-gray-50 px-4 py-12 sm:px-6 lg:px-8"
    >
        <AppCard>
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900">
                    Добро пожаловать
                </h2>
                <p class="mt-2 text-sm text-gray-600">Войдите в свой аккаунт</p>
            </div>

            <form @submit.prevent="submit" class="mt-8 space-y-6">
                <AppInput
                    v-model="form.email"
                    label="Email"
                    type="email"
                    placeholder="you@example.com"
                    :error="errors.email"
                />
                <AppInput
                    v-model="form.password"
                    label="Пароль"
                    type="password"
                    placeholder="••••••••"
                    :error="errors.password"
                />
                <div class="flex items-center justify-between">
                    <router-link
                        :to="{ name: 'auth.forgot-password' }"
                        class="text-sm text-indigo-600 transition hover:text-indigo-500"
                    >
                        Забыли пароль?
                    </router-link>
                </div>
                <AppButton :loading="authStore.isLoading">Войти</AppButton>
            </form>

            <p class="mt-4 text-center text-sm text-gray-600">
                Нет аккаунта?
                <router-link
                    :to="{ name: 'auth.registration' }"
                    class="font-medium text-indigo-600 hover:text-indigo-500"
                >
                    Зарегистрируйтесь
                </router-link>
            </p>
        </AppCard>
    </div>
</template>

<script setup lang="ts">
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import AppButton from '@spa/components/ui/AppButton.vue';
import AppCard from '@spa/components/ui/AppCard.vue';
import AppInput from '@spa/components/ui/AppInput.vue';
import { useAuthStore } from '@spa/stores/auth';

const authStore = useAuthStore();
const router = useRouter();
const form = reactive({ email: '', password: '' });
const errors = ref({});

const submit = async () => {
    errors.value = {};
    const result = await authStore.login(form);
    if (result.success) {
        router.push({ name: 'user.dashboard' });
    } else {
        errors.value = result.errors || { email: 'Неверные учётные данные' };
    }
};
</script>
