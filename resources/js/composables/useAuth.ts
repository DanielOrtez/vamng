import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

export default function useAuth() {
    const page = usePage()

    const user = computed(() => page.props.auth.user)

    const userPermissions = computed(() => page.props.auth.userPermissions)

    const isSuperAdmin = computed(() => page.props.auth.isSuperAdmin)

    const hasPermission = (permission: string): boolean => {
        if (!userPermissions.value) {
            return false
        }

        return isSuperAdmin.value || userPermissions.value.includes(permission)
    }

    return { user, hasPermission }
}
