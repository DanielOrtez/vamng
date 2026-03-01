import datetime

from django.contrib.auth.decorators import login_required
from django.contrib.auth.mixins import LoginRequiredMixin
from django.http import HttpResponse
from django.shortcuts import redirect, render
from django.urls import reverse
from django.views import View

from .filters import RouteFilter
from .helpers import paginate_model, render_page_or_htmx
from .models import Bid, FleetType, Route


# Create your views here.
def index_routes(request):
    all_routes = Route.objects.select_related(
        "departure_airport", "arrival_airport"
    ).prefetch_related("fleet_allowed")

    f_routes = RouteFilter(request.GET, all_routes)
    routes, elided_range = paginate_model(request, f_routes.qs)

    fleets = FleetType.objects.values("id", "icao_code")

    return render_page_or_htmx(
        request,
        "operations/routes.html",
        "operations/partials/_table_routes.html",
        routes=routes,
        elided_range=elided_range,
        fleets=fleets,
    )


@login_required(login_url="/login/")
def select_fleet(request, route_id):
    route = Route.objects.get(id=route_id)
    fleets = route.fleet_allowed.all()

    return render(
        request, "operations/select_fleet.html", {"fleets": fleets, "route": route}
    )


class BookFlightView(LoginRequiredMixin, View):
    def get(self, request):
        user_routes = (
            Route.objects.filter(departure_airport=request.user.curr_airport)
            .select_related("departure_airport", "arrival_airport")
            .prefetch_related("fleet_allowed")
        )

        f_routes = RouteFilter(request.GET, user_routes)
        routes, elided_range = paginate_model(request, f_routes.qs)

        fleets = FleetType.objects.values("id", "icao_code")

        return render_page_or_htmx(
            request,
            "operations/book_flight.html",
            "operations/partials/_table_routes.html",
            routes=routes,
            elided_range=elided_range,
            is_booking=True,
            fleets=fleets,
        )

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


@login_required(login_url="/login/")
def cancel_bid(request):
    if request.method == "POST":
        bid = Bid.objects.get(booked_by=request.user.id)
        bid.delete()

    return redirect(request.META.get("HTTP_REFERER"))
