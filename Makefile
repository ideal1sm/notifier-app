
COMPOSE_FILE ?= docker-compose.local.yml

DC = docker-compose -f $(COMPOSE_FILE)

# ==========================
# Общие команды
# ==========================

.PHONY: up down restart logs bash composer migrate

up:
	$(DC) up -d --build

down:
	$(DC) down

restart: down up

logs:
	$(DC) logs -f

bash:
	$(DC) exec backend bash

composer:
	$(DC) exec backend composer $(ARGS)

# ==========================
# Symfony / Doctrine
# ==========================

migrate:
	$(DC) exec backend php bin/console doctrine:migrations:migrate --no-interaction

cache-clear:
	$(DC) exec backend php bin/console cache:clear

# ==========================
# Переключение окружения
# ==========================

# Для локальной разработки
local:
	$(eval COMPOSE_FILE=docker-compose.local.yml)
	@echo "Используется локальное окружение"

# Для прода
prod:
	$(eval COMPOSE_FILE=docker-compose.prod.yml)
	@echo "Используется прод окружение"
