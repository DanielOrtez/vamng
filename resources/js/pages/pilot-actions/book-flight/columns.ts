import { ColumnDef } from '@tanstack/vue-table'

import { AircraftType, Airport, Route } from '@/types/airline'
import { formatDuration, formatTime } from '@/lib/utils'
import { h } from 'vue'
import { Badge } from '@/components/ui/badge'
import { Button } from '@/components/ui/button'

export const columns: ColumnDef<Route>[] = [
    {
        accessorKey: 'route_code',
        header: 'Route Code',
        cell: ({ row }) => row.getValue('route_code'),
    },
    {
        accessorKey: 'departure_airport',
        header: 'Departure Airport',
        cell: ({ row }) => {
            const airport: Airport = row.getValue('departure_airport')

            return `${airport.icao} - ${airport.name}`
        },
    },
    {
        accessorKey: 'arrival_airport',
        header: 'Arrival Airport',
        cell: ({ row }) => {
            const airport: Airport = row.getValue('arrival_airport')

            return `${airport.icao} - ${airport.name}`
        },
    },
    {
        accessorKey: 'departure_time',
        header: 'Departure Time',
        cell: ({ row }) => formatTime(row.getValue('departure_time')),
    },
    {
        accessorKey: 'arrival_time',
        header: 'Arrival Time',
        cell: ({ row }) => formatTime(row.getValue('arrival_time')),
    },
    {
        accessorKey: 'flight_time',
        header: 'Flight Time',
        cell: ({ row }) => formatDuration(row.getValue('flight_time')),
    },
    {
        accessorKey: 'aircraft_types',
        header: 'Airport Types',
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
        cell: () =>
            h(
                Button,
                { variant: 'secondary', size: 'sm', class: 'cursor-pointer' },
                () => 'Book',
            ),
    },
]
