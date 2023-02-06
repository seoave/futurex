run:
	service docker start

status:
	service docker status 

chmod:
	cd .. && chmod -R a=wrx futurex && cd futurex

in:
	docker exec -it futurex-php-1 sh

up:
	docker compose up -d


down:
	docker compose down
	docker ps

gitcred:
	git config --global credential.helper "/mnt/c/Program\ Files/Git/mingw64/bin/git-credential-manager.exe"

