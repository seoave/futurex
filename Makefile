hello:
	echo "hello world"

in:
	docker exec -it futurex-php-1 sh

up:
	docker compose up -d


down:
	docker compose down
	docker ps

