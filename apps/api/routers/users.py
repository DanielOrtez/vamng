import uuid

from ninja import Router

from apps.api.schemas.operations import BidResponse
from apps.operations.models import Bid

user_router = Router(tags=["User"])


@user_router.get("/bookings")
def get_user_bookings(request, user_id: uuid.UUID):
    bids = Bid.objects.filter(booked_by__id=user_id).all()
    return [
        BidResponse(
            id=bid.id,
            code=bid.route.code,
            departure_airport=bid.route.departure_airport.name,
            arrival_airport=bid.route.arrival_airport.name,
            fleet=bid.fleet_type.icao_code,
            flight_time=bid.route.flight_time,
        )
        for bid in bids
    ]
