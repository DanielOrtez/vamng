<script setup lang="ts">
import { Aircraft, Route } from '@/types/airline'
import { Pagination } from '@/types'
import { aircraftsColumns } from '@/pages/pilot-actions/book-flight/columns'
import OwnTable from '@/components/ui/data-table/OwnTable.vue'
import DataTablePagination from '@/components/ui/data-table/DataTablePagination.vue'
import { getCoreRowModel, useVueTable } from '@tanstack/vue-table'
import { useDataTable } from '@/composables/useDataTable'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { formatDuration, formatTime } from '@/lib/utils'

const props = defineProps<{
    route: Route
    aircrafts: Pagination<Aircraft>
}>()

const { pagination, paginate, sorting, sort } = useDataTable({
    pagination: {
        pageIndex: props.aircrafts.current_page - 1,
        pageSize: props.aircrafts.per_page,
    },
    only: ['routes'],
})

const table = useVueTable({
    get data() {
        return props.aircrafts.data
    },
    get columns() {
        return aircraftsColumns
    },
    getCoreRowModel: getCoreRowModel(),
    manualPagination: true,
    manualSorting: true,
    onPaginationChange: paginate,
    onSortingChange: sort,
    state: {
        get pagination() {
            return pagination.value
        },
        get sorting() {
            return sorting.value
        },
    },
})
</script>

<template>
    <div class="px-4 pt-4 flex justify-between">
        <h4 class="flex scroll-m-20 text-xl font-semibold tracking-tight">
            Aircrafts availables at {{ route.departure_airport?.name }} ({{
                route.departure_airport?.icao
            }})
        </h4>
    </div>

    <div class="grid grid-cols-4">
        <div class="flex h-full flex-1 flex-col p-4 col-span-3">
            <div class="border rounded-md">
                <OwnTable
                    :table="table"
                    :columns-length="aircraftsColumns.length"
                />
            </div>
            <DataTablePagination :table="table" />
        </div>

        <div class="pr-4 py-4">
            <Card>
                <CardHeader>
                    <CardTitle>Route Information</CardTitle>
                </CardHeader>
                <CardContent class="flex flex-col gap-2">
                    <p class="border-b-2 border-b-secondary py-2">
                        <span class="font-bold">Departure:</span>
                        {{ route.departure_airport?.name }}
                        ({{ route.departure_airport?.icao }})
                    </p>
                    <p class="border-b-2 border-b-secondary py-2">
                        <span class="font-bold">Arrival:</span>
                        {{ route.arrival_airport?.name }}
                        ({{ route.arrival_airport?.icao }})
                    </p>
                    <p class="border-b-2 border-b-secondary py-2">
                        <span class="font-bold">Departure Time:</span>
                        {{ formatTime(route.departure_time) }}z
                    </p>
                    <p class="border-b-2 border-b-secondary py-2">
                        <span class="font-bold">Arrival Time:</span>
                        {{ formatTime(route.arrival_time) }}z
                    </p>
                    <p class="border-b-2 border-b-secondary py-2">
                        <span class="font-bold">Duration:</span>
                        {{ formatDuration(route.flight_time) }}
                    </p>
                </CardContent>
            </Card>
        </div>
    </div>
</template>
