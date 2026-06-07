<script setup lang="ts">
import type { Route } from '@/types/airline'
import { DataTable } from '@/components/ui/data-table'
import { columns } from './columns'
import { Head } from '@inertiajs/vue3'
import type { Auth, Pagination } from '@/types'

defineProps<{
    routes: Pagination<Route>
    auth: Auth
}>()
</script>

<template>
    <Head title="Book a Flight" />

    <div class="px-4 pt-4">
        <h4 class="scroll-m-20 text-xl font-semibold tracking-tight">
            Routes from {{ auth.user.current_airport?.name }} ({{
                auth.user.current_airport?.icao
            }})
        </h4>
    </div>

    <div class="flex h-full flex-1 flex-col p-4">
        <DataTable
            :columns="columns"
            :paginated-data="routes"
            :only="['routes']"
        />
    </div>
</template>

<style scoped></style>
