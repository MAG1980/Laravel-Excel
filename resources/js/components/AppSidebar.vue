<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {
    BookOpen,
    Folder,
    FolderClosed,
    Import,
    LayoutGrid,
    List,
} from 'lucide-vue-next';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import { index as projectsIndex } from '@/routes/projects';
import { show as projectsImportShow } from '@/routes/projects/import';
import { index as tasksIndex } from '@/routes/tasks';
import NavFooter from '@inertia/components/NavFooter.vue';
import NavMain from '@inertia/components/NavMain.vue';
import NavUser from '@inertia/components/NavUser.vue';
import { type NavItem } from '@inertia/types';
import AppLogo from './AppLogo.vue';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
    {
        title: 'Projects',
        href: projectsIndex(),
        icon: List,
    },
    {
        title: 'Project Import',
        href: projectsImportShow(),
        icon: Import,
    },
    {
        title: 'Tasks',
        href: tasksIndex(),
        icon: FolderClosed,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
