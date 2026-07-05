<template>
    <form
        @submit.prevent="postStore"
        class="relative mx-auto mt-10 max-w-md rounded-lg bg-white p-6 shadow-md"
    >
        <LoaderCircle v-if="isLoading" class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-blue-600 animate-spin" :size="96" :stroke-width="2.5" aria-label="Loading" />
        <!-- Заголовок -->
        <div class="mb-4">
            <label
                for="title"
                class="mb-2 block text-sm font-bold text-gray-700"
            >
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
            <label
                for="content"
                class="mb-2 block text-sm font-bold text-gray-700"
            >
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
            <OutInTransition>
                <div v-if="!imageFile">
                    <button
                        type="button"
                        @click="triggerFileInput"
                        class="rounded-md bg-gray-200 px-4 py-2 font-semibold text-gray-700 transition hover:bg-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none active:scale-[0.98]"
                    >
                        Добавить изображение
                    </button>
                    <span class="px-4 text-sm text-gray-400"
                        >Файл не выбран</span
                    >
                </div>
            </OutInTransition>
        </div>

        <OutInTransition>
            <!-- Превью изображения -->
            <div
                v-if="previewUrl"
                class="mt-4 mb-3 flex flex-col items-center justify-center"
            >
                <img
                    :src="previewUrl"
                    alt="Превью"
                    class="mb-3 max-h-48 max-w-min rounded-md border border-gray-200 object-contain"
                />
                <span v-if="imageName" class="text-sm text-gray-600">
                    {{ imageName }}
                </span>
                <button
                    type="button"
                    @click="removeImage"
                    class="w-full rounded-md bg-red-700 px-4 py-2 font-semibold text-white transition hover:bg-red-600 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:outline-none active:scale-[0.98] disabled:opacity-50"
                >
                    Удалить изображение
                </button>
            </div>
        </OutInTransition>

        <!-- Кнопка отправки -->
        <button
            type="submit"
            :disabled="isLoading"
            class="w-full rounded-md bg-blue-600 px-4 py-2 font-semibold text-white transition hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:outline-none active:scale-[0.98] disabled:opacity-50"
        >
            <span class="flex justify-center items-center gap-2">
                <span>{{ isLoading ? 'Создание...' : 'Создать пост' }}</span>
                <span>
                    <LoaderCircle
                        v-if="isLoading"
                        class="animate-spin text-blue-600"
                        :size="16"
                        :stroke-width="2.5"
                        aria-label="Loading"
                    />
                </span>
            </span>
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
import OutInTransition from '@spa/components/OutInTransition.vue';
import { LoaderCircle } from '@lucide/vue';

const title = ref('');
const content = ref('');
const imageFile = ref<File | null>(null);
const imageName = ref('');
const previewUrl = ref<string | null>(null);
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

    // Освобождаем предыдущий URL, если он был
    if (previewUrl.value) {
        URL.revokeObjectURL(previewUrl.value);
        previewUrl.value = null;
    }

    if (file) {
        imageFile.value = file;
        imageName.value = file.name;
        // Создаём временную ссылку на данные в оперативной памяти (например, файла, загруженного пользователем).
        // Они уникальны для сеанса и освобождаются при закрытии страницы или явном revoke.
        // Это позволяет отображать изображения без загрузки на сервер.
        previewUrl.value = URL.createObjectURL(file);
    } else {
        imageFile.value = null;
        imageName.value = '';
        previewUrl.value = null;
    }
    // Сбрасываем поле, чтобы можно было выбрать тот же файл повторно
    target.value = '';
};

// Снять выбор с изображения
const removeImage = () => {
    if (previewUrl.value) {
        // Очистка оперативной памяти, чтобы избежать утечек
        URL.revokeObjectURL(previewUrl.value);
        previewUrl.value = null;
    }
    imageFile.value = null;
    imageName.value = '';
    // Сбрасываем input, чтобы при повторном выборе того же файла сработало событие change
    if (fileInput.value) {
        fileInput.value.value = '';
    }
};

// Очистка формы (сброс всех полей)
const resetForm = () => {
    title.value = '';
    content.value = '';
    if (previewUrl.value) {
        // Очистка оперативной памяти, чтобы избежать утечек
        URL.revokeObjectURL(previewUrl.value);
        previewUrl.value = null;
    }
    imageFile.value = null;
    imageName.value = '';
    if (fileInput.value) {
        fileInput.value.value = '';
    }
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
        resetForm();
    } catch (error: any) {
        console.error(error);
        errorMessage.value =
            error.response?.data?.message || 'Ошибка при создании поста';
    } finally {
        isLoading.value = false;
    }
};
</script>
