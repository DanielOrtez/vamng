import { PaginationState } from '@tanstack/vue-table'

export type PaginationLink = {
    active: boolean
    label: string
    page: string | null
    url: string | null
}

export type Pagination<T> = {
    current_page: number
    data: T[]
    first_page_url: string
    from: number
    last_page: number
    links: object[]
    next_page_url: string
    path: string
    per_page: number
    prev_page_url: string
    to: number
    total: number
}

export type DataTableOptions = {
    pagination: PaginationState
    only: string[]
}
