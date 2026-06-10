<script setup lang="ts">
import { Head, useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import {index as indexProjects} from '@/routes/projects';
import {
    show as importShow,
    store as importStore,
} from '@/routes/projects/import';
import type { BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Project Import',
        href: importShow().url,
    },
];

const form = useForm({
    file: null as File | null,
    type: 1,
});

const refInputFile = ref<HTMLInputElement | null>(null);
const refSelectedType = ref(1);
const selectFile = () => {
    // открываем диалог выбора файла
    refInputFile.value?.click();
};

const handleTypeChange = (e: Event) => {
    const selectedType = e.target as HTMLSelectElement;
    const selectedTypeValue = Number(selectedType.value);
    console.log({ selectedTypeValue });
    if (selectedTypeValue) {
        form.type = selectedTypeValue;
    }
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

            router.visit(indexProjects().url)
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
                    class="flex items-center flex-col justify-around gap-4"
                    @submit.prevent="storeFile"
                >
                    <input
                        class="hidden"
                        type="file"
                        ref="refInputFile"
                        @change="handleFileChange"
                    />
                    <div class="flex w-1/2 flex-col">
                        <label for="type-select" class="w-full py-2 px-4"
                            >Выберите тип импортируемого файла</label
                        >
                        <select
                            id="type-select"
                            v-model="refSelectedType"
                            class="w-full py-2 px-4"
                            @change="handleTypeChange($event)"
                        >
                            <option value="1">Статические столбцы</option>
                            <option value="2">Динамические столбцы</option>
                        </select>
                    </div>
                   <div class="flex justify-between w-1/2">
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
                   </div>
                </form>
                <!-- Отображение выбранного файла -->
                <div>Selected file: {{ form.file?.name }}</div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped></style>
