import uuid

from ninja import Router

from apps.api.schemas.operations import BidSchema
from apps.operations.models import Bid

user_router = Router(tags=["User"])


@user_router.get("/bookings", response=list[BidSchema])
def get_user_bookings(request, user_id: uuid.UUID) -> list[BidSchema]:
    bids = (
        Bid.objects.with_related()
        .filter(booked_by__id=user_id)
        .defer("booked_by")
        .all()
    )
    return bids
