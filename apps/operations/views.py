import datetime

from django.contrib.auth.decorators import login_required
from django.contrib.auth.mixins import LoginRequiredMixin
from django.http import HttpResponse
from django.shortcuts import render
from django.urls import reverse
from django.views.generic import View
from django_filters.views import FilterView

from .filters import RouteFilter
from .models import Bid, FleetType, Route


# Create your views here.
class BaseRouteView(FilterView):
    model = Route
    context_object_name = "routes"
    paginate_by = 25
    filterset_class = RouteFilter

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
    def get_queryset(self):
        return Route.objects.select_related(
            "departure_airport", "arrival_airport"
        ).prefetch_related("fleet_allowed")


class BookRouteView(LoginRequiredMixin, BaseRouteView):
    def get_queryset(self):
        user_location = self.request.user.curr_airport
        qs = Route.objects.all()
        if user_location:
            qs = Route.objects.filter(departure_airport=user_location)

        return qs

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        context["is_booking"] = True
        context["show_departure"] = not bool(self.request.user.curr_airport)

        return context


@login_required(login_url="/login/")
def select_fleet(request, route_id):
    route = Route.objects.get(id=route_id)
    fleets = route.fleet_allowed.all()

    return render(
        request, "operations/select_fleet.html", {"fleets": fleets, "route": route}
    )


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
            expires_at=datetime.datetime.now(),
        )

        response.headers["HX-Redirect"] = reverse("profile")
        return response

    def delete(self, request):
        response = HttpResponse()

        bid = Bid.objects.get(booked_by=request.user.id)
        if bid:
            bid.delete()

        response.headers["HX-Redirect"] = reverse("profile")
        return response
