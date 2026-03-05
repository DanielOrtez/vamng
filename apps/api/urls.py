from ninja import NinjaAPI

api = NinjaAPI()


api.add_router(prefix="/user", router="apps.api.routers.users.user_router")
api.add_router(
    prefix="/operations", router="apps.api.routers.operations.operations_router"
)
api.add_router(prefix="/pireps", router="apps.api.routers.pireps.pireps_router")
