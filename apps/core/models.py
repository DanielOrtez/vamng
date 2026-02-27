from django.core.exceptions import ValidationError
from django.db import models
from django_countries.fields import CountryField


class TimeStampedModel(models.Model):
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)

    objects = models.Manager()

    class Meta:
        abstract = True


# Create your models here.
class Airport(TimeStampedModel):
    icao = models.CharField(max_length=4, unique=True, primary_key=True)
    iata = models.CharField(max_length=3, blank=True)
    name = models.CharField(max_length=255)
    city = models.CharField(max_length=255)
    country = CountryField()
    lat = models.DecimalField(max_digits=9, decimal_places=6)
    lon = models.DecimalField(max_digits=9, decimal_places=6)

    def __str__(self):
        return f"{self.icao} ({self.name})"

    class Meta:
        ordering = ["icao"]


class Airline(TimeStampedModel):
    name = models.CharField(max_length=255)
    icao = models.CharField(max_length=3, unique=True)
    iata = models.CharField(max_length=3, blank=True)
    country = CountryField()
    lock = models.CharField(max_length=1, primary_key=True, default="X", null=False)

    def save(self, *args, **kwargs):
        if not self.pk and Airline.objects.exists():
            raise ValidationError("Only one Airline instance is allowed.")
        super().save(*args, **kwargs)

    def delete(self, *args, **kwargs):
        pass

    @classmethod
    def get(cls):
        return cls.objects.first()

    def __str__(self):
        return f"{self.name} ({self.icao})"

    class Meta:
        verbose_name = "Airline"
        verbose_name_plural = "Airline"
