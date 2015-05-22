all: config.php.inc
	@echo "Generated:"
	@cat config.php.inc

config.php.inc:
	@cat config.php | sed  "s/'api_key' => '.*'/'api_key' => ''/g" | sed "s/'user_id' => '.*'/'user_id' => ''/g" > config.php.inc

clean:
	@rm config.php.inc
