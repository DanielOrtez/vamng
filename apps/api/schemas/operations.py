from datetime import timedelta

from pydantic import BaseModel


class BidResponse(BaseModel):
    id: int
    code: str
    departure_airport: str
    arrival_airport: str
    fleet: str
    flight_time: timedelta
