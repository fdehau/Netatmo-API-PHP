.PHONY: test
test:
	@./vendor/bin/phpunit

.PHONY: lint
lint:
	@./vendor/bin/phpcs --ignore=src/Netatmo/,src/Clients,src/Objects,src/Handlers,src/Constants src/ tests/
