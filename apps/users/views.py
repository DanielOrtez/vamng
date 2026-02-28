from django.contrib.auth.decorators import login_required, user_passes_test
from django.contrib.auth.views import LoginView
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


class UserRegisterView:
    pass


class UserLoginView(LoginView):
    template_name = "users/auth/login.html"
    authentication_form = LoginForm
    redirect_authenticated_user = True


@login_required(login_url="/login/")
def profile(request):
    return render(request, "users/profile.html")
