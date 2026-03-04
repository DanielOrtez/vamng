from ninja import NinjaAPI

api = NinjaAPI()


api.add_router(prefix="/user", router="apps.api.routers.users.user_router")
