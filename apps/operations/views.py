from django.contrib.auth.decorators import login_required
from django.core.paginator import Paginator
from django.shortcuts import redirect, render

from .models import Bid, Route


# Create your views here.
def routes(request):
    all_routes = Route.objects.select_related(
        "departure_airport", "arrival_airport"
    ).prefetch_related("fleet_allowed")

    paginator = Paginator(all_routes, 25)
    page_routes = paginator.get_page(request.GET.get("page", 1))

    elided_range = paginator.get_elided_page_range(number=page_routes.number)

    return render(
        request,
        "operations/routes.html",
        {"routes": page_routes, "elided_range": elided_range},
    )


@login_required(login_url="/login/")
def book_flight(request):
    routes_from_curr_loc = Route.objects.filter(
        departure_airport=request.user.curr_airport
    )

    return render(
        request, "operations/book_flight.html", {"routes": routes_from_curr_loc}
    )


@login_required(login_url="/login/")
def cancel_bid(request):
    if request.method == "POST":
        bid = Bid.objects.get(booked_by=request.user.id)
        bid.delete()

    return redirect(request.META.get("HTTP_REFERER"))
