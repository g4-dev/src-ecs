SHELL := /bin/bash
projectname = ecs
D = /data
CRON_DIR = $(D)/.cr_wk
www = $(D)/$(projectname)/www
console = php $(www)/bin/console
migration_dir = $(www)/migrations

# Be careful with this command (nfs / shared folder should be disabled)
clean_vagrant:
	/bin/bash /tmp/cleaner.sh

# Mettre à jour notre base de donnée locale avec celles de l'externe
db_update_local:
	$(console) doctrine:migrations:generate --db=remote -n
	$(console) doctrine:schema:drop --db=default --full-database
	$(console) doctrine:migrations:migrate --db=default -n
	$(console) doctrine:migrations:version -n "$(shell $(console) doctrine:migrations:latest)" --delete || true
	rm -rf migrations/Version/*

# Mettre à jour la base de donnée externe avec nos datas
db_update_remote:
	$(console) doctrine:migrations:generate --db=default -n
	$(console) doctrine:migrations:migrate --db=remote -n
	$(console) doctrine:migrations:version -n "$(shell $(console) doctrine:migrations:latest)" --delete || true
	rm -rf migrations/Version/*
