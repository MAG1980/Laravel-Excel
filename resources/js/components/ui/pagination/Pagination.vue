<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Meta } from '@/types';
import { computed } from 'vue';

const { meta } = defineProps<{ meta: Meta }>();

// Извлекаем ссылки из meta
const links = computed(() => meta.links || []);

// Находим ссылку "Previous" и "Next" по label
const prevPageUrl = computed(() => {
    const prevLink = links.value.find(link => link.label === '&laquo; Previous');
    return prevLink?.url || null;
});

const nextPageUrl = computed(() => {
    const nextLink = links.value.find(link => link.label === 'Next &raquo;');
    return nextLink?.url || null;
});

// Фильтруем только основные ссылки страниц (исключая "Previous" и "Next")
const pageLinks = computed(() => {
    return links.value.filter(link => link.label !== '&laquo; Previous' && link.label !== 'Next &raquo;');
});
</script>

<template>
    <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
        <!-- Мобильная версия -->
        <div class="flex flex-1 justify-between sm:hidden">
            <Link
                v-if="prevPageUrl"
                :href="prevPageUrl"
                :class="[
                    'relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50',
                    { 'pointer-events-none opacity-50': !prevPageUrl }
                ]"
            >
                Previous
            </Link>
            <Link
                v-if="nextPageUrl"
                :href="nextPageUrl"
                :class="[
                    'relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50',
                    { 'pointer-events-none opacity-50': !nextPageUrl }
                ]"
            >
                Next
            </Link>
        </div>

        <!-- Десктопная версия -->
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Showing
                    <span class="font-medium">{{ meta.from ?? 0 }}</span>
                    to
                    <span class="font-medium">{{ meta.to ?? 0 }}</span>
                    of
                    <span class="font-medium">{{ meta.total ?? 0 }}</span>
                    results
                </p>
            </div>

            <nav aria-label="Pagination" class="isolate inline-flex -space-x-px rounded-md shadow-xs">
                <!-- Previous link (left arrow) -->
                <Link
                    v-if="prevPageUrl"
                    :href="prevPageUrl"
                    :class="[
                        'relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0',
                        { 'pointer-events-none opacity-50': !prevPageUrl }
                    ]"
                >
                    <span class="sr-only">Previous</span>
                    <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-5">
                        <path
                            d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" />
                    </svg>
                </Link>

                <!-- Нумерация страниц -->
                <template v-for="link in pageLinks" :key="link.label">
                    <!-- Если ссылка активна и есть url -->
                    <Link
                        v-if="link.url"
                        :href="link.url"
                        :aria-current="link.active ? 'page' : undefined"
                        :class="[
                            'relative inline-flex items-center px-4 py-2 text-sm font-semibold focus:z-20 focus-visible:outline-2 focus-visible:outline-offset-2',
                            link.active
                                ? 'z-10 bg-indigo-600 text-white focus-visible:outline-indigo-600'
                                : 'text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:outline-offset-0'
                        ]"
                    >
                        {{ link.label }}
                    </Link>
                    <!-- Если url = null (например, разделитель "...") -->
                    <span
                        v-else
                        class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 focus:outline-offset-0"
                    >
                        {{ link.label }}
                    </span>
                </template>

                <!-- Next link (right arrow) -->
                <Link
                    v-if="nextPageUrl"
                    :href="nextPageUrl"
                    :class="[
                        'relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0',
                        { 'pointer-events-none opacity-50': !nextPageUrl }
                    ]"
                >
                    <span class="sr-only">Next</span>
                    <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-5">
                        <path
                            d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" />
                    </svg>
                </Link>
            </nav>
        </div>
    </div>
</template>
