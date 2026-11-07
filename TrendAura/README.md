# TrendAura – Fashion Shopping Website

TrendAura is a Django-based fashion shopping website project. This repository contains the source files and static/product images that were present in the supplied ZIP archive.

## Important project completeness note

The supplied archive did not include several files referenced by the existing code, including `fashion/models.py`, `fashion/views.py`, `fashion/urls.py`, and the `templates/` directory. Therefore, this cleaned archive is prepared for GitHub upload, but the application may not run until those missing project files are restored.

## Included

- Django project configuration (`TrendAura/`)
- Fashion app files supplied in the archive (`fashion/`)
- Static CSS, JavaScript, images, and product media
- `manage.py`, `requirements.txt`, and `.gitignore`

## Setup (after restoring missing files)

1. Install Python 3.10 or later.
2. Create and activate a virtual environment.
3. Install dependencies: `pip install -r requirements.txt`.
4. Set a unique `DJANGO_SECRET_KEY` environment variable before deployment.
5. Run migrations: `python manage.py migrate`.
6. Start the development server: `python manage.py runserver`.

## Database and security

The original `db.sqlite3` was excluded because it contained user accounts, order records, and admin activity. The hard-coded development secret key was also replaced with an environment-variable setting. Do not commit real passwords, private keys, customer data, or production credentials.
