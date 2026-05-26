<script lang="ts" setup>
import { Link } from '@inertiajs/vue3'
import { ClipboardClockIcon, LayoutGrid } from '@lucide/vue'
import AppLogo from '@/components/AppLogo.vue'
import NavMain from '@/components/NavMain.vue'
import NavUser from '@/components/NavUser.vue'
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar'
import { dashboard } from '@/routes'
import flight from '@/routes/flight'
import type { NavItem } from '@/types'

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
]

const actionsNavItems: NavItem[] = [
    {
        title: 'Book a Flight',
        href: flight.list(),
        icon: ClipboardClockIcon,
    },
]
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton as-child size="lg">
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" label="Platform" />
            <NavMain :items="actionsNavItems" label="Pilot Actions" />
        </SidebarContent>

        <SidebarFooter>
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
