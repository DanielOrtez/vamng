from django.urls import path

from .views import cancel_bid

urlpatterns = [path("cancel-bid/", cancel_bid, name="cancel_bid")]
