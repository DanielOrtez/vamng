from django.contrib.auth.views import LogoutView
from django.urls import path

from .views import EditProfileView, ProfileView, UserLoginView, UserRegisterView

urlpatterns = [
    path("register/", UserRegisterView.as_view(), name="register"),
    path("login/", UserLoginView.as_view(), name="login"),
    path("logout/", LogoutView.as_view(), name="logout"),
    # TODO: Add password reset and change views
    path("profile/", ProfileView.as_view(), name="profile"),
    path("profile/edit/", EditProfileView.as_view(), name="edit_profile"),
]
