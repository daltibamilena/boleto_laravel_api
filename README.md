# Docker Boleto Laravel

### Getting Started with Setting up Environment


`git clone git@github.com:daltibamilena/boleto_laravel_api.git`

`cd boleto_laravel_api`

`sh docker/setup.sh`

`docker-compose up -d`



## How to set up first time
`docker compose exec app bash`

`php artisan key:generate`

`php artisan config:cache`

`composer install`

## Routes
By default the route will be on `http://localhost:8000`

## Usage
To generate Itau boleto, you need to provide an logo to the company the boleto will be made, you must provide a .png image to this path:
`/resource/images`
