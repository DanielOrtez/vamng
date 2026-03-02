import pytest
from django.contrib.auth import get_user_model
from django.urls import reverse

from apps.core.models import Airline

User = get_user_model()


@pytest.fixture
def airline():
    return Airline.objects.create(
        name="Test Airline", icao="TST", iata="TS", country="ES"
    )


@pytest.fixture
def user_data():
    return {
        "email": "testuser@vamng.es",
        "password1": "test_password123",
        "password2": "test_password123",
        "first_name": "Test",
        "last_name": "User",
        "country": "ES",
    }


@pytest.fixture
def new_user(db, user_data):
    return User.objects.create_user(
        username="TST000", email=user_data["email"], password=user_data["password1"]
    )


@pytest.mark.django_db
class TestLogin:
    def test_login_successfully(self, client, new_user, user_data):
        login_url = reverse("login")
        profile_url = reverse("profile")

        response = client.post(
            login_url, {"username": new_user.email, "password": user_data["password1"]}
        )

        assert response.status_code == 302
        assert response.url == profile_url
        assert "_auth_user_id" in client.session

    def test_login_with_invalid_credentials(self, client, new_user):
        login_url = reverse("login")

        response = client.post(
            login_url, {"username": new_user.email, "password": "wrong_password"}
        )

        assert response.status_code == 200
        assert new_user.email in response.content.decode()
        assert "_auth_user_id" not in client.session

    def test_profile_requires_login(self, client):
        profile_url = reverse("profile")
        login_url = reverse("login")

        response = client.get(profile_url)

        expected_url = f"{login_url}?next={profile_url}"
        assert response.status_code == 302
        assert response.url == expected_url


@pytest.mark.django_db
class TestRegistration:
    def test_registration_successfully(self, client, user_data, airline):
        register_url = reverse("register")
        login_url = reverse("login")

        response = client.post(register_url, user_data)

        assert User.objects.count() == 1
        assert User.objects.filter(username="TST001").exists()
        assert response.url == login_url

    def test_registration_with_mismatched_passwords(self, client, user_data):
        register_url = reverse("register")

        user_data["password2"] = "different_password"

        response = client.post(register_url, user_data)

        assert response.status_code == 200
        assert User.objects.count() == 0

    def test_registration_with_existing_email(
        self, client, user_data, new_user, airline
    ):
        register_url = reverse("register")

        response = client.post(register_url, user_data)

        assert response.status_code == 200
        assert User.objects.count() == 1
