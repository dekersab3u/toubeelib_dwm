DROP TABLE IF EXISTS "praticien";

CREATE TABLE "praticien" (
                           "id" uuid NOT NULL,
                           "email" character varying(128) NOT NULL,
                           "password" character varying(256) NOT NULL,
                           "role" smallint DEFAULT '0' NOT NULL,
                           "nom" character varying(128) NOT NULL,
                           "prenom" character varying(128) NOT NULL,
                           "tel" character varying(14),
                           CONSTRAINT "praticien_email" UNIQUE ("email"),
                           CONSTRAINT "praticien_id" PRIMARY KEY ("id")
) WITH (oids = false);