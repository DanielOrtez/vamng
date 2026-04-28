<script lang="ts" setup>
import { Link, router } from '@inertiajs/vue3'
import { LogOut, Settings, ShieldUser } from '@lucide/vue'
import {
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
} from '@/components/ui/dropdown-menu'
import UserInfo from '@/components/UserInfo.vue'
import { logout } from '@/routes'
import { edit } from '@/routes/profile'
import type { User } from '@/types'

type Props = {
    user: User
    canAccessAdminPanel?: boolean
}

const handleLogout = () => {
    router.flushAll()
}

defineProps<Props>()
</script>

<template>
    <DropdownMenuLabel class="p-0 font-normal">
        <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
            <UserInfo :show-email="true" :user="user" />
        </div>
    </DropdownMenuLabel>
    <DropdownMenuSeparator />
    <DropdownMenuGroup>
        <DropdownMenuItem v-if="canAccessAdminPanel" :as-child="true">
            <a class="block w-full cursor-pointer" href="/admin">
                <ShieldUser class="mr-2 h-4 w-4" />
                Admin Panel
            </a>
        </DropdownMenuItem>
        <DropdownMenuItem :as-child="true">
            <Link :href="edit()" class="block w-full cursor-pointer" prefetch>
                <Settings class="mr-2 h-4 w-4" />
                Settings
            </Link>
        </DropdownMenuItem>
    </DropdownMenuGroup>
    <DropdownMenuSeparator />
    <DropdownMenuItem :as-child="true">
        <Link
            :href="logout()"
            as="button"
            class="block w-full cursor-pointer"
            data-test="logout-button"
            @click="handleLogout"
        >
            <LogOut class="mr-2 h-4 w-4" />
            Log out
        </Link>
    </DropdownMenuItem>
</template>
