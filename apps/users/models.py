import uuid

from django.contrib.auth.models import AbstractUser
from django.db import models

from apps.core.models import TimeStampedModel


# Create your models here.
class MyUser(AbstractUser):
    id = models.UUIDField(
        primary_key=True, default=uuid.uuid4, unique=True, editable=False
    )
    email = models.CharField(verbose_name="email address", max_length=255, unique=True)

    country = models.CharField(max_length=2, blank=True)
    total_hours = models.IntegerField(default=0)
    curr_airport = models.ForeignKey(
        "core.Airport", on_delete=models.SET_NULL, null=True
    )
    rank = models.ForeignKey("Rank", on_delete=models.SET_NULL, null=True)

    USERNAME_FIELD = "email"
    REQUIRED_FIELDS = ["username"]

    def __str__(self):
        return f"{self.username} ({self.email})"


class Rank(TimeStampedModel):
    name = models.CharField(max_length=50)
    min_hours = models.IntegerField()

    def __str__(self):
        return self.name
