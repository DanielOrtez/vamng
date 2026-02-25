import csv

from django.core.management.base import BaseCommand

from apps.core.models import Airport


class Command(BaseCommand):
    help = "Import airports from a CSV file. CSV should have columns: icao, iata, name, city, country, lat, lon."

    def add_arguments(self, parser):
        parser.add_argument(
            "csv_file",
            type=str,
            help="Path to the CSV file containing airport data.",
        )

    def handle(self, *args, **options):
        csv_file = options["csv_file"]

        with open(csv_file, newline="", encoding="utf-8") as f:
            reader = csv.DictReader(f)

            for row in reader:
                print(row)
                Airport.objects.update_or_create(**row)

        self.stdout.write(self.style.SUCCESS("Airports imported successfully."))
