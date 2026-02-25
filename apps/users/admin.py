from django.contrib import admin
from django.contrib.auth.admin import UserAdmin

from .models import MyUser, Rank


# Register your models here.
@admin.register(MyUser)
class MyUserAdmin(UserAdmin):
    autocomplete_fields = ("curr_airport",)
    fieldsets = UserAdmin.fieldsets + (
        (
            "Additional Info",
            {"fields": ("country", "total_hours", "curr_airport", "rank")},
        ),
    )


@admin.register(Rank)
class RankAdmin(admin.ModelAdmin):
    list_display = ("name", "min_hours")
