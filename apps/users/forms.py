from django import forms
from django.contrib.auth.forms import AuthenticationForm, BaseUserCreationForm
from django_countries.fields import CountryField
from django_countries.widgets import CountrySelectWidget

from .models import MyUser


class LoginForm(AuthenticationForm):
    username = forms.EmailField(
        label="Email",
        required=True,
        widget=forms.EmailInput(
            attrs={
                "class": "input w-full mt-2",
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
                "class": "input w-full mt-2",
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
            attrs={"class": "input w-full mt-2", "id": "email", "autocomplete": "email"}
        ),
    )
    password1 = forms.CharField(
        label="Password",
        required=True,
        strip=False,
        widget=forms.PasswordInput(
            attrs={"class": "input w-full mt-2", "id": "password1"}
        ),
    )
    password2 = forms.CharField(
        label="Confirm password",
        required=True,
        strip=False,
        widget=forms.PasswordInput(
            attrs={"class": "input w-full mt-2", "id": "password2"}
        ),
    )
    first_name = forms.CharField(
        label="Name(s)",
        required=True,
        widget=forms.TextInput(
            attrs={
                "class": "input w-full mt-2",
                "id": "first_name",
                "autocomplete": "given-name",
            }
        ),
    )
    last_name = forms.CharField(
        label="Lastname(s)",
        required=True,
        widget=forms.TextInput(attrs={"class": "input w-full mt-2", "id": "last_name"}),
    )
    country = CountryField(blank=True, blank_label="Select a Country").formfield(
        widget=CountrySelectWidget(
            layout="{widget}",
            attrs={"class": "select w-full mt-2"},
        )
    )

    class Meta:
        model = MyUser
        fields = ("email", "password1", "password2", "first_name", "last_name")
