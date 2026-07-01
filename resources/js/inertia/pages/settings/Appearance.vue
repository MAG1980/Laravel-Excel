<script setup lang="ts">
import { edit } from '@inertia/routes/appearance';
import { Head } from '@inertiajs/vue3';
import AppearanceTabs from '@inertia/components/AppearanceTabs.vue';
import Heading from '@inertia/components/Heading.vue';
import AppLayout from '@inertia/layouts/AppLayout.vue';
import SettingsLayout from '@inertia/layouts/settings/Layout.vue';
import { type BreadcrumbItem } from '@inertia/types';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Appearance settings',
        href: edit().url,
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Appearance settings" />

        <h1 class="sr-only">Appearance Settings</h1>

        <SettingsLayout>
            <div class="space-y-6">
                <Heading
                    variant="small"
                    title="Appearance settings"
                    description="Update your account's appearance settings"
                />
                <AppearanceTabs />
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
