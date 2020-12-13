#CONFIGURATION
export PROJECT_IP = 127.0.0.1
export PROJECT_DOMAIN = symfony-skeleton.dev.local
export PROJECT_NAME = symfony-skeleton
export SHELL = bash

#xdebug
export HOST_PORT = 9000

#DOCKER COMPOSE SETTINGS
export PHP_IDE_CONFIG = serverName=${PROJECT_DOMAIN}

export ENVIRONMENT=dev

#DOCKER
DOCKER = docker
DOCKER_COMPOSE = docker-compose -f ../docker/docker-compose.yml
CLI = $(DOCKER_COMPOSE) exec -T ${PROJECT_NAME}
CLI_D = $(DOCKER_COMPOSE) exec -T -d ${PROJECT_NAME}
CLI_COMPOSER = $(DOCKER_COMPOSE) exec -T ${PROJECT_NAME} php -d memory_limit=-1 /usr/bin/composer
CONSOLE = $(CLI) ./vendor/bin/console

start: ##@development start project
	$(DOCKER_COMPOSE) up -d
.PHONY: start

stop: ##@development stop project
	$(DOCKER_COMPOSE) stop
.PHONY: stop

down: ##@development delete project container
	$(DOCKER_COMPOSE) down
.PHONY: down

build:
	$(DOCKER_COMPOSE) build
.PHONY: build

ps: ##@development show running container
	$(DOCKER_COMPOSE) ps
.PHONY: ps

logs: ##@development show server logs
	$(DOCKER_COMPOSE) logs -f
.PHONY: logs

cli: ##@development get shell
	$(DOCKER_COMPOSE) exec ${PROJECT_NAME} $(SHELL)
.PHONY: cli

composer-install: ##@development run composer install
	$(CLI_COMPOSER) install --ansi
.PHONY: composer-install

composer-update: ##@development run composer update
	$(CLI_COMPOSER) update
.PHONY: composer-update

composer-dump-autoload: ##@development run composer dump-autoload
	$(CLI_COMPOSER) dump-autoload -a
.PHONY: composer-dump-autoload

setup: start ##@development configure development environment
	grep -q -F "${PROJECT_IP} ${PROJECT_DOMAIN}" /etc/hosts || sudo sh -c "echo '${PROJECT_IP} ${PROJECT_DOMAIN}' >> /etc/hosts"
	$(DOCKER_COMPOSE) restart ${PROJECT_NAME}
.PHONY: setup

phpstan: ##@development run phpstan
	$(CLI) ./vendor/bin/phpstan analyze -c dev/phpstan.neon
.PHONY: phpstan

php-cs-fixer: ##@development run php-cs-fixer
	$(CLI) ./vendor/bin/php-cs-fixer fix --config=dev/csfixer.php_cs
.PHONY: php-cs-fixer

phpunit: ##@development run phpunit
	$(CLI) ./vendor/bin/phpunit --configuration dev/phpunit.xml
.PHONY: phpunit

codecheck: php-cs-fixer phpstan phpunit
.PHONY: codecheck
