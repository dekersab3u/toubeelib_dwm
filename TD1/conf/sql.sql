-- Adminer 4.8.1 PostgreSQL 17.2 (Debian 17.2-1.pgdg120+1) dump

DROP TABLE IF EXISTS "article";
DROP SEQUENCE IF EXISTS article_id_seq;
CREATE SEQUENCE article_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."article" (
                                    "id" integer DEFAULT nextval('article_id_seq') NOT NULL,
                                    "nom" character varying(48),
                                    "descr" character varying(256),
                                    "tarif" numeric(10,2),
                                    "id_categ" integer,
                                    CONSTRAINT "article_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "categorie";
CREATE TABLE "public"."categorie" (
                                      "id" integer NOT NULL,
                                      "nom" character varying(32) NOT NULL,
                                      "descr" text,
                                      CONSTRAINT "categorie_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "categorie" ("id", "nom", "descr") VALUES
    (1,	'sport',	'articles de sport');

-- 2025-01-24 22:06:25.762317+00