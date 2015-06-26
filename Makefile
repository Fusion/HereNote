WGET=\wget --quiet
CP=\cp -f
RM=\rm -rf
MKDIR=mkdir -p

all: deps_updated
	@echo "All Done"

installer: config.php.inc in/dev.db.schema.sql in/dev.db.inc
	@echo "Installer files created"

config.php.inc:
	@echo "Creating sanitized config.php.inc" file
	@cat config.php | sed  "s/'mode'      => '.*'/'mode' => 'dev'/g" | \
        sed  "s/'api_key' => '.*'/'api_key' => ''/g" | \
		sed "s/'user_id' => '.*'/'user_id' => ''/g" | \
		sed "s/'site_root' => '.*'/'site_root' => '\/'/g" | \
		sed "s/'admin_key' => '.*'/'admin_key' => ''/g" > config.php.inc

in/dev.db.schema.sql:
	@echo "Creating database schema sql templates"
	@echo ".dump" | sqlite3 /var/www/data/dev.db \
		| grep -v 'INTO "mae_redirect"' \
		| grep -v 'INTO "mae_refdirect_counter"' \
		| grep -v 'INTO "mae_users"' \
		| perl -0pe 's/INSERT INTO "mae_comments".*?CREATE TABLE "mae_refdirect_counter"/CREATE TABLE "mae_refdirect_counter"/smg' \
		| perl -0pe 's/INSERT INTO "mae_posts".*?CREATE TABLE mae_content_format_types/CREATE TABLE mae_content_format_types/smg' \
		> in/dev.db.schema.sql 

in/dev.db.inc:
	@echo "Creating database schema vacuumed templates"
	@cp -f /var/www/data/dev.db in/dev.db.inc
	@echo "DELETE FROM mae_redirect; DELETE FROM mae_refdirect_counter;" | sqlite3 in/dev.db.inc
	@echo "DELETE FROM mae_comments; DELETE FROM mae_posts;" | sqlite3 in/dev.db.inc
	@echo "DELETE FROM mae_users; VACUUM;" | sqlite3 in/dev.db.inc


deps:
	deps_updated

deps_updated:
	@echo "Synchronizing git submodules"
	@git submodule update --init --recursive
	@echo -n "Installing package artefacts "
	@if [ ! -d "thirdparty/highlight" ]; then \
		\echo -n "."; \
		$(MKDIR) thirdparty/highlight; \
		\cd thirdparty/highlight; \
		$(WGET) http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/highlight.min.js; \
		$(WGET) http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/styles/agate.min.css; \
		cd ../..; \
    fi
	@if [ ! -f "thirdparty/Parsedown.php" ]; then \
		\echo -n "."; \
		$(CP) thirdparty/src/parsedown/Parsedown.php thirdparty/Parsedown.php; \
    fi
	@if [ ! -d "thirdparty/epiceditor" ]; then \
		\echo -n "."; \
		$(MKDIR) thirdparty/epiceditor; \
    fi
	@if [ ! -d "thirdparty/epiceditor/js" ]; then \
		\echo -n "."; \
		$(CP) -r thirdparty/src/epiceditor/epiceditor/js thirdparty/epiceditor/; \
    fi
	@if [ ! -d "thirdparty/epiceditor/themes" ]; then \
		\echo -n "."; \
		$(CP) -r thirdparty/src/epiceditor/epiceditor/themes thirdparty/epiceditor/; \
    fi
	@if [ ! -d "thirdparty/quill" ]; then \
		\echo -n "."; \
		\cd thirdparty; \
		$(WGET) https://github.com/quilljs/quill/releases/download/v0.19.12/quill.tar.gz; \
		\tar zxvf quill.tar.gz > /dev/null; \
		$(RM) quill.tar.gz; \
		cd ..; \
	fi
	@if [ ! -d "thirdparty/notifyme" ]; then \
		\echo -n "."; \
		$(MKDIR) thirdparty/notifyme; \
    fi
	@if [ ! -f "thirdparty/notifyme/notifyme.js" ]; then \
		\echo -n "."; \
		$(CP) thirdparty/src/notifyme/assets/js/notifyme.js thirdparty/notifyme/notifyme.js; \
    fi
	@if [ ! -f "thirdparty/notifyme/notifyme.css" ]; then \
		\echo -n "."; \
		$(CP) thirdparty/src/notifyme/assets/css/notifyme.css thirdparty/notifyme/notifyme.css; \
    fi
	@echo
	@touch deps_updated

clean:
	@echo "Deleting config"
	@if [ -f config.php.inc ]; then $(RM) config.php.inc; fi
	@echo "Deleting database templates"
	@if [ -f in/dev.db.inc ]; then $(RM) in/dev.db.inc; fi
	@if [ -f in/dev.db.schema.sql ]; then $(RM) in/dev.db.schema.sql; fi
	@echo "Deleting third party package artefacts"
	@if [ -d "thirdparty/highlight" ]; then $(RM) thirdparty/highlight; fi
	@if [ -f "thirdparty/Parsedown.php" ]; then $(RM) thirdparty/Parsedown.php; fi
	@if [ -d "thirdparty/epiceditor" ]; then $(RM) thirdparty/epiceditor; fi
	@if [ -d "thirdparty/quill" ]; then $(RM) thirdparty/quill; fi
	@if [ -d "thirdparty/notifyme" ]; then $(RM) thirdparty/notifyme; fi
	@echo "Confirmed"
	@if [ -f deps_updated ]; then $(RM) deps_updated; fi

help: comments

comments:
	@echo ""
	@echo "Comments:"
	@echo "There is no downside to running 'make clean' as many times as you want!"
	@echo "However, this will delete your config.php file so be careful."
	@echo ""
	@echo "To add another package as a module:"
	@echo "git submodule add -f git://github.com/<author>/<repository>.git thirdparty/src/<pkgname>"
	@echo ""
	@echo "Note:"
	@echo "Some packages, such as quill, require too much build work to take place"
	@echo "so hopefully an automated download link can be used."
	@echo ""
	@echo "Also, you should never need to use the 'installer' target"
	@echo ""
