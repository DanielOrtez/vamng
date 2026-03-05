from datetime import datetime, timedelta

from ninja import Schema

from .core import AirportSchema


class FleetTypeSchema(Schema):
    name: str
    icao_code: str
    pax_capacity: int
    cargo_capacity: int
    ci: int


class RouteSchema(Schema):
    code: str
    departure_airport: AirportSchema
    arrival_airport: AirportSchema


class BidSchema(Schema):
    id: int
    route: RouteSchema
    fleet_type: FleetTypeSchema
    expires_at: datetime
