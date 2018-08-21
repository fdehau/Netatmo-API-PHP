IGNORE=src/Netatmo/,src/Clients,src/Objects,src/Handlers,src/Constants

.PHONY: install
install:
	@composer install --no-suggest

.PHONY: update
update:
	@composer update

PHPUNIT_OPTIONS =
ifdef PHPUNIT_FILTER
  PHPUNIT_OPTIONS += --filter $(PHPUNIT_FILTER)
endif
.PHONY: test
test:
	@./vendor/bin/phpunit $(PHPUNIT_OPTIONS)

.PHONY: lint
lint:
	@./vendor/bin/phpcs --ignore=$(IGNORE) src/ tests/

.PHONY: fmt
fmt:
	@./vendor/bin/phpcbf --ignore=$(IGNORE) src/ tests/

.PHONY: clean
clean:
	@rm -rf ./vendor
