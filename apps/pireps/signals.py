from django.contrib.auth import get_user_model
from django.dispatch.dispatcher import Signal, receiver

flight_signal = Signal()

User = get_user_model()


@receiver(flight_signal)
def handle_flight_completed(sender, instance, **kwargs):
    pass
