from datetime import timedelta

from ninja import Schema
from ninja.errors import HttpError
from pydantic import model_validator

from apps.api.schemas.operations import FleetTypeSchema, RouteSchema
from apps.pireps.models import Flight

STATUS_TRANSITIONS = {
    Flight.FlightStatus.SCHEDULED: [
        Flight.FlightStatus.IN_PROGRESS,
        Flight.FlightStatus.CANCELED,
    ],
    Flight.FlightStatus.IN_PROGRESS: [
        Flight.FlightStatus.COMPLETED,
        Flight.FlightStatus.CANCELED,
    ],
}


class ValidateFlightStatusSchema(Schema):
    status: Flight.FlightStatus
    current_status: Flight.FlightStatus

    @model_validator(mode="after")
    def validate_status_transition(self):
        if self.status not in STATUS_TRANSITIONS.get(self.current_status, []):
            raise HttpError(
                400, f"Invalid transition from {self.current_status} to {self.status}"
            )

        return self


class UpdateFlightSchema(Schema):
    status: Flight.FlightStatus | None = None
    flight_time: timedelta | None = None
    distance: int | None = None


class CreatedFlightSchema(Schema):
    id: int


class FlightSchema(Schema):
    id: int
    fleet: FleetTypeSchema
    route: RouteSchema
    status: Flight.FlightStatus
    flight_time: timedelta
    distance: int


class CompletedFlightSchema(Schema):
    completed: bool
