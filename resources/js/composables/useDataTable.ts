import type {
    PaginationState,
    SortingState,
    Updater,
} from '@tanstack/vue-table'
import { ref } from 'vue'
import type { DataTableOptions } from '@/types/datatable'
import { router, usePage } from '@inertiajs/vue3'

function formatSorting(sorting: SortingState) {
    if (sorting[0].desc) {
        return `-${sorting[0].id}`
    }

    return `${sorting[0].id}`
}

export function useDataTable(options: DataTableOptions) {
    const _ = usePage()

    const pagination = ref<PaginationState>({
        ...options.pagination,
    })

    const sorting = ref<SortingState>([
        {
            id: '',
            desc: false,
        },
    ])

    function fetchDataTable() {
        router.cancelAll()

        router.reload({
            data: {
                page: pagination.value.pageIndex + 1,
                perPage: pagination.value.pageSize,
                sort: formatSorting(sorting.value),
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

    return {
        pagination,
        sorting,
        paginate,
        sort,
    }
}
