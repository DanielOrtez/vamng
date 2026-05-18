<script lang="ts" setup>
import { Head, useForm } from '@inertiajs/vue3'
import InputError from '@/components/InputError.vue'
import PasswordInput from '@/components/PasswordInput.vue'
import TextLink from '@/components/TextLink.vue'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Spinner } from '@/components/ui/spinner'
import { login } from '@/routes'
import { store } from '@/routes/register'
import { Airport, Country } from '@/types/airline'
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from '@/components/ui/popover'
import { Check, ChevronDown } from '@lucide/vue'
import { ref } from 'vue'
import {
    Command,
    CommandEmpty,
    CommandGroup,
    CommandInput,
    CommandItem,
    CommandList,
} from '@/components/ui/command'
import { cn } from '@/lib/utils'

defineOptions({
    layout: {
        title: 'Create an account',
        description: 'Enter your details below to create your account',
    },
})

defineProps<{
    hubs: Airport[]
    countries: Country[]
}>()

const openHubCombobox = ref(false)
const openCountryCombobox = ref(false)

const form = useForm<{
    name: string | never
    email: string | never
    password: string | never
    password_confirmation: string | number | null
    country: string | null
    hub: number | null
}>({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    country: null,
    hub: null,
})
    .withPrecognition(store())
    .dontRemember('password', 'password_confirmation')

function submit() {
    form.submit({
        onError: () => form.reset('password', 'password_confirmation'),
    })
}
</script>

<template>
    <Head title="Register" />

    <form class="flex flex-col gap-6" @submit.prevent="submit">
        <div class="grid gap-6">
            <div class="grid gap-2">
                <Label for="name">Name</Label>
                <Input
                    id="name"
                    v-model="form.name"
                    :tabindex="1"
                    autofocus
                    name="name"
                    placeholder="Full name"
                    required
                    type="text"
                />
                <InputError :message="form.errors.name" />
            </div>

            <div class="grid gap-2">
                <Label for="email">Email address</Label>
                <Input
                    id="email"
                    v-model="form.email"
                    :tabindex="2"
                    name="email"
                    placeholder="email@example.com"
                    required
                    type="email"
                />
                <InputError :message="form.errors.email" />
            </div>

            <div class="grid gap-2">
                <Label for="password">Password</Label>
                <PasswordInput
                    id="password"
                    v-model="form.password"
                    :tabindex="3"
                    autocomplete="new-password"
                    name="password"
                    placeholder="Password"
                    required
                />
                <InputError :message="form.errors.password" />
            </div>

            <div class="grid gap-2">
                <Label for="password_confirmation">Confirm password</Label>
                <PasswordInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    :tabindex="4"
                    autocomplete="new-password"
                    name="password_confirmation"
                    placeholder="Confirm password"
                    required
                />
                <InputError :message="form.errors.password_confirmation" />
            </div>

            <div class="grid gap-2">
                <Label as="span">Country</Label>
                <Popover v-model:open="openCountryCombobox">
                    <PopoverTrigger as-child>
                        <Button
                            :aria-expanded="openCountryCombobox"
                            class="w-full justify-between"
                            role="combobox"
                            variant="outline"
                        >
                            {{
                                form.country
                                    ? countries.find(
                                          (country) =>
                                              country.code_2 === form.country,
                                      )?.name
                                    : 'Select your country'
                            }}
                            <ChevronDown />
                        </Button>
                    </PopoverTrigger>
                    <PopoverContent class="w-sm p-0">
                        <Command>
                            <CommandInput
                                id="country"
                                placeholder="Search country"
                            />
                            <CommandList>
                                <CommandEmpty>No country found.</CommandEmpty>
                                <CommandGroup>
                                    <CommandItem
                                        v-for="country in countries"
                                        :key="country.code_2"
                                        :value="country.code_2"
                                        @select="
                                            () => {
                                                form.country =
                                                    form.country ===
                                                    country.code_2
                                                        ? ''
                                                        : country.code_2
                                                openCountryCombobox = false
                                            }
                                        "
                                    >
                                        <Check
                                            :class="
                                                cn(
                                                    'mr-2 h-4 w-4',
                                                    form.country ===
                                                        country.code_2
                                                        ? 'opacity-100'
                                                        : 'opacity-0',
                                                )
                                            "
                                        />
                                        {{ country.name }}
                                    </CommandItem>
                                </CommandGroup>
                            </CommandList>
                        </Command>
                    </PopoverContent>
                </Popover>
                <InputError :message="form.errors.country" />
            </div>

            <div class="grid gap-2">
                <Label as="span">Home airport</Label>
                <Popover v-model:open="openHubCombobox">
                    <PopoverTrigger as-child>
                        <Button
                            :aria-expanded="openHubCombobox"
                            class="w-full justify-between"
                            role="combobox"
                            variant="outline"
                        >
                            {{
                                form.hub
                                    ? hubs.find((hub) => hub.id === form.hub)
                                          ?.icao +
                                      ' (' +
                                      hubs.find((hub) => hub.id === form.hub)
                                          ?.name +
                                      ')'
                                    : 'Select your preferred hub airport'
                            }}
                            <ChevronDown />
                        </Button>
                    </PopoverTrigger>
                    <PopoverContent class="w-sm p-0">
                        <Command>
                            <CommandInput
                                id="hub"
                                placeholder="Search hub (ICAO)"
                            />
                            <CommandList>
                                <CommandEmpty>No hub found.</CommandEmpty>
                                <CommandGroup>
                                    <CommandItem
                                        v-for="hub in hubs"
                                        :key="hub.id"
                                        :value="hub.id"
                                        @select="
                                            () => {
                                                form.hub =
                                                    form.hub === hub.id
                                                        ? 0
                                                        : hub.id
                                                openHubCombobox = false
                                            }
                                        "
                                    >
                                        <Check
                                            :class="
                                                cn(
                                                    'mr-2 h-4 w-4',
                                                    form.hub === hub.id
                                                        ? 'opacity-100'
                                                        : 'opacity-0',
                                                )
                                            "
                                        />
                                        {{ hub.icao }} ({{ hub.name }})
                                    </CommandItem>
                                </CommandGroup>
                            </CommandList>
                        </Command>
                    </PopoverContent>
                </Popover>
                <InputError :message="form.errors.hub" />
            </div>

            <Button
                :disabled="form.processing"
                class="mt-2 w-full"
                data-test="register-user-button"
                tabindex="5"
                type="submit"
            >
                <Spinner v-if="form.processing" />
                Create account
            </Button>
        </div>

        <div class="text-center text-sm text-muted-foreground">
            Already have an account?
            <TextLink
                :href="login()"
                :tabindex="6"
                class="underline underline-offset-4"
                >Log in</TextLink
            >
        </div>
    </form>
</template>
