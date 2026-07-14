<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Gem } from 'lucide-vue-next';
import {
    SidebarGroup,
    SidebarGroupLabel,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { useCurrentUrl } from '@/composables/useCurrentUrl';
import { type NavItem } from '@inertia/types';

defineProps<{
    items: NavItem[];
}>();

const { isCurrentUrl } = useCurrentUrl();

const appUrl: string = import.meta.env.VITE_APP_URL
</script>

<template>
    <SidebarGroup class="px-2 py-0">
        <SidebarGroupLabel>Platform</SidebarGroupLabel>
        <SidebarMenu>
            <SidebarMenuItem>
                <a :href="`${appUrl}/spa/user/dashboard`">
                <SidebarMenuButton>
                        <div class="flex text-gray-500 w-full cursor-pointer">
                        <Gem :size="16"/>
                        <span class="ml-2">SPA</span>
                    </div>
                </SidebarMenuButton></a>
            </SidebarMenuItem>

            <SidebarMenuItem v-for="item in items" :key="item.title">
                <SidebarMenuButton
                    as-child
                    :is-active="isCurrentUrl(item.href)"
                    :tooltip="item.title"
                >
                    <Link :href="item.href">
                        <component :is="item.icon" />
                        <span>{{ item.title }}</span>
                    </Link>
                </SidebarMenuButton>
            </SidebarMenuItem>
        </SidebarMenu>
    </SidebarGroup>
</template>
