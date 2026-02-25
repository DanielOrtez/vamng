def not_logged_in(user) -> bool:
    return not user.is_authenticated
