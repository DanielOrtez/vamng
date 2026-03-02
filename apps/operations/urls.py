from django.urls import path

from .views import BidView, BookRouteView, RouteView, select_fleet

urlpatterns = [
    path("routes/", RouteView.as_view(), name="routes"),
    path("routes/book", BookRouteView.as_view(), name="book_flight"),
    path("routes/<int:route_id>/select-fleet", select_fleet, name="select_fleet"),
    path("bid/", BidView.as_view(), name="bid"),
]
