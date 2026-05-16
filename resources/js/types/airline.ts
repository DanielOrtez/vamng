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
