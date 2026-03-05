import uuid

from django.db.models import Q
from django.http import HttpResponse
from django.shortcuts import get_object_or_404
from ninja import Router

from apps.api.schemas.pireps import (
    CompletedFlightSchema,
    FlightSchema,
    UpdateFlightSchema,
)
from apps.api.services.pireps import update_flight
from apps.pireps.models import Flight

pireps_router = Router(tags=["Pireps"])


@pireps_router.get("/flights", response=list[FlightSchema])
def get_flights(request):
    return Flight.objects.active_flights()


@pireps_router.get(
    "/flight/{flight_id}", response={200: FlightSchema, 410: CompletedFlightSchema}
)
def get_current_flight(request, flight_id: int):
    return get_object_or_404(Flight, id=flight_id)


@pireps_router.patch("/flight/{flight_id}", response=FlightSchema)
def update_current_flight(
    request, flight_id: int, user_id: uuid.UUID, data: UpdateFlightSchema
):
    return update_flight(flight_id, user_id, data)


@pireps_router.post("/flight/{flight_id}/cancel")
def cancel_current_flight(request, flight_id: int):
    flight = Flight.objects.filter(id=flight_id).values("status").first()
    flight.status = Flight.FlightStatus.CANCELED
    return HttpResponse(status=410, content="Flight has been canceled.")


@pireps_router.post("/file")
def file_pirep(request):
    pass
