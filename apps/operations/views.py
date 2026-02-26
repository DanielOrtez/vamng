from django.shortcuts import redirect, render

from .models import Bid


# Create your views here.
def cancel_bid(request):
    if request.method == "POST":
        bid = Bid.objects.get(booked_by=request.user.id)
        bid.delete()

    return redirect(request.META.get("HTTP_REFERER"))
