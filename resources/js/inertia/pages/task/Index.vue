<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    index as tasksIndex,
    failedRows as failedRowsRoute,
} from '@/routes/tasks';
import Pagination from '@inertia/components/ui/pagination/Pagination.vue';
import AppLayout from '@inertia/layouts/AppLayout.vue';
import type { BreadcrumbItem, Meta } from '@inertia/types';

type User = {
    id: number;
    name: string;
};

interface Task {
    id: number;
    user: User;
    file: { path: string };
    status: string;
    failedRowsCount: number;
    createdAt: string;
    updatedAt: string;
}

const { tasks } = defineProps<{
    tasks: { data: Task[]; meta: Meta };
}>();

const { data, meta }: { data: Task[]; meta: Meta } = tasks;

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Tasks',
        href: tasksIndex().url,
    },
];
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
                                Failed Rows
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
                                class="border-b border-gray-100 p-4 pl-8 text-gray-500 dark:border-gray-700 dark:text-gray-400"
                            >
                                <Link
                                    class="rounded-md border border-red-500 px-4 py-2 text-red-500 dark:text-red-400"
                                    v-if="task.failedRowsCount"
                                    :href="
                                        failedRowsRoute.url({ taskId: task.id })
                                    "
                                    >View Failed Rows
                                </Link>
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

                <Pagination :meta="meta" />
            </div>
        </div>
    </AppLayout>
</template>

<style scoped></style>
