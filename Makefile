all: config.php.inc deps_updated
	@echo "Generated:"
	@cat config.php.inc

config.php.inc:
	@cat config.php | sed  "s/'api_key' => '.*'/'api_key' => ''/g" | \
		sed "s/'user_id' => '.*'/'user_id' => ''/g" | sed "s/'admin_key' => '.*'/'admin_key' => ''/g" > config.php.inc

deps:
	deps_updated

deps_updated:
	@git submodule update --init --recursive
	@if [ ! -d "thirdparty/highlight" ]; then mkdir thirdparty/highlight; fi
	@if [ ! -f "thirdparty/highlight/highlight.js" ]; then cp thirdparty/src/highlight/src/highlight.js thirdparty/highlight/highlight.js; fi
	@if [ ! -d "thirdparty/highlight/styles" ]; then mkdir thirdparty/highlight/styles; cp thirdparty/src/highlight/src/* thirdparty/highlight/styles/; fi
	@if [ ! -d "thirdparty/Parsedown.php" ]; then cp thirdparty/src/parsedown/Parsedown.php thirdparty/Parsedown.php; fi
	@if [ ! -d "thirdparty/epiceditor" ]; then mkdir thirdparty/epiceditor; fi
	@if [ ! -d "thirdparty/epiceditor/js" ]; then cp -r thirdparty/src/epiceditor/epiceditor/js thirdparty/epiceditor/; fi
	@if [ ! -d "thirdparty/epiceditor/themes" ]; then cp -r thirdparty/src/epiceditor/epiceditor/themes thirdparty/epiceditor/; fi
	@touch deps_updated

clean:
	@rm config.php.inc deps_updated

comments:
	@echo ""
	@echo "Comments:"
	@echo "There is no downside to running 'make clean' as many times as you want!"
	@echo ""
	@echo "To add another package as a module:"
	@echo "git submodule add -f git://github.com/<author>/<repository>.git thirdparty/src/<pkgname>"
	@echo ""
