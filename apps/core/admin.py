from django.contrib import admin

from .models import Airline, Airport


# Register your models here.
@admin.register(Airport)
class AirportAdmin(admin.ModelAdmin):
    list_display = ("icao", "name", "city", "country")
    search_fields = ("icao",)


@admin.register(Airline)
class AirlineAdmin(admin.ModelAdmin):
    list_display = ("name", "icao", "country")

    def has_add_permission(self, request):
        return not Airline.objects.exists()

    def has_delete_permission(self, request, obj=None):
        return False
