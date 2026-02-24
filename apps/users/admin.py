from django.contrib import admin
from django.contrib.auth.admin import UserAdmin

from .models import MyUser, Rank

# Register your models here.
admin.site.register(MyUser, UserAdmin)


@admin.register(Rank)
class RankAdmin(admin.ModelAdmin):
    list_display = ("name", "min_hours")
