-- Adminer 4.8.1 PostgreSQL 16.1 (Debian 16.1-1.pgdg120+1) dump

DROP TABLE IF EXISTS "groupement";
CREATE TABLE "public"."groupement" (
    "id" uuid DEFAULT gen_random_uuid() NOT NULL,
    "nom" character varying(48) NOT NULL,
    "type_id" integer NOT NULL,
    "adresse" text NOT NULL,
    "ville" character varying(128)
) WITH (oids = false);


DROP TABLE IF EXISTS "personnel";
CREATE TABLE "public"."personnel" (
    "id" uuid NOT NULL,
    "nom" character varying(48) NOT NULL,
    "prenom" character varying(48) NOT NULL,
    "mail" character varying(128) NOT NULL,
    "telephone" character varying(24) NOT NULL,
    "groupe_id" uuid NOT NULL
) WITH (oids = false);


DROP TABLE IF EXISTS "praticien";
CREATE TABLE "public"."praticien" (
    "id" uuid NOT NULL,
    "nom" character varying(48) NOT NULL,
    "prenom" character varying(48) NOT NULL,
    "ville" character varying(48) NOT NULL,
    "email" character varying(128) NOT NULL,
    "telephone" character varying(24) NOT NULL,
    "specialite_id" integer NOT NULL,
    "groupe_id" uuid
) WITH (oids = false);


DROP TABLE IF EXISTS "specialite";
DROP SEQUENCE IF EXISTS specialite_id_seq;
CREATE SEQUENCE specialite_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."specialite" (
    "id" integer DEFAULT nextval('specialite_id_seq') NOT NULL,
    "libelle" character varying(48) NOT NULL,
    "description" text,
    CONSTRAINT "specialite_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "type_groupement";
DROP SEQUENCE IF EXISTS "Type_groupement_id_seq";
CREATE SEQUENCE "Type_groupement_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."type_groupement" (
    "id" integer DEFAULT nextval('"Type_groupement_id_seq"') NOT NULL,
    "type_libelle" character varying(48) NOT NULL,
    "type_description" text NOT NULL,
    CONSTRAINT "Type_groupement_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


-- 2024-10-24 15:13:04.798097+00