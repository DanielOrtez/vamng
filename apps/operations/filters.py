import django_filters


class RouteFilter(django_filters.FilterSet):
    departure_airport = django_filters.CharFilter(
        field_name="departure_airport__icao", lookup_expr="icontains"
    )
    arrival_airport = django_filters.CharFilter(
        field_name="arrival_airport__icao", lookup_expr="icontains"
    )
