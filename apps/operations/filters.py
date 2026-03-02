import django_filters

from .models import FleetType, Route


class RouteFilter(django_filters.FilterSet):
    departure_airport = django_filters.CharFilter(
        field_name="departure_airport__icao", lookup_expr="icontains"
    )
    arrival_airport = django_filters.CharFilter(
        field_name="arrival_airport__icao", lookup_expr="icontains"
    )

    fleet_type = django_filters.ModelMultipleChoiceFilter(
        field_name="fleet_allowed", queryset=FleetType.objects.all()
    )
