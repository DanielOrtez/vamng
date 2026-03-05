from ninja import Router

from apps.api.schemas.pireps import CreatedFlightSchema
from apps.api.services.operations import start_flight

operations_router = Router(tags=["Operations"])


@operations_router.post("/bid/{bid_id}/start", response=CreatedFlightSchema)
def start_flying_bid(request, bid_id: int):
    return start_flight(bid_id)
