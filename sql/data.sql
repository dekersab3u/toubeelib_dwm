-- Adminer 4.8.1 PostgreSQL 17.2 (Debian 17.2-1.pgdg120+1) dump

DROP TABLE IF EXISTS "patient";
CREATE TABLE "public"."patient" (
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


DROP TABLE IF EXISTS "praticien";
CREATE TABLE "public"."praticien" (
                                      "id" uuid NOT NULL,
                                      "email" character varying(128) NOT NULL,
                                      "password" character varying(256) NOT NULL,
                                      "role" smallint DEFAULT '0' NOT NULL,
                                      "nom" character varying(128) NOT NULL,
                                      "prenom" character varying(128) NOT NULL,
                                      "tel" character varying(14),
                                      CONSTRAINT "prat
icien_id" PRIMARY KEY ("id"),
                                      CONSTRAINT "praticien_email" UNIQUE ("email")
) WITH (oids = false);


DROP TABLE IF EXISTS "PraticienToSpecialite";
CREATE TABLE "public"."PraticienToSpecialite" (
                                                  "id_prat" uuid NOT NULL,
                                                  "id_spe" uuid NOT NULL,
                                                  CONSTRAINT "pk_praticien_to_specialite" PRIMARY KEY ("id_prat", "id_spe")
) WITH (oids = false);

INSERT INTO "PraticienToSpecialite" ("id_prat", "id_spe") VALUES
                                                              ('f384f9e5-a1e7-493a-81a7-fd1672172169',	'3d3c4e39-4f90-4c86-8e10-361a268cd2b8'),
                                                              ('48f7e54b-c36c-428b-95d9-7dae0459260a',	'c385b3ff-ceac-493a-be19-896452e08961');

DROP TABLE IF EXISTS "patient";
CREATE TABLE "public"."patient" (
                                    "id" uuid NOT NULL,
                                    "email" character varying(128) NOT NULL,
                                    "password" character varying(256) NOT NULL,
                                    "role" smallint DEFAULT '0' NOT NULL,
                                    "nom" character varying(128) NOT NULL,
                                    "prenom" character varying(128) NOT NULL,
                                    "dateNaiss" timestamp,
                                    CONSTRAINT "patient_email" UNIQUE ("email"),
                                    CONSTRAINT "patient_id" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "patient" ("id", "email", "password", "role", "nom", "prenom", "dateNaiss") VALUES
                                                                                            ('a09545f7-5b92-4c85-a5f2-125c57568c34',	'jean.dupont@example.com',	'password1',	0,	'Dupont',	'Jean',	'1985-06-15 08:00:00'),
                                                                                            ('f3704089-5b68-4b0d-8c0b-7b9fba038db1',	'marie.curie@example.com',	'password2',	0,	'Curie',	'Marie',	NULL);

DROP TABLE IF EXISTS "praticien";
CREATE TABLE "public"."praticien" (
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

INSERT INTO "praticien" ("id", "email", "password", "role", "nom", "prenom", "tel") VALUES
                                                                                        ('f384f9e5-a1e7-493a-81a7-fd1672172169',	'doc.house@example.com',	'password3',	1,	'House',	'Gregory',	'0123456789'),
                                                                                        ('48f7e54b-c36c-428b-95d9-7dae0459260a',	'doc.who@example.com',	'password4',	1,	'Who',	'Doctor',	'0987654321');

DROP TABLE IF EXISTS "rdvs";
CREATE TABLE "public"."rdvs" (
                                 "id" uuid NOT NULL,
                                 "id_patient" uuid NOT NULL,
                                 "id_praticien" uuid NOT NULL,
                                 "id_specialite" uuid,
                                 "status" character varying DEFAULT 'prévu' NOT NULL,
                                 "date_rdv" timestamp NOT NULL,
                                 CONSTRAINT "rdvs_id" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "rdvs" ("id", "id_patient", "id_praticien", "id_specialite", "status", "date_rdv") VALUES
                                                                                                   ('2aa8d8e7-6fcf-407d-ae96-578284231219',	'a09545f7-5b92-4c85-a5f2-125c57568c34',	'f384f9e5-a1e7-493a-81a7-fd1672172169',	'3d3c4e39-4f90-4c86-8e10-361a268cd2b8',	'confirmé',	'2025-01-15 10:30:00'),
                                                                                                   ('8afd5414-a09a-429b-9ad5-d4ef48dffdb2',	'f3704089-5b68-4b0d-8c0b-7b9fba038db1',	'48f7e54b-c36c-428b-95d9-7dae0459260a',	'c385b3ff-ceac-493a-be19-896452e08961',	'prévu',	'2025-01-16 14:00:00');

DROP TABLE IF EXISTS "specialite";
CREATE TABLE "public"."specialite" (
                                       "id" uuid NOT NULL,
                                       "label" character varying(128) NOT NULL,
                                       "description" text NOT NULL,
                                       CONSTRAINT "specialite_id" PRIMARY KEY ("id"),
                                       CONSTRAINT "specialite_label_unique" UNIQUE ("label")
) WITH (oids = false);

INSERT INTO "specialite" ("id", "label", "description") VALUES
                                                            ('3d3c4e39-4f90-4c86-8e10-361a268cd2b8',	'Cardiologie',	'Médecine spécialisée dans les maladies du cœur'),
                                                            ('c385b3ff-ceac-493a-be19-896452e08961',	'Dermatologie',	'Médecine spécialisée dans les maladies de la peau');

ALTER TABLE ONLY "public"."PraticienToSpecialite" ADD CONSTRAINT "fk_praticien" FOREIGN KEY (id_prat) REFERENCES praticien(id) ON DELETE CASCADE NOT DEFERRABLE;
ALTER TABLE ONLY "public"."PraticienToSpecialite" ADD CONSTRAINT "fk_specialite" FOREIGN KEY (id_spe) REFERENCES specialite(id) ON DELETE CASCADE NOT DEFERRABLE;

ALTER TABLE ONLY "public"."rdvs" ADD CONSTRAINT "fk_rdvs_patient" FOREIGN KEY (id_patient) REFERENCES patient(id) ON DELETE CASCADE NOT DEFERRABLE;
ALTER TABLE ONLY "public"."rdvs" ADD CONSTRAINT "fk_rdvs_praticien" FOREIGN KEY (id_praticien) REFERENCES praticien(id) ON DELETE CASCADE NOT DEFERRABLE;
ALTER TABLE ONLY "public"."rdvs" ADD CONSTRAINT "fk_rdvs_specialite" FOREIGN KEY (id_specialite) REFERENCES specialite(id) ON DELETE SET NULL NOT DEFERRABLE;

-- 2025-01-08 13:04:47.699865+00