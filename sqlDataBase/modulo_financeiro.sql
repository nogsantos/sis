CREATE TABLE "public"."fi_recibos" (
  "numg_recibo" BIGSERIAL NOT NULL,
  "numr_recibo" INTEGER UNIQUE NOT NULL,
  "data_emissao" DATE,
  "valr_recibo" NUMERIC(20,2) NOT NULL,
  "numr_vias" INTEGER,
  "desc_referente" VARCHAR(255),
  "numg_professor" INTEGER,
  "desc_obs" VARCHAR(255),
  "data_cadastro" DATE,
  "numg_usuariocadastro" INTEGER NOT NULL,
  "data_reemissao" DATE,
  "numg_usuarioreemissao" INTEGER,
  "numg_usuariocanc" INTEGER,
  "data_cancelamento" DATE,
  "desc_status" VARCHAR(1),
  "desc_tipo" VARCHAR(1),
  "numg_aluno" INTEGER,
  "desc_recebido" VARCHAR(255),
  "numr_cpfcnpjrec" character varying(20),
  "desc_emitente" VARCHAR(255),
  "numr_cpfcnpjemi" character varying(20),
  "numg_referente" INTEGER,
  PRIMARY KEY("numg_recibo")
) WITH OIDS;

ALTER TABLE "public"."fi_recibos"
  ADD CONSTRAINT "fi_recibos_fk" FOREIGN KEY ("numg_professor")
    REFERENCES "public"."mu_professores"("numg_professor")
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

ALTER TABLE "public"."fi_recibos"
  ADD CONSTRAINT "fi_recibos_fk2" FOREIGN KEY ("numg_aluno")
    REFERENCES "public"."mu_alunos"("numg_aluno")
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

CREATE TABLE "public"."fi_referente" (
  "numg_referente" BIGSERIAL NOT NULL,
  "desc_codigo" varchar(20),
  "desc_referente" VARCHAR(155) NOT NULL,
  "data_cadastro" DATE,
  "numg_usuariocadastro" INTEGER NOT NULL,
  "data_bloqueio" timestamp without time zone,
  "numg_usuariobloqueio" INTEGER,
  PRIMARY KEY("numg_referente")
) WITH OIDS;