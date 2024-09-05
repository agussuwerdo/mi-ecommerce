# Makefile for mi-ecommerce Docker project

# Docker compose file
DOCKER_COMPOSE_FILE = docker-compose.yml

# Default target: Build and start the containers
.PHONY: build
build: ## Build and start the Docker containers in detached mode
	@echo "Starting Docker containers..."
	docker-compose -f $(DOCKER_COMPOSE_FILE) up -d --build

# Default target: Build and start the containers
.PHONY: up
up: ## Build and start the Docker containers in detached mode
	@echo "Starting Docker containers..."
	docker-compose -f $(DOCKER_COMPOSE_FILE) up -d

# Stop the containers
.PHONY: stop
stop: ## Stop the Docker containers
	@echo "Stopping Docker containers..."
	docker-compose -f $(DOCKER_COMPOSE_FILE) stop

# Bring down the containers and remove them
.PHONY: down
down: ## Stop and remove the Docker containers
	@echo "Stopping and removing Docker containers..."
	docker-compose -f $(DOCKER_COMPOSE_FILE) down

# View logs
.PHONY: logs
logs: ## Tail the logs for Docker containers
	@echo "Tailing logs for mi-ecommerce containers..."
	docker-compose -f $(DOCKER_COMPOSE_FILE) logs -f

# Remove all volumes (including database)
.PHONY: clean
clean: ## Remove Docker containers and volumes (database will be reset)
	@echo "Cleaning up Docker containers and volumes..."
	docker-compose -f $(DOCKER_COMPOSE_FILE) down -v

# Rebuild the containers without using the cache
.PHONY: rebuild
rebuild: ## Rebuild Docker containers without using the cache
	@echo "Rebuilding Docker containers without cache..."
	docker-compose -f $(DOCKER_COMPOSE_FILE) build --no-cache

# Restart the containers
.PHONY: restart
restart: down up ## Restart the Docker containers
	@echo "Docker containers restarted."

# Access the PHP container shell
.PHONY: shell
shell: ## Access the PHP container shell
	@echo "Accessing PHP container shell..."
	docker exec -it mi_ecommerce_php bash

# Run migrations
.PHONY: migrate
migrate: ## start the database migration
	@echo "Running migrations..."
	docker exec -it mi_ecommerce_php php index.php migration

# Run composer install inside the PHP container
.PHONY: composer-install
composer-install: ## Install Composer dependencies inside the PHP container
	@echo "Running composer install in the PHP container..."
	docker exec -it mi_ecommerce_php composer install --no-interaction --prefer-dist

# Display this help message
.PHONY: help
help: ## Show this help message
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-15s\033[0m %s\n", $$1, $$2}'
