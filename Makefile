IGNORE=src/Netatmo/,src/Clients,src/Objects,src/Handlers,src/Constants,src/Exceptions/NASDKException.php,src/Exceptions/NAClientException.php

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

COVERAGE_DIR = coverage
.PHONY: cov
cov: PHPUNIT_OPTIONS += --coverage-html $(COVERAGE_DIR)
cov:
	@rm -rf $(COVERAGE_DIR)
	@./vendor/bin/phpunit $(PHPUNIT_OPTIONS)

.PHONY: lint
lint:
	@./vendor/bin/phpcs --ignore=$(IGNORE) src/ tests/

.PHONY: fmt
fmt:
	@./vendor/bin/phpcbf --ignore=$(IGNORE) src/ tests/

.PHONY: clean
clean:
	@rm -rf ./vendor $(COVERAGE_DIR)

.PHONY: docs
docs:
	@make -C docs html

.PHONY: watch-docs
watch-docs:
	@watchman-make -p 'docs/**/*.rst' 'docs/**/*.py' -t docs
