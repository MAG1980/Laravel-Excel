import { defineStore } from 'pinia';
import api from '@spa/axios';
import type { User } from '@spa/interfaces';
import type {
    AuthState,
    LoginCredentials,
    ResetPasswordData,
} from '@spa/stores/interfaces';
import type { ActionResult, ValidationErrors } from '@spa/stores/types';

export const useAuthStore = defineStore('auth', {
    state: (): AuthState => ({
        user: null,
        isLoggedIn: false,
        isLoading: false,
    }),

    actions: {
        /**
         * Загружает текущего пользователя
         */
        async fetchUser(): Promise<void> {
            try {
                // Предполагается, что ответ содержит поле `data` с объектом User
                const { data } = await api.get<User>('/api/user');
                console.log(data);
                this.user = data;
                this.isLoggedIn = true;
            } catch {
                this.user = null;
                this.isLoggedIn = false;
            }

            console.log({ isLoggedIn: this.isLoggedIn, user: this.user });
        },

        /**
         * Вход в систему
         */
        async login(credentials: LoginCredentials): Promise<ActionResult> {
            this.isLoading = true;
            try {
                await api.post('/login', credentials);
                await this.fetchUser();
                return { success: true };
            } catch (error: unknown) {
                // Приводим ошибку к типу с response
                const err = error as {
                    response?: { data?: { errors?: ValidationErrors } };
                };
                return {
                    success: false,
                    errors: err.response?.data?.errors || {},
                };
            } finally {
                this.isLoading = false;
            }
        },

        /**
         * Выход из системы
         */
        async logout(): Promise<ActionResult> {
            try {
                await api.post('/logout');
                this.user = null;
                this.isLoggedIn = false;
                return { success: true };
            } catch (error: unknown) {
                const err = error as {
                    response?: { data?: { errors?: ValidationErrors } };
                };
                return {
                    success: false,
                    errors: err.response?.data?.errors || {},
                };
            }
        },

        /**
         * Отправка ссылки для сброса пароля
         */
        async sendPasswordResetLink(email: string): Promise<ActionResult> {
            try {
                await api.post('/forgot-password', { email });
                return { success: true };
            } catch (error: unknown) {
                const err = error as {
                    response?: { data?: { errors?: ValidationErrors } };
                };
                return {
                    success: false,
                    errors: err.response?.data?.errors || {},
                };
            }
        },

        /**
         * Сброс пароля (с токеном)
         */
        async resetPassword(data: ResetPasswordData): Promise<ActionResult> {
            try {
                await api.post('/reset-password', data);
                return { success: true };
            } catch (error: unknown) {
                const err = error as {
                    response?: { data?: { errors?: ValidationErrors } };
                };
                return {
                    success: false,
                    errors: err.response?.data?.errors || {},
                };
            }
        },

        /**
         * Повторная отправка письма для подтверждения email
         */
        async resendVerification(): Promise<void> {
            await api.post('/email/verification-notification');
        },

        /**
         * Подтверждение email по ссылке
         */
        async verifyEmail(id: string, hash: string): Promise<void> {
            await api.get(`/verify-email/${id}/${hash}`);
            // После подтверждения обновляем поле в текущем пользователе
            if (this.user) {
                this.user.email_verified_at = new Date().toISOString();
            }
        },

        /**
         * Подтверждение двухфакторной аутентификации (код)
         */
        async confirmTwoFactor(code: string): Promise<void> {
            await api.post('/two-factor-challenge', { code });
            await this.fetchUser();
        },
    },
});
