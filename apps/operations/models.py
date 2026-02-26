from django.db import models
from django.utils import timezone

from apps.core.models import Airport, TimeStampedModel
from apps.users.models import MyUser


# Create your models here.
class FleetType(TimeStampedModel):
    name = models.CharField(max_length=100)
    icao_code = models.CharField(max_length=6, unique=True)
    pax_capacity = models.IntegerField()
    cargo_capacity = models.IntegerField()
    ci = models.IntegerField()

    def __str__(self):
        return f"{self.name} ({self.icao_code})"

    class Meta:
        ordering = ["icao_code"]


class Route(TimeStampedModel):
    code = models.CharField(max_length=10, unique=True)
    departure_airport = models.ForeignKey(
        Airport, on_delete=models.CASCADE, related_name="departures"
    )
    arrival_airport = models.ForeignKey(
        Airport, on_delete=models.CASCADE, related_name="arrivals"
    )
    flight_time = models.DurationField()
    fleet_allowed = models.ManyToManyField(FleetType)
    is_active = models.BooleanField(default=True)

    def __str__(self):
        return f"{self.code} -> {self.departure_airport} ({self.arrival_airport})"

    class Meta:
        ordering = ["code"]


class Bid(TimeStampedModel):
    booked_by = models.OneToOneField(
        MyUser, on_delete=models.CASCADE, related_name="active_bid"
    )
    route = models.ForeignKey(Route, on_delete=models.CASCADE)
    fleet_type = models.ForeignKey(FleetType, on_delete=models.CASCADE)
    expires_at = models.DateTimeField()

    def is_expired(self):
        return timezone.now() > self.expires_at
