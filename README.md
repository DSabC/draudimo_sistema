# Draudimo sistema

Laravel project for managing car owners and cars.

## Features

- Full CRUD for owners
- Full CRUD for cars
- One owner can have many cars
- Each owner belongs to a user through `owners.user_id`
- Car access is derived from the car's owner
- Policies are used for authorization
- Three user roles:
  - `regular` - can view and edit only their own owners and cars
  - `reader` - can view all owners and cars, but can edit only their own
  - `admin` - can view and edit everything
- When creating an owner:
  - admin sees unassigned cars
  - non-admin users can assign only cars from their own owners
- When creating or editing a car:
  - admin can assign any owner or leave the car unassigned
  - non-admin users can assign only their own owners
- Change between 2 languages:
  - `LT` - Lithuanian
  - `EN` - English
- Add photos to cars in edit view

## Database

### `owners`

- `id`
- `name`
- `surname`
- `phone`
- `email`
- `address`
- `user_id`
- `created_at`
- `updated_at`

### `cars`

- `id`
- `reg_number`
- `brand`
- `model`
- `owner_id`
- `created_at`
- `updated_at`

### `users`

- Laravel default users table
- additional field: `role`
- supported values:
  - `regular`
  - `reader`
  - `admin`

## Running the project

1. Install dependencies:
   - `composer install`
   - `npm install`
2. Configure `.env` and set the database connection.
3. Run migrations and seed data:
   - `php artisan migrate:fresh --seed`
4. Start the app:
   - `php artisan serve`
   - `npm run dev`

## Seeded users

- `admin@example.com` / `password`
- `reader@example.com` / `password`
- `regular@example.com` / `password`

## Routes

- `/` redirects to `/owners`
- Main resources:
  - `/owners`
  - `/cars`
