##
## —— Psalm 👁️  —————————————————————————————————————————————————————————————————

_PSALM_CONFIG_FILE=psalm.xml
_PSALM_REPORT_FILE=.psalm.report.txt

a_psalm_run: ## Run Psalm static analysis
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}Psalm run...${_C_STOP}\n";
	@${_DC_EXEC} ${APP_CONTAINER} mkdir -p ${WORKING_DIR}/.tools/.report/.psalm
	-${_DC_EXEC} ${APP_CONTAINER} psalm --config=${WORKING_DIR}/.tools/.psalm/psalm.xml --report=${WORKING_DIR}/.tools/.report/.psalm/${_PSALM_REPORT_FILE}
