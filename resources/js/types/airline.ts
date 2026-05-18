export type Airport = {
    id: number
    icao: string
    iata?: string
    name: string
    iso_2_country: string
    elevation_ft?: number
    latitude: number
    longitude: number
    is_hub: boolean
}

export type Country = {
    name: string
    code_2: string
}
