all: config.php.inc deps_updated
	@echo "Generated:"
	@cat config.php.inc

config.php.inc:
	@cat config.php | sed  "s/'api_key' => '.*'/'api_key' => ''/g" | sed "s/'user_id' => '.*'/'user_id' => ''/g" > config.php.inc

deps:
	deps_updated

deps_updated:
	@git submodule update --init --recursive
	@if [ ! -d "thirdparty/highlight" ]; then mkdir thirdparty/highlight; fi
	@if [ ! -f "thirdparty/highlight/highlight.js" ]; then cp thirdparty/src/highlight/src/highlight.js thirdparty/highlight/highlight.js; fi
	@if [ ! -d "thirdparty/highlight/styles" ]; then mkdir thirdparty/highlight/styles; cp thirdparty/src/highlight/src/* thirdparty/highlight/styles/; fi
	@if [ ! -d "thirdparty/Parsedown.php" ]; then cp thirdparty/src/parsedown/Parsedown.php thirdparty/Parsedown.php; fi
	@touch deps_updated

clean:
	@rm config.php.inc deps_updated
