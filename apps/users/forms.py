from django import forms
from django.contrib.auth import get_user_model
from django.contrib.auth.forms import (
    AuthenticationForm,
    BaseUserCreationForm,
    UserChangeForm,
)
from django_countries.fields import CountryField
from django_countries.widgets import CountrySelectWidget

User = get_user_model()


class LoginForm(AuthenticationForm):
    username = forms.EmailField(
        label="Email",
        required=True,
        widget=forms.EmailInput(
            attrs={
                "class": "input input-lg w-full mt-2",
                "autocomplete": "email",
                "autofocus": True,
                "placeholder": "Email",
                "id": "username",
            }
        ),
    )
    password = forms.CharField(
        required=True,
        strip=False,
        widget=forms.PasswordInput(
            attrs={
                "class": "input input-lg w-full mt-2",
                "autocomplete": "current-password",
                "placeholder": "Password",
                "id": "password",
            }
        ),
    )


class RegisterForm(BaseUserCreationForm):
    email = forms.EmailField(
        required=True,
        widget=forms.EmailInput(
            attrs={
                "class": "input input-lg w-full mt-2",
                "id": "email",
                "autocomplete": "email",
            }
        ),
    )
    password1 = forms.CharField(
        label="Password",
        required=True,
        strip=False,
        widget=forms.PasswordInput(
            attrs={"class": "input input-lg w-full mt-2", "id": "password1"}
        ),
    )
    password2 = forms.CharField(
        label="Confirm password",
        required=True,
        strip=False,
        widget=forms.PasswordInput(
            attrs={"class": "input input-lg w-full mt-2", "id": "password2"}
        ),
    )
    full_name = forms.CharField(
        label="Full Name",
        required=True,
        widget=forms.TextInput(
            attrs={
                "class": "input input-lg w-full mt-2",
                "id": "first_name",
                "autocomplete": "given-name",
            }
        ),
    )
    country = CountryField(blank=True, blank_label="Select a Country").formfield(
        widget=CountrySelectWidget(
            layout="{widget}",
            attrs={"class": "select select-lg w-full mt-2"},
        )
    )

    class Meta:
        model = User
        fields = (
            "email",
            "password1",
            "password2",
            "full_name",
            "country",
        )


class UpdateProfileForm(UserChangeForm):
    email = forms.EmailField(
        label="Email",
        required=True,
        widget=forms.EmailInput(
            attrs={
                "class": "input input-lg w-full mt-2",
                "id": "email",
                "autocomplete": "email",
            }
        ),
    )
    full_name = forms.CharField(
        label="Full Name",
        required=True,
        widget=forms.TextInput(
            attrs={
                "class": "input input-lg w-full mt-2",
                "id": "full_name",
                "autocomplete": "given-name",
            }
        ),
    )
    country = CountryField(blank=True, blank_label="Select a Country").formfield(
        widget=CountrySelectWidget(
            layout="{widget}",
            attrs={"class": "select select-lg w-full mt-2"},
        )
    )

    password = None

    class Meta:
        model = User
        fields = ("email", "full_name", "country")
