<script setup lang="ts">
import type { Route } from '@/types/airline'
import { DataTable } from '@/components/ui/data-table'
import { columns } from './columns'
import { Head } from '@inertiajs/vue3'

defineProps<{
    routes: Route[]
}>()
</script>

<template>
    <Head title="Book a Flight" />

    <div class="flex h-full flex-1 flex-col p-4">
        <DataTable :columns="columns" :data="routes" />
    </div>
</template>

<style scoped></style>
