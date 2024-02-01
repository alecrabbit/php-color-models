_W_TOOLS_DIR=${WORKING_DIR}/${_DN_TOOLS}
_DN_REPORT=.report
_DN_DEPTRAC=.deptrac

_DEPTRAC_CONFIG_FILE=deptrac.yaml
_DEPTRAC_CACHE_FILE=.deptrac.cache
_DEPTRAC_REPORT_FILE=.deptrac.report
_DEPTRAC_GRAPH_FILE=.deptrac.graph.png

DPTR_DIR = ${_W_TOOLS_DIR}/${_DN_DEPTRAC}
DPTR_CONFIG = ${DPTR_DIR}/${_DEPTRAC_CONFIG_FILE}
DPTR_CACHE = ${DPTR_DIR}/${_DEPTRAC_CACHE_FILE}
DPTR_OUT_DIR_LOCAL = ${APP_DIR}/${_DN_TOOLS}/${_DN_REPORT}/${_DN_DEPTRAC}
DPTR_OUT_DIR = ${_W_TOOLS_DIR}/${_DN_REPORT}/${_DN_DEPTRAC}

##
## —— Deptrac 📦 ———————————————————————————————————————————————————————————————

a_deptrac_run_full:  _deptrac_run_message app_deptrac_run _deptrac_run_baseline _deptrac_run_graph _deptrac_run_baseline_formatter  ## Run Deptrac analysis
	@${_NO_OP};

_deptrac_run_message:
	@${_ECHO} "\n${_C_SELECT} ${PROJECT_NAME} ${_C_STOP} ${_C_INFO}Deptrac run...${_C_STOP}\n";

_deptrac_run_baseline:
	@${_ECHO} "${_C_COMMENT}Deptrac baseline...${_C_STOP}";
	@-mkdir -p ${DPTR_OUT_DIR_LOCAL}
	@-${_DC_EXEC} ${APP_CONTAINER} deptrac analyse --no-progress --config-file=${DPTR_CONFIG} --cache-file=${DPTR_CACHE} --no-ansi > ${DPTR_OUT_DIR_LOCAL}/${_DEPTRAC_REPORT_FILE}
	@${_ECHO_OK};
	@${_ECHO};

_deptrac_run_graph:
	@${_ECHO} "${_C_COMMENT}Deptrac graph...${_C_STOP}\n";
	@-${_DC_EXEC} ${APP_CONTAINER} deptrac analyse --no-progress --config-file=${DPTR_CONFIG} --cache-file=${DPTR_CACHE} --formatter=graphviz-image --output=${DPTR_OUT_DIR}/${_DEPTRAC_GRAPH_FILE}
	@${_ECHO};

_deptrac_run_baseline_formatter:
	@${_ECHO} "${_C_COMMENT}Deptrac baseline formatter...${_C_STOP}\n";
	@-${_DC_EXEC} ${APP_CONTAINER} deptrac analyse --no-progress --config-file=${DPTR_CONFIG} --cache-file=${DPTR_CACHE} --formatter=baseline --output=${DPTR_OUT_DIR}/baseline.formatter.output.yaml
	@${_ECHO};

app_deptrac_run:
	@${_ECHO} "${_C_COMMENT}Deptrac main run...${_C_STOP}\n";
	@-${_DC_EXEC} ${APP_CONTAINER} deptrac analyse --clear-cache --config-file=${DPTR_CONFIG} --cache-file=${DPTR_CACHE}

app_deptrac_debug_layer:
	@$(eval c ?=)
	-${_DC_EXEC} ${APP_CONTAINER} deptrac debug:layer $(c) --config-file=${DPTR_CONFIG}

app_deptrac_debug_unassigned:
	-${_DC_EXEC} ${APP_CONTAINER} deptrac debug:unassigned --config-file=${DPTR_CONFIG}

app_deptrac_run_uncovered:
	-${_DC_EXEC} ${APP_CONTAINER} deptrac analyse --fail-on-uncovered --report-uncovered --config-file=${DPTR_CONFIG} --cache-file=${DPTR_CACHE}
