from datetime import timedelta

from django.db.models import Q
from django.shortcuts import get_object_or_404
from ninja.errors import HttpError

from apps.api.schemas.pireps import CreatedFlightSchema
from apps.operations.models import Bid
from apps.pireps.models import Flight


def start_flight(bid_id: int) -> CreatedFlightSchema:
    bid = get_object_or_404(Bid.objects.with_related(), pk=bid_id)
    flight = Flight.objects.filter(
        Q(user=bid.booked_by) & ~Q(status=Flight.FlightStatus.CANCELED)
    ).first()

    if flight:
        raise HttpError(409, f"Bid already has an active flight with id: {flight.id}")

    flight = Flight.objects.create(
        user=bid.booked_by,
        fleet=bid.fleet_type,
        route=bid.route,
        flight_time=timedelta(seconds=0),
        distance=0,
    )

    return CreatedFlightSchema.model_validate(flight)
