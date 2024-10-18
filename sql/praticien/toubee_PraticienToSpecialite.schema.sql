DROP TABLE IF EXISTS "PraticienToSpecialite";

CREATE TABLE "PraticienToSpecialite"
(
    "id_prat" uuid NOT NULL,
    "id_spe" uuid NOT NULL,
    CONSTRAINT "pk_praticien_to_specialite" PRIMARY KEY ("id_prat", "id_spe"),
    CONSTRAINT "fk_praticien" FOREIGN KEY ("id_prat") REFERENCES "praticien" ("id") ON DELETE CASCADE,
    CONSTRAINT "fk_specialite" FOREIGN KEY ("id_spe") REFERENCES "specialite" ("id") ON DELETE CASCADE
) WITH (oids = false);
