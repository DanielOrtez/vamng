<script setup lang="ts" generic="TData, TValue">
import {
    ColumnDef,
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

const props = defineProps<{
    columns: ColumnDef<TData, TValue>[]
    paginatedData: Pagination<TData>
    only: string[]
}>()

const { pagination, paginate } = useDataTable({
    pagination: {
        pageIndex: props.paginatedData.current_page - 1,
        pageSize: props.paginatedData.per_page,
    },
    only: props.only,
})

const table = useVueTable({
    get data() {
        return props.paginatedData.data
    },
    get columns() {
        return props.columns
    },
    getCoreRowModel: getCoreRowModel(),
    manualPagination: true,
    rowCount: props.paginatedData.total,
    pageCount: props.paginatedData.last_page,
    onPaginationChange: paginate,
    state: {
        get pagination() {
            return pagination.value
        },
    },
})
</script>

<template>
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
