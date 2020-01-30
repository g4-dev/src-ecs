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
	$(console) doctrine:schema:update --force
	$(console) doctrine:database:import $(remote_script)

# Mettre à jour la base de donnée externe avec nos datas
db_update_remote:
	rm -rf $(local_script) || true
	$(console) doctrine:schema:update --force
	mysqldump -t --insert-ignore --skip-opt -u ecs_user  -pecommerce  -h 127.0.0.1 ecommerce > $(local_script)
	$(console) doctrine:database:import --connection=remote $(remote_script)
