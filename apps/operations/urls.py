from django.urls import path

from .views import BookFlightView, cancel_bid, index_routes, select_fleet

urlpatterns = [
    path("cancel-bid/", cancel_bid, name="cancel_bid"),
    path("routes/", index_routes, name="routes"),
    path("book-flight/", BookFlightView.as_view(), name="book_flight"),
    path("book-flight/select-fleet/<int:route_id>", select_fleet, name="select_fleet"),
]
