.PHONY: up
up:
	docker compose up -d
	docker compose logs -f

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

.PHONY: cs-fix #phony name
cs-fix: # actual command name that will be ran on terminal
	docker compose exec back composer run cs-fix #the long command that you are shortening

.PHONY: blogs
blogs:
	docker compose exec back tail -f /var/www/html/var/log/dev.log

.PHONY: bbash
bbash:
	docker compose exec back bash

.PHONY: wbash
wbash:
	docker compose exec webApp bash