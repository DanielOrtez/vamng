import re
import uuid

from django.contrib.auth.models import AbstractUser
from django.db import models, transaction
from django_countries.fields import CountryField

from apps.core.models import Airline, TimeStampedModel


# Create your models here.
class MyUser(AbstractUser):
    id = models.UUIDField(
        primary_key=True, default=uuid.uuid4, unique=True, editable=False
    )
    email = models.CharField(verbose_name="email address", max_length=255, unique=True)

    country = CountryField()
    total_hours = models.IntegerField(default=0)
    curr_airport = models.ForeignKey(
        "core.Airport", on_delete=models.SET_NULL, null=True
    )
    rank = models.ForeignKey("Rank", on_delete=models.SET_NULL, null=True)

    USERNAME_FIELD = "email"
    REQUIRED_FIELDS = ["username"]

    @staticmethod
    def generate_callsign():
        """Asigns a random callsign to the username field on user creation."""
        airline = Airline.objects.get()
        airline_icao = airline.icao if airline else "VAM"

        with transaction.atomic():
            last_user = MyUser.objects.order_by("-username").first()
            next_number = 1

            if last_user:
                last_number = re.search(r"^[A-Za-z]+(\d+)$", last_user.username)
                ln_int = int(last_number.group(1)) if last_number else 0

                next_number = ln_int + 1

        return f"{airline_icao}{next_number:03d}"

    def __str__(self):
        return f"{self.username} ({self.email})"


class Rank(TimeStampedModel):
    name = models.CharField(max_length=50)
    min_hours = models.IntegerField()

    def __str__(self):
        return self.name
