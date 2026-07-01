<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import Pagination from '@/components/ui/pagination/Pagination.vue';
import { dashboard } from '@/routes';
import { index as projectsIndex } from '@/routes/projects';
import AppLayout from '@inertia/layouts/AppLayout.vue';
import type { BreadcrumbItem, Meta } from '@inertia/types';
import type { Project } from '@inertia/types/project';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Projects',
        href: projectsIndex().url,
    },
];

const { projects } = defineProps<{
    projects: { data: Project[]; meta: Meta };
}>();

const { data, meta } = projects;
</script>

<template>
    <Head title="Projects" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div>
            <h1>Projects Index</h1>
        </div>
        <div
            class="flex flex-col gap-1 rounded-xl bg-gray-950/5 p-1 inset-ring inset-ring-gray-950/5 dark:bg-white/10 dark:inset-ring-white/10"
        >
            <div
                class="not-prose overflow-auto rounded-lg bg-white p-2 outline outline-white/5 dark:bg-gray-950/50"
            >
                <h1 class="mb-4 text-center text-2xl font-bold">Projects</h1>
                <table class="w-full table-fixed border-collapse text-sm">
                    <thead>
                        <tr>
                            <th
                                class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 dark:border-gray-600 dark:text-gray-200"
                            >
                                Type
                            </th>
                            <th
                                class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 dark:border-gray-600 dark:text-gray-200"
                            >
                                Title
                            </th>
                            <th
                                class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium break-all text-gray-400 dark:border-gray-600 dark:text-gray-200"
                            >
                                Created At
                            </th>
                            <th
                                class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 dark:border-gray-600 dark:text-gray-200"
                            >
                                Worker Count
                            </th>
                            <th
                                class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 dark:border-gray-600 dark:text-gray-200"
                            >
                                Service Count
                            </th>
                            <th
                                class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 dark:border-gray-600 dark:text-gray-200"
                            >
                                Has Investors
                            </th>
                            <th
                                class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 dark:border-gray-600 dark:text-gray-200"
                            >
                                Has Outsourcing
                            </th>
                            <th
                                class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 dark:border-gray-600 dark:text-gray-200"
                            >
                                Is On Time
                            </th>
                            <th
                                class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 dark:border-gray-600 dark:text-gray-200"
                            >
                                Is Network
                            </th>
                            <th
                                class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 dark:border-gray-600 dark:text-gray-200"
                            >
                                Deadline
                            </th>
                            <th
                                class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 dark:border-gray-600 dark:text-gray-200"
                            >
                                Contracted At
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800">
                        <tr v-for="project of data" :key="project.id">
                            <td
                                class="border-b border-gray-100 p-4 pl-8 text-gray-500 dark:border-gray-700 dark:text-gray-400"
                            >
                                {{ project.type.title }}
                            </td>
                            <td
                                class="border-b border-gray-100 p-4 pl-8 text-gray-500 dark:border-gray-700 dark:text-gray-400"
                            >
                                {{ project.title }}
                            </td>
                            <td
                                class="border-b border-gray-100 p-4 pl-8 break-all text-gray-500 dark:border-gray-700 dark:text-gray-400"
                            >
                                {{
                                    new Date(
                                        project.createdAtDate,
                                    ).toLocaleString()
                                }}
                            </td>
                            <td
                                class="border-b border-gray-100 p-4 pl-8 text-gray-500 dark:border-gray-700 dark:text-gray-400"
                            >
                                {{ project.workerCount }}
                            </td>
                            <td
                                class="border-b border-gray-100 p-4 pl-8 text-gray-500 dark:border-gray-700 dark:text-gray-400"
                            >
                                {{ project.serviceCount }}
                            </td>
                            <td
                                class="border-b border-gray-100 p-4 pl-8 text-gray-500 dark:border-gray-700 dark:text-gray-400"
                            >
                                {{ project.hasInvestors }}
                            </td>
                            <td
                                class="border-b border-gray-100 p-4 pl-8 text-gray-500 dark:border-gray-700 dark:text-gray-400"
                            >
                                {{ project.hasOutsource }}
                            </td>
                            <td
                                class="border-b border-gray-100 p-4 pl-8 text-gray-500 dark:border-gray-700 dark:text-gray-400"
                            >
                                {{ project.isOnTime }}
                            </td>
                            <td
                                class="border-b border-gray-100 p-4 pl-8 text-gray-500 dark:border-gray-700 dark:text-gray-400"
                            >
                                {{ project.isNetwork }}
                            </td>
                            <td
                                class="border-b border-gray-100 p-4 pl-8 text-gray-500 dark:border-gray-700 dark:text-gray-400"
                            >
                                {{
                                    new Date(
                                        project.deadline,
                                    ).toLocaleDateString()
                                }}
                            </td>
                            <td
                                class="border-b border-gray-100 p-4 pl-8 text-gray-500 dark:border-gray-700 dark:text-gray-400"
                            >
                                {{
                                    new Date(
                                        project.contractedAt,
                                    ).toLocaleString()
                                }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="m-4 flex justify-end">
                    <Link
                        :href="dashboard().url"
                        class="rounded-md border border-blue-500 px-4 py-2 text-blue-500 dark:text-blue-400"
                        >Back to Dashboard
                    </Link>
                </div>
            </div>
            <Pagination :meta="meta" />
        </div>
    </AppLayout>
</template>

<style scoped></style>
