from django.urls import path

from .views import BidView, BookRouteView, RouteView, SelectFleetView

urlpatterns = [
    path("routes/", RouteView.as_view(), name="routes"),
    path("routes/book", BookRouteView.as_view(), name="book_flight"),
    path(
        "routes/<int:route_id>/select-fleet",
        SelectFleetView.as_view(),
        name="select_fleet",
    ),
    path("bid/", BidView.as_view(), name="bid"),
]
