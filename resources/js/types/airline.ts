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

export type AircraftType = {
    id: number
    icao: string
}

export type Aircraft = {
    id: number
    name: string
    registration: string
    hours_flown: number
    aircraft_type: AircraftType
}

export type Route = {
    id: number
    code: string
    departure_airport?: Airport
    arrival_airport: Airport
    departure_time: string
    arrival_time: string
    flight_time: number
}
