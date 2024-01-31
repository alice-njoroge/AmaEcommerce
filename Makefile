.PHONY: up
up:
	docker compose up -d

.PHONY: down
down:
	docker compose down

.PHONY: restart
restart:
	docker compose restart

.PHONY: reset-database
reset-database:
	docker compose exec back  php bin/console doctrine:database:drop -n --force && \
	docker compose exec back php bin/console doctrine:database:create -n && \
	docker compose exec back php bin/console doctrine:schema:update -f --complete && \
	docker compose exec back php bin/console doctrine:f:load -n
	docker compose exec back php bin/console app:add-permissions
	docker compose exec back php bin/console app:add-role
	docker compose exec back php bin/console app:add-user