## CurlyCamp

## Clone Repository

Clone the project repository by running the command below if you use SSH

`git clone git@github.com:xaviranik/curlycamp.git`

If you use https, use this instead

`git clone https://github.com/xaviranik/curlycamp.git`

## Getting Started

`cd` into the project directory and run:

`composer install`

Duplicate `.env.example` and rename it `.env`

Run:

`php artisan key:generate`

Then run

`npm install`

Then run:

`npm run dev`

## Database Migrations

Be sure to fill in your database details in your `.env` file before running the migrations:

`php artisan migrate`

Once the database is settup and migrations are up, run

`php artisan serve`

and visit [http://localhost:8000/](http://localhost:8000/) to see the application in action.
