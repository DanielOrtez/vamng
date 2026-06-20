<script setup lang="ts">
import type { Route } from '@/types/airline'
import { flightsColumns } from './columns'
import { Head } from '@inertiajs/vue3'
import type { Auth, Pagination } from '@/types'
import { getCoreRowModel, useVueTable } from '@tanstack/vue-table'
import { useDataTable } from '@/composables/useDataTable'
import { useDebounceFn } from '@vueuse/core'
import { Search } from '@lucide/vue'
import {
    InputGroup,
    InputGroupAddon,
    InputGroupInput,
} from '@/components/ui/input-group'
import DataTablePagination from '@/components/ui/data-table/DataTablePagination.vue'
import OwnTable from '@/components/ui/data-table/OwnTable.vue'

const props = defineProps<{
    routes: Pagination<Route>
    auth: Auth
}>()

const { pagination, paginate, sorting, sort, filtering, filter } = useDataTable(
    {
        pagination: {
            pageIndex: props.routes.current_page - 1,
            pageSize: props.routes.per_page,
        },
        only: ['routes'],
    },
)

const table = useVueTable({
    get data() {
        return props.routes.data
    },
    get columns() {
        return flightsColumns
    },
    getRowId: (originalRow) => String(originalRow.id),
    getCoreRowModel: getCoreRowModel(),
    manualPagination: true,
    manualSorting: true,
    manualFiltering: true,
    rowCount: props.routes.total,
    pageCount: props.routes.last_page,
    onPaginationChange: paginate,
    onSortingChange: sort,
    onColumnFiltersChange: useDebounceFn(filter, 300),
    state: {
        get pagination() {
            return pagination.value
        },
        get sorting() {
            return sorting.value
        },
        get columnFilters() {
            return filtering.value
        },
    },
})
</script>

<template>
    <Head title="Book a Flight" />

    <div class="px-4 pt-4 flex justify-between">
        <h4 class="flex scroll-m-20 text-xl font-semibold tracking-tight">
            Routes from {{ auth.user.current_airport?.name }} ({{
                auth.user.current_airport?.icao
            }})
        </h4>
        <InputGroup class="w-50">
            <InputGroupInput
                class="max-w-sm"
                placeholder="Arrival airport"
                :model-value="
                    table
                        .getColumn('arrival_airport')
                        ?.getFilterValue() as string
                "
                @update:model-value="
                    table.getColumn('arrival_airport')?.setFilterValue($event)
                "
            />
            <InputGroupAddon>
                <Search />
            </InputGroupAddon>
        </InputGroup>
    </div>

    <div class="flex h-full flex-1 flex-col p-4">
        <div class="border rounded-md">
            <OwnTable :table="table" :columns-length="flightsColumns.length" />
        </div>
        <DataTablePagination :table="table" />
    </div>
</template>
