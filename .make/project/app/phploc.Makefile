PHPLOC_DIR = /usr/local/bin
_PHPLOC_SRC_REPORT_FILE=.src.phploc.report
_PHPLOC_TEST_REPORT_FILE=.test.phploc.report

a_phploc_run:
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}PHPLOC run...${_C_STOP}\n";
	@mkdir -p ${APP_DIR}/.tools/.report/.phploc
	@-${_DC_EXEC} ${APP_CONTAINER} ${PHPLOC_DIR}/phploc src > ${APP_DIR}/.tools/.report/.phploc/${_PHPLOC_SRC_REPORT_FILE}
	@-${_DC_EXEC} ${APP_CONTAINER} ${PHPLOC_DIR}/phploc tests > ${APP_DIR}/.tools/.report/.phploc/${_PHPLOC_TEST_REPORT_FILE}
	@${_ECHO} "\n${_C_INFO}📝 'tests' PHPLOC report:${_C_STOP}\n";
	@-cat ${APP_DIR}/.tools/.report/.phploc/${_PHPLOC_TEST_REPORT_FILE}
	@${_ECHO} "\n${_C_INFO}📝 'src' PHPLOC report:${_C_STOP}\n";
	@-cat ${APP_DIR}/.tools/.report/.phploc/${_PHPLOC_SRC_REPORT_FILE}
	@${_ECHO};
