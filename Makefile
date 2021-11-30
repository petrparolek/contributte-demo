.PHONY: qa cs cfx phpstan tests build

qa: cs phpstan

cs:
	vendor/bin/codesniffer app tests

csfix:
	vendor/bin/codefixer app tests

phpstan:
	vendor/bin/phpstan analyse -l 8 -c phpstan.neon --memory-limit=512M app tests/toolkit

tests:
	vendor/bin/tester -s -p php --colors 1 -C tests

tests-coverage:
	vendor/bin/tester -s -p phpdbg --colors 1 -C --coverage ./coverage.xml --coverage-src ./app tests

#####################
# LOCAL DEVELOPMENT #
#####################

build:
	NETTE_DEBUG=1 bin/console orm:schema-tool:drop --force --full-database
	NETTE_DEBUG=1 bin/console migrations:migrate --no-interaction
	NETTE_DEBUG=1 bin/console doctrine:fixtures:load --no-interaction --append
