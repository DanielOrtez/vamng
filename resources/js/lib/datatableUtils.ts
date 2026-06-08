import type { ColumnFiltersState, SortingState } from '@tanstack/vue-table'
import { QueryParams } from '@/types'

export function parseQueryFilters(query: QueryParams) {
    const filters: ColumnFiltersState = []

    if (query.filter) {
        for (const filter in query.filter) {
            filters.push({
                id: filter,
                value: query.filter[filter],
            })
        }
    }

    return {
        filters,
    }
}

export function formatSorting(sorting: SortingState) {
    if (sorting[0].desc) {
        return `-${sorting[0].id}`
    }

    return `${sorting[0].id}`
}

export function formatFiltering(filters: ColumnFiltersState) {
    const formattedFilters: Record<string, unknown> = {}

    for (const filter of filters) {
        formattedFilters[filter.id] = filter.value
    }

    return formattedFilters
}
