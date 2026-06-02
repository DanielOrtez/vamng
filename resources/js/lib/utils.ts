import type { InertiaLinkProps } from '@inertiajs/vue3'
import { clsx } from 'clsx'
import type { ClassValue } from 'clsx'
import { twMerge } from 'tailwind-merge'

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs))
}

export function toUrl(href: NonNullable<InertiaLinkProps['href']>) {
    return typeof href === 'string' ? href : href?.url
}

export function formatTime(time: string): string {
    return time.slice(0, 5)
}

export function formatDuration(time: number): string {
    const hours = Math.floor(time / 60)
    const minutes = time % 60

    return `${hours}:${minutes.toString().padStart(2, '0')}H`
}
