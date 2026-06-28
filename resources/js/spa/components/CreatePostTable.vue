<template>
    <form
        @submit.prevent="postStore"
        class="mx-auto mt-10 max-w-md rounded-lg bg-white p-6 shadow-md"
    >
        <!-- Заголовок -->
        <div class="mb-4">
            <label for="title" class="mb-2 block text-sm font-bold text-gray-700">
                Заголовок
            </label>
            <input
                id="title"
                v-model="title"
                type="text"
                placeholder="Введите заголовок"
                class="w-full rounded-md border border-gray-300 px-4 py-2 transition duration-200 focus:border-transparent focus:ring-2 focus:ring-blue-500 focus:outline-none"
            />
        </div>

        <!-- Содержание -->
        <div class="mb-4">
            <label for="content" class="mb-2 block text-sm font-bold text-gray-700">
                Содержание
            </label>
            <textarea
                id="content"
                v-model="content"
                placeholder="Введите текст поста"
                rows="5"
                class="w-full resize-y rounded-md border border-gray-300 px-4 py-2 transition duration-200 focus:border-transparent focus:ring-2 focus:ring-blue-500 focus:outline-none"
            ></textarea>
        </div>

        <!-- Блок выбора изображения -->
        <div class="mb-4 flex items-center gap-4">
            <input
                id="postImage"
                ref="fileInput"
                type="file"
                accept="image/*"
                class="hidden"
                @change="onFileSelected"
            />
            <button
                type="button"
                @click="triggerFileInput"
                class="rounded-md bg-gray-200 px-4 py-2 font-semibold text-gray-700 transition hover:bg-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none active:scale-[0.98]"
            >
                Добавить изображение
            </button>
            <span v-if="imageName" class="text-sm text-gray-600">
        {{ imageName }}
      </span>
            <span v-else class="text-sm text-gray-400">Файл не выбран</span>
        </div>

        <!-- Кнопка отправки -->
        <button
            type="submit"
            :disabled="isLoading"
            class="w-full rounded-md bg-blue-600 px-4 py-2 font-semibold text-white transition hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:outline-none active:scale-[0.98] disabled:opacity-50"
        >
            {{ isLoading ? 'Создание...' : 'Создать пост' }}
        </button>

        <!-- Сообщение об ошибке -->
        <p v-if="errorMessage" class="mt-3 text-center text-sm text-red-600">
            {{ errorMessage }}
        </p>
    </form>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import api from '@spa/axios';

const title = ref('');
const content = ref('');
const imageFile = ref<File | null>(null);
const imageName = ref('');
const isLoading = ref(false);
const errorMessage = ref('');

const fileInput = ref<HTMLInputElement | null>(null);

// Открыть диалог выбора файла
const triggerFileInput = () => {
    fileInput.value?.click();
};

// Обработчик выбора файла
const onFileSelected = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];
    if (file) {
        imageFile.value = file;
        imageName.value = file.name;
    } else {
        imageFile.value = null;
        imageName.value = '';
    }
    // Сбрасываем поле, чтобы можно было выбрать тот же файл повторно
    target.value = '';
};

// Отправка формы
const postStore = async () => {
    errorMessage.value = '';
    isLoading.value = true;

    try {
        const formData = new FormData();
        formData.append('title', title.value);
        formData.append('content', content.value);
        if (imageFile.value) {
            formData.append('image', imageFile.value);
        }

        const response = await api.post('/api/posts', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });

        console.log('Пост создан:', response.data);

        // Очистка формы после успешной отправки
        title.value = '';
        content.value = '';
        imageFile.value = null;
        imageName.value = '';
    } catch (error: any) {
        console.error(error);
        errorMessage.value = error.response?.data?.message || 'Ошибка при создании поста';
    } finally {
        isLoading.value = false;
    }
};
</script>
