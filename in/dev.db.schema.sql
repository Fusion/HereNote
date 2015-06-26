PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;
CREATE TABLE "mae_redirect" (
    "id" integer NOT NULL PRIMARY KEY,
    "site_id" integer NOT NULL,
    "old_path" varchar(200) NOT NULL,
    "new_path" varchar(200) NOT NULL,
    UNIQUE ("site_id", "old_path")
);
CREATE TABLE "mae_comments" (
    "id" integer NOT NULL PRIMARY KEY,
    "content_type_id" integer NOT NULL REFERENCES "django_content_type" ("id"),
    "object_pk" text NOT NULL,
    "site_id" integer NOT NULL REFERENCES "django_site" ("id"),
    "user_id" integer REFERENCES "auth_user" ("id"),
    "user_name" varchar(50) NOT NULL,
    "user_email" varchar(75) NOT NULL,
    "user_url" varchar(200) NOT NULL,
    "comment" text NOT NULL,
    "submit_date" datetime NOT NULL,
    "ip_address" char(15),
    "is_public" bool NOT NULL,
    "is_removed" bool NOT NULL
);
CREATE TABLE "mae_refdirect_counter" (
    "id" integer NOT NULL PRIMARY KEY,
    "downloads" integer unsigned NOT NULL,
    "updated" datetime NOT NULL,
    "obj" varchar(32) NOT NULL,
    "newurl" varchar(256) NOT NULL
);
CREATE TABLE mae_content_types(id integer primary key autoincrement, type_name varchar(16));
INSERT INTO "mae_content_types" VALUES(1,'blog');
INSERT INTO "mae_content_types" VALUES(2,'g+');
INSERT INTO "mae_content_types" VALUES(3,'github');
CREATE TABLE "mae_posts" ("short_url" varchar(200), "site_id" integer NOT NULL, "keywords_string" varchar(500) NOT NULL, "in_sitemap" bool NOT NULL DEFAULT false, "featured_image" varchar(255), "id" integer PRIMARY KEY AUTOINCREMENT, "user_id" integer NOT NULL, "title" varchar(500) NOT NULL, "content" text NOT NULL, "rating_sum" integer NOT NULL, "rating_count" integer NOT NULL, "comments_count" integer NOT NULL, "status" integer NOT NULL, "updated" datetime NULL, "description" text NOT NULL, "rating_average" real NOT NULL, "expiry_date" datetime, "slug" varchar(2000), "gen_description" bool NOT NULL, "allow_comments" bool NOT NULL, "created" datetime, "_meta_title" varchar(500), "publish_date" datetime, content_type references mae_content_types(id), ref_url varchar(255), source_id varchar(128), format_type references mae_content_format_types(id), short_description text, section references mae_sections(id), parent_id integer);
CREATE TABLE mae_content_format_types(id integer primary key autoincrement, type_name varchar(16));
INSERT INTO "mae_content_format_types" VALUES(1,'HTML');
INSERT INTO "mae_content_format_types" VALUES(2,'markdown');
CREATE TABLE mae_users(id integer primary key autoincrement,login varchar(255), password varchar(255), salt varchar(255), realname varchar(255), can_edit boolean);
CREATE TABLE mae_sections(id integer primary key autoincrement, section_name varchar(16));
INSERT INTO "mae_sections" VALUES(1,'blog');
INSERT INTO "mae_sections" VALUES(2,'page');
INSERT INTO "mae_sections" VALUES(3,'note');
DELETE FROM sqlite_sequence;
INSERT INTO "sqlite_sequence" VALUES('mae_content_types',3);
INSERT INTO "sqlite_sequence" VALUES('mae_posts',392);
INSERT INTO "sqlite_sequence" VALUES('mae_content_format_types',2);
INSERT INTO "sqlite_sequence" VALUES('mae_users',1);
INSERT INTO "sqlite_sequence" VALUES('mae_sections',3);
CREATE INDEX "mae_redirect_6223029" ON "mae_redirect" ("site_id");
CREATE INDEX "mae_redirect_516c23f0" ON "mae_redirect" ("old_path");
CREATE INDEX "mae_comments_1bb8f392" ON "mae_comments" ("content_type_id");
CREATE INDEX "mae_comments_6223029" ON "mae_comments" ("site_id");
CREATE INDEX "mae_comments_403f60f" ON "mae_comments" ("user_id");
COMMIT;
