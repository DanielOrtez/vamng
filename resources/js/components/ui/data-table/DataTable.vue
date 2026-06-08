<script setup lang="ts" generic="TData, TValue">
import {
    type ColumnDef,
    useVueTable,
    getCoreRowModel,
    FlexRender,
} from '@tanstack/vue-table'
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table'
import type { Pagination } from '@/types/datatable'
import { useDataTable } from '@/composables/useDataTable'
import DataTablePagination from '@/components/ui/data-table/DataTablePagination.vue'
import { Input } from '@/components/ui/input'
import { useDebounceFn } from '@vueuse/core'

const props = defineProps<{
    columns: ColumnDef<TData, TValue>[]
    paginatedData: Pagination<TData>
    only: string[]
    filterBy?: string
}>()

const { pagination, paginate, sorting, sort, filtering, filter } = useDataTable(
    {
        pagination: {
            pageIndex: props.paginatedData.current_page - 1,
            pageSize: props.paginatedData.per_page,
        },
        only: props.only,
    },
)

const table = useVueTable({
    get data() {
        return props.paginatedData.data
    },
    get columns() {
        return props.columns
    },
    getCoreRowModel: getCoreRowModel(),
    manualPagination: true,
    manualSorting: true,
    manualFiltering: true,
    rowCount: props.paginatedData.total,
    pageCount: props.paginatedData.last_page,
    onPaginationChange: paginate,
    onSortingChange: sort,
    onColumnFiltersChange: useDebounceFn(filter, 500),
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
    <div v-if="filterBy" class="flex items-center py-4">
        <Input
            class="max-w-sm"
            :placeholder="table.getColumn(filterBy)?.columnDef.header"
            :model-value="table.getColumn(filterBy)?.getFilterValue() as string"
            @update:model-value="
                table.getColumn(filterBy)?.setFilterValue($event)
            "
        />
    </div>
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
</template>
