from django.contrib import admin

from .models import FleetType, Route


# Register your models here.
@admin.register(FleetType)
class FleetTypeAdmin(admin.ModelAdmin):
    list_display = ("name", "icao_code", "pax_capacity", "cargo_capacity", "ci")


@admin.register(Route)
class RouteAdmin(admin.ModelAdmin):
    autocomplete_fields = ("departure_airport", "arrival_airport")
    list_display = (
        "code",
        "departure_airport",
        "arrival_airport",
        "flight_time",
        "is_active",
        "get_fleet_type",
    )

    @admin.display(description="Fleet Types Allowed")
    def get_fleet_type(self, obj):
        return ", ".join(obj.fleet_allowed.values_list("icao_code", flat=True))
