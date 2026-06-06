import type { PaginationState, Updater } from '@tanstack/vue-table'
import { Ref, ref } from 'vue'
import type { DataTableOptions } from '@/types/datatable'
import { router } from '@inertiajs/vue3'

export function useDataTable(options: DataTableOptions) {
    const pagination: Ref<PaginationState> = ref({
        ...options.pagination,
    })

    function fetchDataTable() {
        router.cancelAll()

        router.reload({
            data: {
                page: pagination.value.pageIndex + 1,
                perPage: pagination.value.pageSize,
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

    return {
        pagination,
        paginate,
    }
}
