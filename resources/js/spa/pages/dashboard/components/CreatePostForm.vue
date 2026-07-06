<template>
    <form
        @submit.prevent="onSubmit"
        class="relative mx-auto mt-10 flex max-w-md flex-col gap-2 rounded-lg bg-white p-6 shadow-md"
    >
        <LoaderCircle
            v-if="isSubmitting"
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 animate-spin text-blue-600"
            :size="96"
            :stroke-width="2.5"
            aria-label="Loading"
        />
        <!-- Заголовок -->
        <div>
            <label
                for="title"
                class="mb-2 block text-sm font-bold text-gray-700"
            >
                Заголовок
            </label>
            <input
                id="title"
                v-model="title"
                v-bind="titleAttrs"
                type="text"
                placeholder="Введите заголовок"
                class="w-full rounded-md border border-gray-300 px-4 py-2 transition duration-200 focus:border-transparent focus:ring-2 focus:ring-blue-500 focus:outline-none"
            />

            <!-- Сообщение об ошибке -->
            <p v-if="errors.title" class="mt-1 text-sm text-red-600">
                {{ errors.title }}
            </p>
        </div>

        <!-- Содержание -->
        <div>
            <label
                for="content"
                class="mb-2 block text-sm font-bold text-gray-700"
            >
                Содержание
            </label>
            <textarea
                id="content"
                v-model="content"
                v-bind="contentAttrs"
                placeholder="Введите текст поста"
                rows="5"
                class="w-full resize-y rounded-md border border-gray-300 px-4 py-2 transition duration-200 focus:border-transparent focus:ring-2 focus:ring-blue-500 focus:outline-none"
            ></textarea>

            <!-- Сообщение об ошибке -->
            <p v-if="errors.content" class="mt-1 text-sm text-red-600">
                {{ errors.content }}
            </p>
        </div>

        <!-- Блок выбора изображения -->
        <div class="flex items-center gap-4">
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
                class="flex flex-col items-center justify-center"
            >
                <img
                    :src="previewUrl"
                    alt="Превью"
                    class="mb-3 max-h-48 max-w-min rounded-md border border-gray-200 object-contain"
                />
                <span v-if="imageName" class="text-sm text-gray-600">
                    {{ imageName }}
                </span>
            </div>
        </OutInTransition>

        <!-- Сообщение об ошибке -->
        <p v-if="errors.image" class="mt-1 text-sm text-red-600">
            {{ errors.image }}
        </p>

        <button
            v-if="previewUrl&&!isSubmitting"
            type="button"
            @click="clearSelectedImage"
            class="w-full rounded-md bg-red-700 px-4 py-2 font-semibold text-white transition hover:bg-red-600 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:outline-none active:scale-[0.98] disabled:opacity-50"
        >
            Удалить изображение
        </button>

        <!-- Кнопка отправки -->
        <button
            type="submit"
            :disabled="
                !previewUrl|| isSubmitting || errors.title || errors.content || errors.image
            "
            class="w-full rounded-md bg-blue-600 px-4 py-2 font-semibold text-white transition hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:outline-none active:scale-[0.98] disabled:opacity-50"
        >
            <span class="flex items-center justify-center gap-2">
                <span>{{ isSubmitting ? 'Создание...' : 'Создать пост' }}</span>
                <span>
                    <LoaderCircle
                        v-if="isSubmitting"
                        class="animate-spin text-blue-600"
                        :size="16"
                        :stroke-width="2.5"
                        aria-label="Loading"
                    />
                </span>
            </span>
        </button>

        <!-- Сообщение об ошибке от сервера -->
        <p v-if="errorMessage" class="mt-3 text-center text-sm text-red-600">
            {{ errorMessage }}
        </p>
    </form>
</template>

<script setup lang="ts">
import { LoaderCircle } from '@lucide/vue';
import { toTypedSchema } from '@vee-validate/zod';
import { useForm } from 'vee-validate';
import { ref } from 'vue';
import api from '@spa/axios';
import OutInTransition from '@spa/components/OutInTransition.vue';
import { createPostSchema } from '@spa/pages/dashboard/schemas/create-post.schema';

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
    validationSchema: toTypedSchema(createPostSchema),
});

const [title, titleAttrs] = defineField('title');
const [content, contentAttrs] = defineField('content');
// Поле image мы не привязываем через v-bind, т.к. управляем вручную через метод onFileSelected
// Но defineField нужен для регистрации поля в валидации
defineField('image');

// Состояние изображения (не входит в схему, управляем вручную)
const imageFile = ref<File | null>(null);
const imageName = ref('');
const previewUrl = ref<string | null>(null);
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
        // 👇 обновляем поле формы и валидируем
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
    validateField('image'); // сразу очистим ошибку

    // Сбрасываем input, чтобы при повторном выборе того же файла сработало событие change
    if (fileInput.value) {
        fileInput.value.value = '';
    }
};

// Отправка формы через useForm.handleSubmit()
const onSubmit = handleSubmit(async (values) => {
    // values содержит { title, content } уже валидные
    errorMessage.value = '';

    try {
        const formData = new FormData();
        formData.append('title', values.title.trim());
        formData.append('content', values.content.trim());
        if (imageFile.value) {
            formData.append('image', imageFile.value);
        }

        const response = await api.post('/api/posts', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });

        console.log('Пост создан:', response.data);

        // Сброс всей формы (значения + ошибки)
        resetForm();
        // Также сбрасываем изображение
        clearSelectedImage();
    } catch (error: any) {
        console.error(error);
        errorMessage.value =
            error.response?.data?.message || 'Ошибка при создании поста';
    } finally {
    }
});
</script>
