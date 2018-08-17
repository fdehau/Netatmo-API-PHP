IGNORE=src/Netatmo/,src/Clients,src/Objects,src/Handlers,src/Constants

.PHONY: test
test:
	@./vendor/bin/phpunit

.PHONY: lint
lint:
	@./vendor/bin/phpcs --ignore=$(IGNORE) src/ tests/

.PHONY: fmt
fmt:
	@./vendor/bin/phpcbf --ignore=$(IGNORE) src/ tests/
