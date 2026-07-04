<template>
    <div class="relative" v-if="uploadedImageUrl">
        <div class="absolute top-20 right-20">
            <X
                @click="uploadedImageClose"
                class="cursor-pointer rounded-full bg-red-500 p-2 text-lg text-gray-100"
                :size="48"
                :stroke-width="2.5"
                aria-label="Close"
            />
        </div>
        <img
            :src="uploadedImageUrl ?? undefined"
            alt="UploadedImage"
            class="w-full rounded-md border border-gray-200 object-contain"
        />
    </div>
    <form
        v-else
        @submit.prevent="imageStore"
        class="mx-auto mt-10 max-w-md rounded-lg bg-white p-6 shadow-md"
    >
        <!-- Превью изображения -->
        <div class="mb-3">
            <div
                v-if="previewUrl"
                class="mb-3 flex flex-col items-center justify-center"
            >
                <img
                    :src="previewUrl"
                    alt="Превью"
                    class="max-h-48 max-w-min rounded-md border border-gray-200 object-contain"
                />

                <span v-if="imageName" class="mb-3 text-sm text-gray-600">
                    {{ imageName }}
                </span>
                <span v-else class="text-sm text-gray-400">Файл не выбран</span>

                <button
                    type="button"
                    @click="removeImage"
                    class="w-full rounded-md bg-red-700 px-4 py-2 font-semibold text-white transition hover:bg-red-600 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:outline-none active:scale-[0.98] disabled:opacity-50"
                >
                    Очистить
                </button>
            </div>
            <div
                v-else
                class="flex h-48 w-full items-center justify-center rounded-md border border-gray-300 bg-gray-200"
            >
                <p class="text-center text-2xl text-gray-400">
                    Image Placeholder
                </p>
            </div>
        </div>

        <div class="flex flex-col items-center justify-center gap-4">
            <!-- Блок выбора изображения -->
            <input
                id="postImage"
                ref="fileInput"
                type="file"
                accept="image/*"
                class="hidden"
                @change="onFileSelected"
            />

            <!-- Кнопка выбора изображения-->
            <button
                v-if="!previewUrl"
                type="button"
                @click="triggerFileInput"
                class="rounded-md bg-gray-200 px-4 py-2 font-semibold text-gray-700 transition hover:bg-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none active:scale-[0.98]"
            >
                Выбрать изображение
            </button>

            <!-- Кнопка отправки на сервер-->
            <button
                type="submit"
                :disabled="isLoading"
                class="w-full rounded-md bg-blue-600 px-4 py-2 font-semibold text-white transition hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:outline-none active:scale-[0.98] disabled:opacity-50"
            >
                {{ isLoading ? 'Загрузка...' : 'Загрузить на сервер' }}
            </button>

            <!-- Сообщение об ошибке -->
            <p
                v-if="errorMessage"
                class="mt-3 text-center text-sm text-red-600"
            >
                {{ errorMessage }}
            </p>
        </div>
    </form>
</template>

<script setup lang="ts">
import { X } from '@lucide/vue';
import { ref } from 'vue';
import api from '@spa/axios';

const title = ref('');
const content = ref('');
const imageFile = ref<File | null>(null);
const imageName = ref('');
const previewUrl = ref<string | null>(null);
const uploadedImageUrl = ref<string | null>(null);
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
        fileInput.value = null;
    }
};

// Отправка формы
const imageStore = async () => {
    errorMessage.value = '';
    isLoading.value = true;

    try {
        const formData = new FormData();
        if (imageFile.value) {
            formData.append('image', imageFile.value);
            formData.append('is_active', '0');
        }

        const response = await api.post('/api/images', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });

        uploadedImageUrl.value = response.data.url;
        console.log('Изображение загружено на сервер:', response.data);

        // Очистка формы после успешной отправки
        resetForm();
    } catch (error: any) {
        console.error(error);
        errorMessage.value =
            error.response?.data?.message ||
            'Ошибка при загрузке изображения на сервер';
    } finally {
        isLoading.value = false;
    }
};

const uploadedImageClose = () => {
    uploadedImageUrl.value = null;
};
</script>
