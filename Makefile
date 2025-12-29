install:
	composer install

lint:
	php vendor/bin/php-cs-fixer fix --dry-run --diff

lint-fix:
	php vendor/bin/php-cs-fixer fix

test:
	vendor/bin/phpunit

test-coverage:
	php vendor/bin/phpunit --coverage-clover build/logs/clover.xml

validate:
	composer validate

.PHONY: install lint lint-fix test test-coverage validate