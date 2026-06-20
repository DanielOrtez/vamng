<script setup lang="ts">
import { Aircraft, AircraftType, Route } from '@/types/airline'
import { Pagination } from '@/types'
import { aircraftsColumns } from '@/pages/pilot-actions/book-flight/columns'
import OwnTable from '@/components/ui/data-table/OwnTable.vue'
import DataTablePagination from '@/components/ui/data-table/DataTablePagination.vue'
import { getCoreRowModel, useVueTable } from '@tanstack/vue-table'
import { useDataTable } from '@/composables/useDataTable'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { formatDuration, formatTime } from '@/lib/utils'
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'
import {Separator} from "@/components/ui/separator";

const props = defineProps<{
    route: Route
    aircrafts: Pagination<Aircraft>
    aircraftTypes: AircraftType[]
}>()

const { pagination, paginate, sorting, sort, filtering, filter } = useDataTable(
    {
        pagination: {
            pageIndex: props.aircrafts.current_page - 1,
            pageSize: props.aircrafts.per_page,
        },
        only: ['aircrafts'],
    },
)

const table = useVueTable({
    get data() {
        return props.aircrafts.data
    },
    get columns() {
        return aircraftsColumns
    },
    getRowId: (originalRow) => String(originalRow.id),
    getCoreRowModel: getCoreRowModel(),
    manualPagination: true,
    manualSorting: true,
    manualFiltering: true,
    rowCount: props.aircrafts.total,
    pageCount: props.aircrafts.last_page,
    onPaginationChange: paginate,
    onSortingChange: sort,
    onColumnFiltersChange: filter,
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
    <div class="grid grid-cols-4 px-4 pt-4">
        <h4
            class="flex scroll-m-20 text-xl font-semibold tracking-tight col-span-2"
        >
            Aircrafts availables at {{ route.departure_airport?.name }} ({{
                route.departure_airport?.icao
            }})
        </h4>

        <div class="justify-self-end pr-2">
            <Select
                multiple
                :model-value="
                    table.getColumn('aircraft_type')?.getFilterValue() as string
                "
                @update:model-value="
                    table.getColumn('aircraft_type')?.setFilterValue($event)
                "
            >
                <SelectTrigger class="w-50">
                    <SelectValue placeholder="Aircraft type" />
                </SelectTrigger>
                <SelectContent>
                    <SelectItem
                        v-for="aircraftType in aircraftTypes"
                        :key="aircraftType.id"
                        :value="aircraftType.id"
                    >
                        {{ aircraftType.icao }}
                    </SelectItem>
                </SelectContent>
            </Select>
        </div>
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
                <CardContent class="flex flex-col gap-2 text-sm">
                    <p class="py-2">
                        <span class="font-bold">Departure:</span>
                        {{ route.departure_airport?.name }}
                        ({{ route.departure_airport?.icao }})
                    </p>
                    <Separator />
                    <p class="py-2">
                        <span class="font-bold">Arrival:</span>
                        {{ route.arrival_airport?.name }}
                        ({{ route.arrival_airport?.icao }})
                    </p>
                    <Separator />
                    <p class="py-2">
                        <span class="font-bold">Departure Time:</span>
                        {{ formatTime(route.departure_time) }}z
                    </p>
                    <Separator />
                    <p class="py-2">
                        <span class="font-bold">Arrival Time:</span>
                        {{ formatTime(route.arrival_time) }}z
                    </p>
                    <Separator />
                    <p class="py-2">
                        <span class="font-bold">Duration:</span>
                        {{ formatDuration(route.flight_time) }}
                    </p>
                </CardContent>
            </Card>
        </div>
    </div>
</template>
