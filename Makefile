IGNORE=src/Netatmo/,src/Clients,src/Objects,src/Handlers,src/Constants

.PHONY: install
install:
	@composer install --no-suggest

.PHONY: update
update:
	@composer update

.PHONY: test
test:
	@./vendor/bin/phpunit

.PHONY: lint
lint:
	@./vendor/bin/phpcs --ignore=$(IGNORE) src/ tests/

.PHONY: fmt
fmt:
	@./vendor/bin/phpcbf --ignore=$(IGNORE) src/ tests/

.PHONY: clean
clean:
	@rm -rf ./vendor
