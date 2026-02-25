from django.contrib.auth import login as auth_login
from django.contrib.auth.decorators import login_required, user_passes_test
from django.shortcuts import redirect, render

from .forms import LoginForm, RegisterForm
from .utils import not_logged_in


# Create your views here.
@user_passes_test(not_logged_in, login_url="/", redirect_field_name=None)
def register(request):
    if request.method == "POST":
        register_form = RegisterForm(request.POST)

        if register_form.is_valid():
            register_form.save()
            return redirect("login")
    else:
        register_form = RegisterForm()

    return render(request, "users/auth/register.html", {"form": register_form})


@user_passes_test(not_logged_in, login_url="/", redirect_field_name=None)
def login(request):
    login_form = LoginForm(request, data=request.POST or None)

    if request.method == "POST":
        if login_form.is_valid():
            auth_login(request, login_form.get_user())
            return redirect("home")

    return render(request, "users/auth/login.html", {"form": login_form})