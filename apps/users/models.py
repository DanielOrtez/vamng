import uuid

from django.contrib.auth.base_user import BaseUserManager
from django.contrib.auth.models import AbstractUser
from django.db import models, transaction
from django_countries.fields import CountryField

from apps.core.models import Airline, TimeStampedModel


class MyUserManager(BaseUserManager):
    def get_queryset(self):
        return super().get_queryset().filter(is_active=True)

    def get_profile(self, user_id: uuid.UUID):
        return (
            super()
            .get_queryset()
            .select_related(
                "curr_airport",
                "active_bid",
                "active_bid__route",
                "active_bid__route__departure_airport",
                "active_bid__route__arrival_airport",
            )
            .get(pk=user_id)
        )


# Create your models here.
class MyUser(AbstractUser):
    id = models.UUIDField(
        primary_key=True, default=uuid.uuid4, unique=True, editable=False
    )
    email = models.CharField(verbose_name="email address", unique=True)
    first_name = None
    last_name = None

    full_name = models.CharField(verbose_name="full name", blank=True)
    country = CountryField()
    total_hours = models.IntegerField(default=0)
    curr_airport = models.ForeignKey(
        "core.Airport", on_delete=models.SET_NULL, null=True, db_index=True
    )
    rank = models.ForeignKey("Rank", on_delete=models.SET_NULL, null=True)

    USERNAME_FIELD = "email"
    REQUIRED_FIELDS = ["username"]

    active = MyUserManager()

    @staticmethod
    def generate_callsign():
        airline = Airline.objects.get()
        airline_icao = airline.icao if airline else "VAM"

        with transaction.atomic():
            last_user = MyUser.objects.order_by("-username").first()
            last_number = last_user.username[3:] if last_user else 0

            next_number = int(last_number) + 1

        return f"{airline_icao}{next_number:03d}"

    def save(self, *args, **kwargs):
        if not self.username:
            self.username = self.generate_callsign()
        super().save(*args, **kwargs)

    def __str__(self):
        return f"{self.full_name} ({self.username})"

    class Meta:
        ordering = ["-date_joined"]


class Rank(TimeStampedModel):
    name = models.CharField(max_length=50)
    min_hours = models.IntegerField()

    def __str__(self):
        return self.name
