<template>
    <form class="max-w-md mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
        <div class="mb-4">
            <label for="title" class="block text-gray-700 text-sm font-bold mb-2">
                Заголовок
            </label>
            <input
                id="title"
                type="text"
                v-model="title"
                placeholder="Введите заголовок"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
            />
        </div>

        <div class="mb-4">
            <label for="content" class="block text-gray-700 text-sm font-bold mb-2">
                Содержание
            </label>
            <textarea
                id="content"
                v-model="content"
                placeholder="Введите текст поста"
                rows="5"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 resize-y"
            ></textarea>
        </div>

        <button
            type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 active:scale-[0.98]"
        >
            Создать пост
        </button>
    </form>
</template>

<script setup lang="ts">
import { ref } from 'vue';

const title = ref('');
const content = ref('');
</script>

<style scoped>
/* Дополнительный кастомный стиль для улучшения внешнего вида */
form {
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
}

/* Лёгкая тень при фокусе (дублирует Tailwind, но даёт более плавный эффект) */
input:focus,
textarea:focus {
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
}

/* Анимация нажатия кнопки */
button:active {
    transform: scale(0.97);
}

/* Добавляем отступы для мобильных устройств */
@media (max-width: 640px) {
    form {
        margin-left: 1rem;
        margin-right: 1rem;
    }
}
</style>
