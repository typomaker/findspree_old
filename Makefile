solution = findspree
common = backend common environments frontend tests
private = composer.json init init.bat .bowerrc
all:
	@echo Solution '${solution}-web-interface'
	@printf "solution=%s\nweb_revision=%s\n" ${solution} "`svnversion `" > version
	@find -type d -exec chown www-data:www-data {} \; -print
	@find -type d -exec chmod -R 750 {} \; -print
	@find -type f -exec chown www-data:www-data {} \; -print
	@find -type f -exec chmod -R 640 {} \; -print
	@tar cvf ${solution}-web-interface.tar --exclude=frontend/web/images/* --exclude=frontend/web/assets/*  --exclude=frontend/runtime/*  --exclude=common/config/main-local.php  --exclude=frontend/config/main-local.php \
	${common} \
	${private} \

	@gzip -f ${solution}-web-interface.tar
