<script setup lang="ts" generic="TData">
import { Button } from '@/components/ui/button'
import { type Table } from '@tanstack/vue-table'
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'
import { ChevronsRight, ChevronsLeft } from '@lucide/vue'

interface DataTablePaginationProps {
    table: Table<TData>
}

defineProps<DataTablePaginationProps>()
</script>

<template>
    <div class="flex items-center justify-between p-4 space-x-2">
        <div>
            Page {{ table.getState().pagination.pageIndex + 1 }} of
            {{ table.getPageCount() }}
        </div>
        <div class="flex items-center space-x-2">
            <Button
                variant="outline"
                size="sm"
                :disabled="!table.getCanPreviousPage()"
                @click="table.setPageIndex(0)"
            >
                <ChevronsLeft />
            </Button>
            <Button
                variant="outline"
                size="sm"
                :disabled="!table.getCanPreviousPage()"
                @click="table.previousPage()"
            >
                Previous
            </Button>
            <Button
                variant="outline"
                size="sm"
                :disabled="!table.getCanNextPage()"
                @click="table.nextPage()"
            >
                Next
            </Button>
            <Button
                variant="outline"
                size="sm"
                :disabled="!table.getCanNextPage()"
                @click="table.setPageIndex(table.getPageCount() - 1)"
            >
                <ChevronsRight />
            </Button>
        </div>
        <div class="flex items-center space-x-2">
            <p class="text-sm font-medium">Rows per page</p>
            <Select
                :model-value="table.getState().pagination.pageSize"
                @update:model-value="
                    (value) => table.setPageSize(Number(value))
                "
            >
                <SelectTrigger class="h-8 w-17.5">
                    <SelectValue
                        :placeholder="`${table.getState().pagination.pageSize}`"
                    />
                </SelectTrigger>
                <SelectContent side="top">
                    <SelectItem
                        v-for="pageSize in [15, 25, 50]"
                        :key="pageSize"
                        :value="`${pageSize}`"
                    >
                        {{ pageSize }}
                    </SelectItem>
                </SelectContent>
            </Select>
        </div>
    </div>
</template>
