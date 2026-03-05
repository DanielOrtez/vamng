from django.contrib.auth import get_user_model
from django.db import models

from apps.core.models import TimeStampedModel

User = get_user_model()


# Create your models here.
class Pirep(TimeStampedModel):
    user = models.ForeignKey(User, on_delete=models.CASCADE)
    fleet = models.ForeignKey(
        "operations.FleetType", on_delete=models.SET_NULL, null=True
    )
    route = models.ForeignKey("operations.Route", on_delete=models.SET_NULL, null=True)
    flight_time = models.DurationField()
    distance = models.FloatField()


class FlightManager(models.Manager):
    def active_flights(self):
        return self.filter(~models.Q(status=Flight.FlightStatus.CANCELED))


class Flight(TimeStampedModel):
    class FlightStatus(models.TextChoices):
        SCHEDULED = "scheduled", "Scheduled"
        IN_PROGRESS = "in_progress", "In Progress"
        COMPLETED = "completed", "Completed"
        CANCELED = "canceled", "Canceled"

    user = models.OneToOneField(User, on_delete=models.CASCADE)
    fleet = models.OneToOneField("operations.FleetType", on_delete=models.CASCADE)
    route = models.OneToOneField("operations.Route", on_delete=models.CASCADE)

    objects = FlightManager()

    status = models.CharField(
        max_length=20, choices=FlightStatus, default=FlightStatus.SCHEDULED
    )
    flight_time = models.DurationField()
    distance = models.FloatField()
