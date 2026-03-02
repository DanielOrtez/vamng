from datetime import timedelta

from django import template

register = template.Library()


@register.filter
def duration(value: timedelta):
    total_seconds = int(value.total_seconds())
    hours = total_seconds // 3600
    minutes = (total_seconds % 3600) // 60
    return f"{hours:02d}:{minutes:02d}H"


@register.filter
def get_list(req, key: str) -> list:
    return req.getlist(key)
