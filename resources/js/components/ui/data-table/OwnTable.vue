<script setup lang="ts" generic="TData">
import { flightsColumns } from '@/pages/pilot-actions/book-flight/columns'
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table'
import { FlexRender } from '@tanstack/vue-table'
import { type Table as TableType } from '@tanstack/vue-table'

defineProps<{
    table: TableType<TData>
    columnsLength: number
}>()
</script>

<template>
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
                    :data-state="row.getIsSelected() ? 'selected' : undefined"
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
                        :colspan="flightsColumns.length"
                        class="h-24 text-center"
                    >
                        No Results
                    </TableCell>
                </TableRow>
            </template>
        </TableBody>
    </Table>
</template>
