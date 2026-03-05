import datetime

from django.contrib.auth.mixins import LoginRequiredMixin
from django.http import HttpResponse
from django.urls import reverse
from django.utils import timezone
from django.views.generic import ListView, View
from django_filters.views import FilterView

from .filters import RouteFilter
from .models import Bid, FleetType, Route, RouteManager


# Create your views here.
class BaseRouteView(FilterView):
    model = Route
    context_object_name = "routes"
    paginate_by = 25
    filterset_class = RouteFilter

    def get_queryset(self) -> RouteManager:
        return Route.objects.with_related()

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)

        paginator = context["paginator"]
        page = context["page_obj"]

        fleets = FleetType.objects.values("id", "icao_code")

        context["elided_range"] = paginator.get_elided_page_range(number=page.number)

        context["show_departure"] = True

        context["fleets"] = fleets

        return context

    def get_template_names(self):
        if self.request.headers.get("HX-Request"):
            return ["operations/partials/_table_routes.html"]

        return ["operations/routes.html"]


class RouteView(BaseRouteView):
    pass


class BookRouteView(LoginRequiredMixin, BaseRouteView):
    def get_queryset(self):
        user_location = self.request.user.curr_airport_id
        if user_location:
            qs = Route.objects.from_departure_airport(user_location)
        else:
            qs = super().get_queryset()

        return qs

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        context["is_booking"] = True
        context["show_departure"] = not bool(self.request.user.curr_airport_id)
        context["title"] = "Book a Flight"

        return context


class SelectFleetView(LoginRequiredMixin, ListView):
    model = FleetType
    context_object_name = "fleets"
    template_name = "operations/select_fleet.html"

    def get_queryset(self):
        return FleetType.objects.filter(route__id=self.kwargs["route_id"])

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        context["route_id"] = self.kwargs["route_id"]
        return context


class BidView(LoginRequiredMixin, View):
    def post(self, request):
        response = HttpResponse()

        route_id = request.POST.get("route_id")
        fleet_id = request.POST.get("fleet_id")

        if not route_id or not fleet_id:
            response.headers["HX-Redirect"] = reverse("book_flight")
            return response

        Bid.objects.create(
            booked_by=request.user,
            route_id=route_id,
            fleet_type_id=fleet_id,
            expires_at=timezone.now() + datetime.timedelta(days=1),
        )

        response.headers["HX-Redirect"] = reverse("profile")
        return response

    def delete(self, request):
        response = HttpResponse()

        Bid.objects.filter(booked_by=request.user.id).delete()

        response.headers["HX-Redirect"] = reverse("profile")
        return response
