from typing import Any, Iterator

from django.core.paginator import Page, Paginator
from django.shortcuts import render


def paginate_model(
    request, queryset, per_page: int = 25
) -> tuple[Page[Any], Iterator[int | str]]:
    paginator = Paginator(queryset, per_page)
    page = paginator.get_page(request.GET.get("page", 1))

    elided_range = paginator.get_elided_page_range(number=page.number)

    return page, elided_range


def render_page_or_htmx(request, template: str, partial: str, **kwargs) -> Any:
    if request.headers.get("HX-Request"):
        return render(request, partial, context=kwargs)

    return render(request, template, context=kwargs)
