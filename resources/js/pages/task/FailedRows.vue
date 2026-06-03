<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import Pagination from '@/components/ui/pagination/Pagination.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { index as tasksIndex } from '@/routes/tasks';
import type { BreadcrumbItem, Meta } from '@/types';

interface FailedRow {
    id: number;
    taskId: string;
    rowNumber: number;
    key: string;
    message: string;
    createdAt: string;
    updatedAt: string;
}

const { failedRows } = defineProps<{
    failedRows: { data: FailedRow[]; meta: Meta };
}>();

const { data, meta } = failedRows;

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'failed Rows',
        href: tasksIndex().url,
    },
];

</script>
<template>
    <Head title="Failed Rows" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex flex-col gap-1 rounded-xl bg-gray-950/5 p-1 inset-ring inset-ring-gray-950/5 dark:bg-white/10 dark:inset-ring-white/10"
        >
            <div
                class="not-prose overflow-auto rounded-lg bg-white p-2 outline outline-white/5 dark:bg-gray-950/50"
            >
                <h1 class="mb-4 text-center text-2xl font-bold">Failed Rows</h1>

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
                                Task ID
                            </th>
                            <th
                                class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium break-all text-gray-400 dark:border-gray-600 dark:text-gray-200"
                            >
                                Row Number
                            </th>
                            <th
                                class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 dark:border-gray-600 dark:text-gray-200"
                            >
                                Key
                            </th>
                            <th
                                class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 dark:border-gray-600 dark:text-gray-200"
                            >
                                Message
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
                        <tr v-for="failedRow of data" :key="failedRow.id">
                            <td
                                class="border-b border-gray-100 p-4 pl-8 text-gray-500 dark:border-gray-700 dark:text-gray-400"
                            >
                                {{ failedRow.id }}
                            </td>
                            <td
                                class="border-b border-gray-100 p-4 pl-8 text-gray-500 dark:border-gray-700 dark:text-gray-400"
                            >
                                {{ failedRow.taskId }}
                            </td>
                            <td
                                class="border-b border-gray-100 p-4 pl-8 text-gray-500 dark:border-gray-700 dark:text-gray-400"
                            >
                                {{ failedRow.rowNumber }}
                            </td>
                            <td
                                class="border-b border-gray-100 p-4 pl-8 break-all text-gray-500 dark:border-gray-700 dark:text-gray-400"
                            >
                                {{ failedRow.key }}
                            </td>
                            <td
                                class="border-b border-gray-100 p-4 pl-8 text-gray-500 dark:border-gray-700 dark:text-gray-400"
                            >
                                {{ failedRow.message }}
                            </td>
                            <td
                                class="border-b border-gray-100 p-4 pl-8 break-all text-gray-500 dark:border-gray-700 dark:text-gray-400"
                            >
                                {{
                                    new Date(
                                        failedRow.createdAt,
                                    ).toLocaleString()
                                }}
                            </td>
                            <td
                                class="border-b border-gray-100 p-4 pl-8 break-all text-gray-500 dark:border-gray-700 dark:text-gray-400"
                            >
                                {{
                                    new Date(
                                        failedRow.updatedAt,
                                    ).toLocaleString()
                                }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="m-4 flex justify-end">
                    <Link
                        :href="tasksIndex().url"
                        class="rounded-md border border-blue-500 px-4 py-2 text-blue-500 dark:text-blue-400"
                        >Back to Tasks
                    </Link>
                </div>
            </div>
            <Pagination :meta="meta" />
        </div>
    </AppLayout>
</template>

<style scoped></style>
