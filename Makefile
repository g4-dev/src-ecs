SHELL := /bin/bash
projectname = ecs
D = /data
ScriptsDir = $(D)/$(projectname)
www = $(D)/$(projectname)/www
console = php $(www)/bin/console
migration_dir = $(www)/migrations
NPROC := $(shell nproc)
# Be careful with this command (nfs / shared folder should be disabled)
clean_vagrant:
	/bin/bash /tmp/cleaner.sh

# DATABASES OPERATIONS
local_script = $(D)/$(projectname)/$(projectname).sql
remote_script = $(D)/$(projectname)/remote_.sql

# Mettre à jour notre base de donnée locale avec celles de l'externe
db_soft_update:
	$(console) doctrine:schema:update -f
	$(console) doctrine:fixtures:load -n

# Mettre à jour la base de donnée externe avec nos datas
db_update_remote:
	MYSQL_PWD="ecommerce" mysqldump --single-transaction --skip-lock-tables -u ecs_user ecommerce > $(local_script)
	mysql -u EmwnLitSLR  -h remotemysql.com EmwnLitSLR -pGk0qCm6hFI --execute="USE EmwnLitSLR;SOURCE $(local_script);"

db_rebuild:
	$(console) doctrine:database:drop --connection=default --force -n
	$(console) doctrine:database:create --connection=default -n
	$(console) doctrine:schema:update -f -n
	$(console) doctrine:fixture:load -n
	$(console) ecs:init-app

db_schema:
	$(console) doctrine:schema:update -f -n

test:
	APP_ENV=test php /data/ecs/www/vendor/bin/paratest -p$(NPROC) /data/ecs/www/

test_with_coverage:
	APP_ENV=test $(console) cache:clear && $(console) cache:warmup && \
	php /www/vendor/bin/paratest -p$(NPROC) --coverage-html www/tests/results

# Synchronise your files automaticly (daemonized)
sync:
	vagrant rsync-auto > /dev/null &

# trying all the ways to kill rsync auto
stop_sync :
	pkill -9 vagrant rsync-auto
	pgrep -f vagrant rsync | xargs kill -9
	pgrep -f vagrant rsync-auto | xargs kill -9
	pgrep -f rsync-auto | xargs kill -9
