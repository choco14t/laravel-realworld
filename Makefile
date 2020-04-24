up:
	docker-compose up -d
build:
	docker-compose build
stop:
	docker-compose stop
down:
	docker-compose down
ps:
	docker-compose ps
application:
	docker-compose exec app ash -l
db:
	docker-compose exec db bash
restart:
	docker-compose restart
migrate:
	docker-compose exec app php artisan migrate
seed:
	docker-compose exec app php artisan db:seed
db-refresh:
	docker-compose exec app php artisan migrate:refresh
test:
	docker-compose exec app vendor/bin/phpunit
