<script setup lang="ts">
import type { Route } from '@/types/airline'
import { columns } from './columns'
import { Head } from '@inertiajs/vue3'
import type { Auth, Pagination } from '@/types'
import { FlexRender, getCoreRowModel, useVueTable } from '@tanstack/vue-table'
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table'
import { useDataTable } from '@/composables/useDataTable'
import { useDebounceFn } from '@vueuse/core'
import { Search } from '@lucide/vue'
import {
    InputGroup,
    InputGroupAddon,
    InputGroupInput,
} from '@/components/ui/input-group'
import DataTablePagination from "@/components/ui/data-table/DataTablePagination.vue";

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
        return columns
    },
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
        <div class="">
            <InputGroup>
                <InputGroupInput
                    class="max-w-sm"
                    :placeholder="
                        table.getColumn('arrival_airport')?.columnDef.header
                    "
                    :model-value="
                        table
                            .getColumn('arrival_airport')
                            ?.getFilterValue() as string
                    "
                    @update:model-value="
                        table
                            .getColumn('arrival_airport')
                            ?.setFilterValue($event)
                    "
                />
                <InputGroupAddon>
                    <Search />
                </InputGroupAddon>
            </InputGroup>
        </div>
    </div>

    <div class="flex h-full flex-1 flex-col p-4">
        <div class="border rounded-md">
            <Table>
                <TableHeader>
                    <TableRow
                        v-for="headerGroup in table.getHeaderGroups()"
                        :key="headerGroup.id"
                    >
                        <TableHead
                            v-for="header in headerGroup.headers"
                            :key="header.id"
                        >
                            <FlexRender
                                v-if="!header.isPlaceholder"
                                :render="header.column.columnDef.header"
                                :props="header.getContext()"
                            />
                        </TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <template v-if="table.getRowModel().rows?.length">
                        <TableRow
                            v-for="row in table.getRowModel().rows"
                            :key="row.id"
                            :data-state="
                                row.getIsSelected() ? 'selected' : undefined
                            "
                        >
                            <TableCell
                                v-for="cell in row.getVisibleCells()"
                                :key="cell.id"
                            >
                                <FlexRender
                                    :render="cell.column.columnDef.cell"
                                    :props="cell.getContext()"
                                />
                            </TableCell>
                        </TableRow>
                    </template>
                    <template v-else>
                        <TableRow>
                            <TableCell
                                :colspan="columns.length"
                                class="h-24 text-center"
                            >
                                No Results
                            </TableCell>
                        </TableRow>
                    </template>
                </TableBody>
            </Table>
        </div>
        <DataTablePagination :table="table" />
    </div>
</template>
