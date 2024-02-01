include ${_APP_DIR}/app.init.Makefile
include ${_APP_DIR}/phpinsights.Makefile
include ${_APP_DIR}/tests.Makefile
include ${_APP_DIR}/phploc.Makefile
include ${_APP_DIR}/psalm.Makefile
include ${_APP_DIR}/phpcs.Makefile
include ${_APP_DIR}/deptrac.Makefile

##
## —— Application 📦 ———————————————————————————————————————————————————————————

a_tools_run: test_full a_phploc_run a_php_cs_fixer_full a_deptrac_run_full a_psalm_run a_utils_run ## Run all tools
	@${_NO_OP};

a_utils_run: _app_composer_normalize a_phpinsights_summary ## Run all utils
	@${_NO_OP};
