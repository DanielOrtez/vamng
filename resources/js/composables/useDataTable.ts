import type {
    ColumnFiltersState,
    PaginationState,
    SortingState,
    Updater,
} from '@tanstack/vue-table'
import { ref } from 'vue'
import type { DataTableOptions } from '@/types/datatable'
import { router, usePage } from '@inertiajs/vue3'
import {
    formatFiltering,
    formatSorting,
    parseQueryFilters,
} from '@/lib/datatableUtils'

export function useDataTable(options: DataTableOptions) {
    const page = usePage()
    const { filters } = parseQueryFilters(page.props.queryParams)
    const pagination = ref<PaginationState>({
        ...options.pagination,
    })

    const sorting = ref<SortingState>([])

    const filtering = ref<ColumnFiltersState>(filters)

    function fetchDataTable() {
        router.cancelAll()

        router.reload({
            data: {
                page: pagination.value.pageIndex + 1,
                perPage: pagination.value.pageSize,
                ...(sorting.value.length > 0
                    ? { sort: formatSorting(sorting.value) }
                    : {}),
                filter: formatFiltering(filtering.value) as never,
            },
            only: options.only,
        })
    }

    function paginate(updaterOrValue: Updater<PaginationState>) {
        pagination.value =
            typeof updaterOrValue === 'function'
                ? updaterOrValue(pagination.value)
                : updaterOrValue

        fetchDataTable()
    }

    function sort(updateOrValue: Updater<SortingState>) {
        sorting.value =
            typeof updateOrValue === 'function'
                ? updateOrValue(sorting.value)
                : updateOrValue

        fetchDataTable()
    }

    function filter(updateOrValue: Updater<ColumnFiltersState>) {
        filtering.value =
            typeof updateOrValue === 'function'
                ? updateOrValue(filtering.value)
                : updateOrValue

        fetchDataTable()
    }

    return {
        pagination,
        sorting,
        filtering,
        paginate,
        sort,
        filter,
    }
}
