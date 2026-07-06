<template>
    <Transition
        mode="out-in"
        enter-active-class="transition-all duration-300 ease-out"
        leave-active-class="transition-all duration-300 ease-in"
        enter-from-class="opacity-0 translate-y-1"
        leave-to-class="opacity-0 -translate-y-1"
        enter-to-class="opacity-100 translate-y-0"
        leave-from-class="opacity-100 translate-y-0"
    >
        <div v-if="uploadedImageUrl" key="uploaded" class="relative">
            <div class="absolute top-20 right-20">
                <X
                    @click="uploadedImageClose"
                    class="cursor-pointer rounded-full bg-red-500 p-2 text-lg text-gray-100 transition-transform hover:scale-110"
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
            key="form"
            @submit.prevent="onSubmit"
            class="mx-auto mt-10 flex max-w-md flex-col gap-4 rounded-lg bg-white p-6 shadow-md"
        >
            <!-- Превью изображения -->
            <div>
                <div
                    v-if="previewUrl"
                    class="flex flex-col items-center justify-center"
                >
                    <div class="relative">
                        <LoaderCircle
                            v-if="isSubmitting"
                            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 animate-spin text-blue-600"
                            :size="48"
                            :stroke-width="2.5"
                            aria-label="Loading"
                        />
                        <img
                            :src="previewUrl"
                            alt="Превью"
                            class="max-h-48 max-w-min rounded-md border border-gray-200 object-contain"
                        />
                    </div>
                    <span v-if="imageName" class="text-sm text-gray-600">
                        {{ imageName }}
                    </span>
                    <span v-else class="text-sm text-gray-400"
                        >Файл не выбран</span
                    >
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

            <!-- Сообщение об ошибке валидации-->
            <p v-if="errors.image" class="mt-1 text-sm text-red-600">
                {{ errors.image }}
            </p>

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

                <div class="flex flex-col items-center justify-center w-full gap-4">
                    <button
                        v-if="!isSubmitting && previewUrl"
                        type="button"
                        @click="clearSelectedImage"
                        class="w-full rounded-md bg-red-700 px-4 py-2 font-semibold text-white transition hover:bg-red-600 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:outline-none active:scale-[0.98] disabled:opacity-50"
                    >
                        Очистить
                    </button>
                    <!-- Кнопка выбора изображения-->
                    <button
                        v-if="!isSubmitting&&!previewUrl"
                        type="button"
                        @click="triggerFileInput"
                        class="w-full rounded-md bg-gray-200 px-4 py-2 font-semibold text-gray-700 transition hover:bg-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none active:scale-[0.98]"
                    >
                        Выбрать изображение
                    </button>
                    <!-- Кнопка отправки на сервер-->
                    <button
                        :disabled="isSubmitting || errors.image"
                        type="submit"
                        class="w-full rounded-md bg-blue-600 px-4 py-2 font-semibold text-white transition hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:outline-none active:scale-[0.98] disabled:opacity-50"
                    >
                        {{ isSubmitting ? 'Загрузка...' : 'Загрузить на сервер' }}
                    </button>
                </div>
                <!-- Сообщение об ошибке сервера-->
                <p
                    v-if="serverErrorMessage"
                    class="mt-3 text-center text-sm text-red-600"
                >
                    {{ serverErrorMessage }}
                </p>
            </div>
        </form>
    </Transition>
</template>

<script setup lang="ts">
import { X, LoaderCircle } from '@lucide/vue';
import { toTypedSchema } from '@vee-validate/zod';
import { useForm } from 'vee-validate';
import { ref } from 'vue';
import api from '@spa/axios';
import { uploadImageSchema } from '@spa/pages/dashboard/schemas/upload-image.schema';

// Настройка формы
const {
    defineField,
    errors,
    handleSubmit,
    resetForm,
    isSubmitting,
    setFieldValue,
    validateField,
} = useForm({
    validationSchema: toTypedSchema(uploadImageSchema),
});
// Поле image мы не привязываем через v-bind, т.к. управляем вручную через метод onFileSelected
// Но defineField нужен для регистрации поля в валидации
defineField('image');

const imageFile = ref<File | null>(null);
const imageName = ref('');
const previewUrl = ref<string | null>(null);
const uploadedImageUrl = ref<string | null>(null);
const serverErrorMessage = ref('');

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
        setFieldValue('image', file);
        validateField('image'); // сразу покажем ошибку, если файл не подходит
    } else {
        imageFile.value = null;
        imageName.value = '';
        previewUrl.value = null;
        setFieldValue('image', undefined);
        validateField('image'); // очищаем ошибку
    }
    // Сбрасываем поле, чтобы можно было выбрать тот же файл повторно
    target.value = '';
};

// Снять выбор с изображения
const clearSelectedImage = () => {
    if (previewUrl.value) {
        // Очистка оперативной памяти, чтобы избежать утечек
        URL.revokeObjectURL(previewUrl.value);
        previewUrl.value = null;
    }
    imageFile.value = null;
    imageName.value = '';
    setFieldValue('image', undefined);
    validateField('image'); // очищаем ошибку

    // Сбрасываем input, чтобы при повторном выборе того же файла сработало событие change
    if (fileInput.value) {
        fileInput.value.value = '';
    }
};

// Отправка формы
const onSubmit = handleSubmit(async () => {
    serverErrorMessage.value = '';

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
        console.log({ response });
        console.log(uploadedImageUrl.value);
        console.log('Изображение загружено на сервер:', response.data);

        // Очистка формы после успешной отправки
        resetForm();
        // Также сбрасываем изображение
        clearSelectedImage();
    } catch (error: any) {
        console.error(error);
        serverErrorMessage.value =
            error.response?.data?.message ||
            'Ошибка при загрузке изображения на сервер';
    } finally {
    }
});

const uploadedImageClose = () => {
    uploadedImageUrl.value = null;
};
</script>
