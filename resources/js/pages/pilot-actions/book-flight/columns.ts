import { ColumnDef } from '@tanstack/vue-table'

import type { Aircraft, AircraftType, Airport, Route } from '@/types/airline'
import { formatDuration, formatTime } from '@/lib/utils'
import { h } from 'vue'
import { Badge } from '@/components/ui/badge'
import { Button } from '@/components/ui/button'
import { ArrowUpDown } from '@lucide/vue'
import { selectAircraft } from '@/routes/flights/book'
import { Link } from '@inertiajs/vue3'

export const flightsColumns: ColumnDef<Route>[] = [
    {
        accessorKey: 'route_code',
        header: 'Route code',
        cell: ({ row }) => row.getValue('route_code'),
    },
    {
        accessorKey: 'arrival_airport',
        header: 'Arrival airport',
        cell: ({ row }) => {
            const airport: Airport = row.getValue('arrival_airport')

            return `${airport.icao} - ${airport.name}`
        },
    },
    {
        accessorKey: 'departure_time',
        header: ({ column }) => {
            return h(
                Button,
                {
                    variant: 'ghost',
                    size: 'sm',
                    class: 'cursor-pointer',
                    onClick: () =>
                        column.toggleSorting(column.getIsSorted() === 'asc'),
                },
                () => [
                    'Departure time',
                    h(ArrowUpDown, {
                        class: 'ml-2 h-4 w-4',
                    }),
                ],
            )
        },
        cell: ({ row }) => `${formatTime(row.getValue('departure_time'))}z`,
    },
    {
        accessorKey: 'arrival_time',
        header: ({ column }) => {
            return h(
                Button,
                {
                    variant: 'ghost',
                    size: 'sm',
                    class: 'cursor-pointer',
                    onClick: () =>
                        column.toggleSorting(column.getIsSorted() === 'asc'),
                },
                () => [
                    'Arrival time',
                    h(ArrowUpDown, {
                        class: 'ml-2 h-4 w-4',
                    }),
                ],
            )
        },
        cell: ({ row }) => `${formatTime(row.getValue('arrival_time'))}z`,
    },
    {
        accessorKey: 'distance',
        header: ({ column }) => {
            return h(
                Button,
                {
                    variant: 'ghost',
                    size: 'sm',
                    class: 'cursor-pointer',
                    onClick: () =>
                        column.toggleSorting(column.getIsSorted() === 'asc'),
                },
                () => ['Distance', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })],
            )
        },
        cell: ({ row }) => `${row.getValue('distance')}nm`,
    },
    {
        accessorKey: 'flight_time',
        header: ({ column }) => {
            return h(
                Button,
                {
                    variant: 'ghost',
                    size: 'sm',
                    class: 'cursor-pointer',
                    onClick: () =>
                        column.toggleSorting(column.getIsSorted() === 'asc'),
                },
                () => [
                    'Flight time',
                    h(ArrowUpDown, {
                        class: 'ml-2 h-4 w-4',
                    }),
                ],
            )
        },
        cell: ({ row }) => formatDuration(row.getValue('flight_time')),
    },
    {
        accessorKey: 'aircraft_types',
        header: 'Aircraft types',
        cell: ({ row }) => {
            const aircraftTypes: AircraftType[] = row.getValue('aircraft_types')

            if (!aircraftTypes || !aircraftTypes.length) {
                return h('span', { class: 'text-gray-400 italic' }, '-')
            }

            const badges = aircraftTypes.map((type) =>
                h(
                    Badge,
                    {
                        variant: 'secondary',
                    },
                    () => type.icao,
                ),
            )

            return h('div', { class: 'flex gap-1' }, badges)
        },
    },
    {
        accessorKey: 'book_flight',
        header: () => null,
        cell: ({ row }) =>
            h(
                Button,
                {
                    variant: 'secondary',
                    size: 'sm',
                    class: 'cursor-pointer',
                    asChild: true,
                },
                () =>
                    h(
                        Link,
                        {
                            href: selectAircraft(row.id),
                        },
                        () => 'Book',
                    ),
            ),
    },
]

export const aircraftsColumns: ColumnDef<Aircraft>[] = [
    {
        accessorKey: 'aircraft_type',
        header: 'Aircraft Type',
        cell: ({ row }) => {
            const aircraftType: AircraftType = row.getValue('aircraft_type')
            return aircraftType.icao
        },
    },
    {
        accessorKey: 'registration',
        header: 'Registration',
        cell: ({ row }) => row.getValue('registration'),
    },
    {
        accessorKey: 'name',
        header: 'Name',
        cell: ({ row }) => row.getValue('name'),
    },
    {
        accessorKey: 'hours_flown',
        header: ({ column }) => {
            return h(
                Button,
                {
                    variant: 'ghost',
                    size: 'sm',
                    class: 'cursor-pointer',
                    onClick: () =>
                        column.toggleSorting(column.getIsSorted() === 'asc'),
                },
                () => [
                    'Hours flown',
                    h(ArrowUpDown, {
                        class: 'ml-2 h-4 w-4',
                    }),
                ],
            )
        },
        cell: ({ row }) => `${row.getValue('hours_flown')}h`,
    },
    {
        accessorKey: 'select_aircraft',
        header: () => null,
        cell: () =>
            h(
                Button,
                { variant: 'secondary', size: 'sm', class: 'cursor-pointer' },
                () => 'Select',
            ),
    },
]
