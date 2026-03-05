import uuid

from django.contrib.auth import get_user_model
from django.db import transaction
from django.http import HttpResponse
from django.shortcuts import get_object_or_404
from ninja.errors import HttpError

from apps.api.schemas.pireps import (
    CompletedFlightSchema,
    UpdateFlightSchema,
    ValidateFlightStatusSchema,
)
from apps.operations.models import Bid
from apps.pireps.models import Flight, Pirep
from apps.pireps.signals import flight_signal

User = get_user_model()


def _complete_flight(flight) -> bool:
    with transaction.atomic():
        Pirep.objects.create(
            user=flight.user,
            fleet=flight.fleet,
            route=flight.route,
            flight_time=flight.flight_time,
            distance=flight.distance,
        )
        Bid.objects.filter(booked_by=flight.user).delete()
        user = User.objects.get(id=flight.user.id)
        user.curr_airport_id = flight.route.arrival_airport_id
        user.save(update_fields=["curr_airport_id"])

        flight_signal.send(sender=Flight, instance=flight)

    return True


def update_flight(flight_id: int, user_id: uuid.UUID, data: UpdateFlightSchema):
    flight = get_object_or_404(
        Flight.objects.select_related(
            "fleet",
            "route",
            "route__departure_airport",
            "route__arrival_airport",
            "user",
        ),
        id=flight_id,
    )

    if flight.user_id != user_id or flight.status == Flight.FlightStatus.CANCELED:
        raise HttpError(401, "You do not have permission to update this flight.")

    if data.status:
        ValidateFlightStatusSchema(status=data.status, current_status=flight.status)

    for field, value in data.dict(exclude_unset=True, exclude={"id"}).items():
        setattr(flight, field, value)

    flight.save()

    if flight.status == Flight.FlightStatus.COMPLETED:
        completed = _complete_flight(flight)
        return HttpResponse(CompletedFlightSchema(completed=completed).dict())

    return flight
