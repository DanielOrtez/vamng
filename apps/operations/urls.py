from django.urls import path

from .views import book_flight, cancel_bid, routes

urlpatterns = [
    path("cancel-bid/", cancel_bid, name="cancel_bid"),
    path("routes/", routes, name="routes"),
    path("book-flight/", book_flight, name="book_flight"),
]
