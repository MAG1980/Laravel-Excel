<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { show as importShow, store as importStore } from '@/routes/projects/import';
import type { BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Project Import',
        href: importShow().url,
    },
];

const form = useForm({
    file: null as File | null,
});

const refInputFile = ref<HTMLInputElement | null>(null);
const selectFile = () => {
    // открываем диалог выбора файла
    refInputFile.value?.click();
};

const handleFileChange = (e: Event) => {
    const target = e.target as HTMLInputElement;
    const file = target.files?.[0];

    if (file) {
        form.file = file;
        console.log(`Выбран файл ${file.name}`);
    }
};

const storeFile = () => {
    if (!form.file) {
        alert('Please select a file first!');
        return;
    }

    form.post(importStore().url, {
        onSuccess: () => {
            form.reset('file');

            if (refInputFile.value) {
                refInputFile.value.value = '';
            }
        },

        onError: (errors) => {
            console.error('Import failed: ', errors);
        },
    });
};
</script>

<template>
    <Head title="Project Import" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div>
            <h1>Project Import</h1>
            <div>
                <form
                    class="flex w-1/2 justify-around"
                    @submit.prevent="storeFile"
                >
                    <input
                        class="hidden"
                        type="file"
                        ref="refInputFile"
                        @change="handleFileChange"
                    />
                    <Button
                        class="bg-sky-500 hover:bg-sky-700"
                        type="button"
                        @click.prevent="selectFile"
                        >Select file
                    </Button>
                    <Button
                        class="bg-green-500 hover:bg-green-700"
                        type="submit"
                        :disabled="form.processing || !form.file"
                    >
                        {{ form.processing ? 'Importing...' : 'Store file' }}
                    </Button>
                </form>
                <!-- Отображение выбранного файла -->
                <div>Selected file: {{ form.file?.name }}</div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped></style>
