##
## —— PHP_CS 🧰 ————————————————————————————————————————————————————————————————

_PHP_CS_FIXER_CONFIG=.php-cs-fixer.php
_PHP_CS_FIXER_DIST_CONFIG=.php-cs-fixer.dist.php
_PHP_CS_FIXER_TEST_CONFIG=.php-cs-fixer.test.php
_PHP_CS_FIXER_CONFIG_FILE=${_PHP_CS_FIXER_DIST_CONFIG}
_PHP_CS_FIXER_CACHE_FILE=.src.php-cs-fixer.cache
_PHP_CS_FIXER_CACHE_TESTS_FILE=.tests.php-cs-fixer.cache

a_php_cs_fixer_full: a_php_cs_fixer_src_run a_php_cs_fixer_tests_run ## Run PHP-CS-Fixer on src and tests
	@${_NO_OP};

a_php_cs_fixer_src_run: ## Run PHP-CS-Fixer on src
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}PHP-CS-Fixer run...${_C_STOP} ${_C_RED}src${_C_STOP}\n";
	@-${_DC_EXEC} ${APP_CONTAINER} php-cs-fixer -vvv fix --config=${WORKING_DIR}/.tools/.php-cs-fixer/${_PHP_CS_FIXER_CONFIG_FILE} --cache-file=${WORKING_DIR}/.tools/.php-cs-fixer/${_PHP_CS_FIXER_CACHE_FILE} --allow-risky=yes
	@${_ECHO};

a_php_cs_fixer_tests_run: ## Run PHP-CS-Fixer on tests
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}PHP-CS-Fixer run...${_C_STOP} ${_C_RED}tests${_C_STOP}\n";
	@-${_DC_EXEC} ${APP_CONTAINER} php-cs-fixer -vvv fix --config=${WORKING_DIR}/.tools/.php-cs-fixer/${_PHP_CS_FIXER_TEST_CONFIG} --cache-file=${WORKING_DIR}/.tools/.php-cs-fixer/${_PHP_CS_FIXER_CACHE_TESTS_FILE} --allow-risky=yes
	@${_ECHO};

a_php_cs_fixer_dry: ## Run PHP-CS-Fixer on src in dry-run mode
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}PHP-CS-Fixer run...${_C_STOP}\n";
	@-${_DC_EXEC} ${APP_CONTAINER} php-cs-fixer -vvv fix --config=${WORKING_DIR}/.tools/.php-cs-fixer/${_PHP_CS_FIXER_CONFIG_FILE} --cache-file=${WORKING_DIR}/.tools/.php-cs-fixer/${_PHP_CS_FIXER_CACHE_FILE} --allow-risky=yes --diff --dry-run
	@${_ECHO};
