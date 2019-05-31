name = alexandria

ARGS = $(filter-out $@,$(MAKECMDGOALS))
# MAKEFLAGS += --silent

PWD := $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))

list:
	sh -c "echo; $(MAKE) -p no_targets__ \
		| awk -F':' '/^[a-zA-Z0-9][^\$$#\/\\t=]*:([^=]|$$)/ {split(\$$1,A,/ /);for(i in A)print A[i]}' \
		| grep -v '__\$$' \
		| grep -v 'Makefile' \
		| sort"

build:
	docker image build \
		-t ${name}:latest \
		.

up: build
	docker container run \
		--rm -d \
		--name ${name}-dev \
		--env-file .config --env-file .env \
		-p 8000:80 -p 8443:443 -p 10022:22 \
		-v ${PWD}/app:/app -v ${PWD}/data:/var/alexandria \
		-t ${name}:latest

down:
	docker kill $$( \
		docker ps -aq \
			--filter="name=${name}-dev" )

logs:
	docker container logs -f \
		${name}-dev

bash: shell
shell:
	docker exec -it --user application ${name}-dev /bin/bash

#############################
# Argument fix workaround
%:
	@:
