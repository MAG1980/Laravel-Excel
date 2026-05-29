<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { index as tasksIndex } from '@/routes/tasks';
import type { BreadcrumbItem } from '@/types';

type User = {
    id: number;
    name: string;
};

interface Task {
    id: number;
    user: User;
    file: { path: string };
    status: string;
    createdAt: string;
    updatedAt: string;
}

const { tasks } = defineProps<{
    tasks: { data: Task[] };
}>();

const { data }: { data: Task[] } = tasks;

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Tasks',
        href: tasksIndex().url,
    },
];

console.log(data);
</script>
<template>
    <Head title="Tasks" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex flex-col gap-1 rounded-xl bg-gray-950/5 p-1 inset-ring inset-ring-gray-950/5 dark:bg-white/10 dark:inset-ring-white/10"
        >
            <div
                class="not-prose overflow-auto rounded-lg bg-white p-2 outline outline-white/5 dark:bg-gray-950/50"
            >
                <h1 class="mb-4 text-center text-2xl font-bold">Tasks</h1>
                <table class="w-full table-fixed border-collapse text-sm">
                    <thead>
                        <tr>
                            <th
                                class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 dark:border-gray-600 dark:text-gray-200"
                            >
                                ID
                            </th>
                            <th
                                class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 dark:border-gray-600 dark:text-gray-200"
                            >
                                User ID
                            </th>
                            <th
                                class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium break-all text-gray-400 dark:border-gray-600 dark:text-gray-200"
                            >
                                File Path
                            </th>
                            <th
                                class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 dark:border-gray-600 dark:text-gray-200"
                            >
                                Status
                            </th>
                            <th
                                class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 dark:border-gray-600 dark:text-gray-200"
                            >
                                Created At
                            </th>
                            <th
                                class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 dark:border-gray-600 dark:text-gray-200"
                            >
                                Updated At
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800">
                        <tr v-for="task of data" :key="task.id">
                            <td
                                class="border-b border-gray-100 p-4 pl-8 text-gray-500 dark:border-gray-700 dark:text-gray-400"
                            >
                                {{ task.id }}
                            </td>
                            <td
                                class="border-b border-gray-100 p-4 pl-8 text-gray-500 dark:border-gray-700 dark:text-gray-400"
                            >
                                {{ task.user.id }}
                            </td>
                            <td
                                class="border-b border-gray-100 p-4 pl-8 break-all text-gray-500 dark:border-gray-700 dark:text-gray-400"
                            >
                                {{ task.file.path }}
                            </td>
                            <td
                                class="border-b border-gray-100 p-4 pl-8 text-gray-500 dark:border-gray-700 dark:text-gray-400"
                            >
                                {{ task.status }}
                            </td>
                            <td
                                class="border-b border-gray-100 p-4 pl-8 break-all text-gray-500 dark:border-gray-700 dark:text-gray-400"
                            >
                                {{ new Date(task.createdAt).toLocaleString() }}
                            </td>
                            <td
                                class="border-b border-gray-100 p-4 pl-8 break-all text-gray-500 dark:border-gray-700 dark:text-gray-400"
                            >
                                {{ new Date(task.updatedAt).toLocaleString() }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped></style>
