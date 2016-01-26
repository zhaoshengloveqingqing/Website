################################################################################
#
# The make file
#
# @author Jack
# @date Wed Sep 17 11:44:55 2014
# @version 1.0
#
################################################################################


################################################################################
#
# Constants
#
################################################################################

SERVER := 218.244.128.8
TEST_DB := pinet_php_test
DB := pinet_php

################################################################################
#
# Applications
#
################################################################################

SSH := ssh
ECHO := echo
PHP := php
MYSQL := mysql
AWK := awk
DB_VERSION := $(shell ls application/migrations/ | sort -n | tail -n 1 | ${AWK} -F '_' '{print $$1}')

################################################################################
#
# Defines
#
################################################################################

define server_operation
	${SSH} -i id_rsa root@${SERVER} $1;
endef

define migrate_db
	@${ECHO} Doing the migrations...
	@PINET_WEB_ENV=$2 ${PHP} index.php migrate version $3
	@${ECHO} Showing the tables...
	@mysql -u root $1 -e "show tables"
endef

define recreate_db
	@${ECHO} Dropping the database $1...
	@${MYSQL} -u root -e "drop database if exists $1"
	@${ECHO} Recreate the database $1...
	@${MYSQL} -u root -e "create database $1"
	$(call migrate_db,$1,$2,${DB_VERSION})
endef

################################################################################
#
# Tasks
#
################################################################################

test:
	@PINET_WEB_ENV=testing ./phpunit .
test_db:
	@$(call recreate_db,${TEST_DB},"testing")
db:
	@$(call recreate_db,${DB},"default")
dep:
	./install_deps
tags:
	ctags -R .
c:
	${MYSQL} -u root ${DB}
ct:
	${MYSQL} -u root ${TEST_DB}
server_pull_code:
	@$(call server_operation,"cd /pinet && git pull origin php")
migrate:
	@$(call migrate_db,${DB},"default",${MV})
deploy: server_pull_code
	@$(call server_operation,"cd /pinet && MV=${DB_VERSION} make migrate")
deploy_new: server_pull_code
	@$(call server_operation,"cd /pinet && make db")
