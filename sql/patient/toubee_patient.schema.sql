DROP TABLE IF EXISTS "patient";

CREATE TABLE "patient" (
                           "id" uuid NOT NULL,
                           "email" character varying(128) NOT NULL,
                           "password" character varying(256) NOT NULL,
                           "role" smallint DEFAULT '0' NOT NULL,
                           "nom" character varying(128) NOT NULL,
                           "prenom" character varying(128) NOT NULL,
                           "dateNaiss" date NOT NULL,
                           CONSTRAINT "patient_email" UNIQUE ("email"),
                           CONSTRAINT "patient_id" PRIMARY KEY ("id")
) WITH (oids = false);
