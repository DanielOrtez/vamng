<script lang="ts" setup>
import { ChevronsUpDown } from '@lucide/vue'
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
import {
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    useSidebar,
} from '@/components/ui/sidebar'
import UserInfo from '@/components/UserInfo.vue'
import UserMenuContent from '@/components/UserMenuContent.vue'
import useAuth from '@/composables/useAuth'

const { user, hasPermission } = useAuth()
const { isMobile, state } = useSidebar()
</script>

<template>
    <SidebarMenu>
        <SidebarMenuItem>
            <DropdownMenu>
                <DropdownMenuTrigger as-child>
                    <SidebarMenuButton
                        class="data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground"
                        data-test="sidebar-menu-button"
                        size="lg"
                    >
                        <UserInfo :user="user" />
                        <ChevronsUpDown class="ml-auto size-4" />
                    </SidebarMenuButton>
                </DropdownMenuTrigger>
                <DropdownMenuContent
                    :side="
                        isMobile
                            ? 'bottom'
                            : state === 'collapsed'
                              ? 'left'
                              : 'bottom'
                    "
                    :side-offset="4"
                    align="end"
                    class="w-(--reka-dropdown-menu-trigger-width) min-w-56 rounded-lg"
                >
                    <UserMenuContent
                        :can-access-admin-panel="
                            hasPermission('access admin panel')
                        "
                        :user="user"
                    />
                </DropdownMenuContent>
            </DropdownMenu>
        </SidebarMenuItem>
    </SidebarMenu>
</template>
