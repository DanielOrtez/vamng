from django.contrib.auth import get_user_model
from django.contrib.auth.mixins import LoginRequiredMixin
from django.contrib.auth.views import LoginView
from django.shortcuts import redirect
from django.urls import reverse_lazy
from django.views.generic import CreateView, DetailView, UpdateView

from .forms import LoginForm, RegisterForm, UpdateProfileForm

User = get_user_model()


# Create your views here.
class UserRegisterView(CreateView):
    template_name = "users/auth/register.html"
    success_url = reverse_lazy("login")
    form_class = RegisterForm

    def get(self, request, *args, **kwargs):
        if request.user.is_authenticated:
            return redirect("profile")
        return super().get(request, *args, **kwargs)


class UserLoginView(LoginView):
    template_name = "users/auth/login.html"
    authentication_form = LoginForm
    redirect_authenticated_user = True


class ProfileView(LoginRequiredMixin, DetailView):
    model = User
    template_name = "users/profile.html"
    context_object_name = "user"

    def get_object(self, queryset=None):
        return User.active.get_profile(self.request.user.id)


class EditProfileView(LoginRequiredMixin, UpdateView):
    form_class = UpdateProfileForm
    template_name = "users/edit_profile.html"
    success_url = reverse_lazy("profile")

    def get_object(self, queryset=None):
        return self.request.user
