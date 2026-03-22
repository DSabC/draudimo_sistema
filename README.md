# Draudimo sistema

Laravel project for managing car owners and cars.

## Features

- Full CRUD for owners
- Full CRUD for cars
- One owner can have many cars
- When creating an owner, only unassigned cars are shown
- When editing an owner, shown cars are:
  - unassigned cars
  - cars already assigned to that owner
- There are 2 user types: 
  - admin - can create, edit and delete
  - non admin - can only see users and cars

## Database

### `owners`

- `id`
- `name`
- `surname`
- `phone`
- `email`
- `address`
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
- additional field: `is_admin`

## Running the project

1. Install dependencies:
   - `composer install`
   - `npm install`
2. Configure `.env` and set database connection.
3. Run migrations and seed:
   - `php artisan migrate:fresh --seed`
4. Start the app:
   - `php artisan serve`
   - `npm run dev`
5. Log in with test `admin` user:
   - email: test@example.com
   - password: password

## Routes

- `/` redirects to `/owners`
- Main resources:
  - `/owners`
  - `/cars`
