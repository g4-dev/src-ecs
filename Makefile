SHELL := /bin/bash
projectname = ecs
D = /data
ScriptsDir = $(D)/$(projectname)
www = $(D)/$(projectname)/www
console = php $(www)/bin/console
migration_dir = $(www)/migrations

# Be careful with this command (nfs / shared folder should be disabled)
clean_vagrant:
	/bin/bash /tmp/cleaner.sh

# DATABASES OPERATIONS
local_script = $(D)/$(projectname)/$(projectname).sql
remote_script = $(D)/$(projectname)/remote_.sql

# Mettre à jour notre base de donnée locale avec celles de l'externe
db_update_local:
	rm -rf $(local_script) || true
	mysqldump -t --single-transaction --insert-ignore -u EmwnLitSLR -pGk0qCm6hFI  -h remotemysql.com EmwnLitSLR > $(remote_script)
	$(console) doctrine:schema:update --force -n
	$(console) doctrine:database:import $(remote_script) -n

# Mettre à jour la base de donnée externe avec nos datas
db_update_remote:
	$(console) doctrine:database:drop --connection=remote --force -n
	$(console) doctrine:database:create --connection=remote -n
	$(console) doctrine:migrations:diff -n
	$(console) doctrine:migrations:migrate --db=remote -n
	rm -rf $(migration_dir)/*
	rm -rf $(local_script) || true
	mysqldump -t --insert-ignore --skip-opt -u ecs_user  -pecommerce  -h 127.0.0.1 ecommerce > $(local_script)
	$(console) doctrine:database:import --connection=remote $(local_script)

db_rebuild:
	$(console) doctrine:database:drop --connection=default --force -n
	$(console) doctrine:database:create --connection=default -n
	$(console) doctrine:fixture:load

# Synchronisz your files automaticly
sync:
	vagrant rsync-auto < /dev/null &

# trying all ways to kill rsync aut
stop_sync:
	pkill -9 vagrant rsync-auto
	pgrep -f vagrant rsync | xargs kill -9
	pgrep -f vagrant rsync-auto | xargs kill -9
	pgrep -f rsync-auto | xargs kill -9

