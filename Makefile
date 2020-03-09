SHELL := /bin/bash
projectname ?= ecs
D ?= /data
WWW ?= $(D)/$(projectname)/www
CONSOLE = php $(WWW)/bin/console
migration_dir = $(WWW)/migrations
VBIN = $(WWW)/vendor/bin
BIN = $(WWW)/bin
NPROC := $(shell nproc)
KERNEL_CLASS := \\Core\\Kernel

# DATABASES OPERATIONS
local_script = $(D)/$(projectname)/$(projectname).sql
remote_script = $(D)/$(projectname)/remote_.sql

# Be careful with this command (nfs / shared folder should be disabled)
clean_vagrant:
	/bin/bash /tmp/cleaner.sh

# Mettre à jour notre base de donnée locale avec celles de l'externe
db_soft:
	$(CONSOLE) doctrine:schema:update -f
	$(CONSOLE) doctrine:fixtures:load -n

db:
	$(CONSOLE) doctrine:database:drop --connection=default --force -n
	$(CONSOLE) doctrine:database:create --connection=default -n
	$(CONSOLE) doctrine:schema:create -n
	$(CONSOLE) doctrine:schema:update -f -n
	$(CONSOLE) doctrine:fixture:load -n
	$(CONSOLE) ecs:init-app

schema:
	$(CONSOLE) doctrine:schema:update -f -n

# sf make simplify
SUPPORTED_COMMANDS := reg_en new_en
# create args
SUPPORTS_MAKE_ARGS := $(findstring $(firstword $(MAKECMDGOALS)), $(SUPPORTED_COMMANDS))

ifneq "$(SUPPORTS_MAKE_ARGS)" ""
  	COMMAND_ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))
  	$(eval $(COMMAND_ARGS):;@:)
endif

# usage make reg_en Core EN="YourEntityName"
reg_en:
	$(CONSOLE) make:entity --regenerate "$(COMMAND_ARGS)\\Entity\\$(EN)"
	echo "Don‘t forget to download updated files"

new_en:
	sed -i -e 's/\troot_namespace:*/\troot_namespace: \\$(COMMAND_ARGS)/g' $(WWW)/config/packages/dev/maker.yaml
	$(CONSOLE) make:entity "$(COMMAND_ARGS)\\Entity\\$(EN)"
	echo "Don‘t forget to download updated files"

# tests
test_install:
	ln -sf $(VBIN)/paratest $(BIN)
	ln -sf $(VBIN)/phpunit $(BIN)

tests:
	APP_ENV=test php $(VBIN)/paratest -p$(NPROC) -f --phpunit=$(VBIN)/phpunit --colors $(WWW)/tests

warmed_test:
	APP_ENV=test $(CONSOLE) cache:clear && $(CONSOLE) cache:warmup && \
	php $(VBIN)/paratest -p$(NPROC) -f --phpunit=$(VBIN)/phpunit --colors $(WWW)/tests

# Synchronise your files automaticly (daemonized)
sync:
	vagrant rsync-auto > /dev/null &

# trying all the ways to kill rsync auto
stop_sync :
	pkill -9 vagrant rsync-auto
	pgrep -f vagrant rsync | xargs kill -9
	pgrep -f vagrant rsync-auto | xargs kill -9
	pgrep -f rsync-auto | xargs kill -9
