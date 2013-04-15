--------------- SQL ---------------

CREATE TABLE "public"."mu_alunos" (
  "numg_aluno" BIGSERIAL NOT NULL, 
  "numr_aluno" INTEGER UNIQUE,
  "data_ativacao" DATE,
  "numg_usuarioativacao" integer,
  "data_desativacao" DATE,
  "numg_usuariodesativacao" integer,
  "desc_status" character(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY("numg_aluno")
) WITH OIDS;

--------------- SQL ---------------

CREATE TABLE mu_matriculas(
  numg_matricula bigserial NOT NULL,
  numg_modalidade integer,
  numg_aluno integer,
  data_matricula timestamp(6) without time zone NOT NULL,
  numg_usuariomatricula integer,
  numr_diasemana integer,
  numr_horarios character varying(5),
  PRIMARY KEY ("numg_matricula")
) WITH OIDS;

--------------- SQL ---------------

CREATE TABLE "public"."mu_modalidades" (
  "numg_modalidade" BIGSERIAL NOT NULL, 
  "desc_modalidade" VARCHAR(155) NOT NULL, 
  "valr_modalidade" NUMERIC(20,2),
  "data_cadastro" DATE,
  "numg_usuariocadastro" INTEGER NOT NULL, 
  "data_bloqueio" timestamp without time zone,
  "numg_usuariobloqueio" INTEGER, 
  PRIMARY KEY("numg_modalidade")
) WITH OIDS;
  
--------------- SQL ---------------

CREATE TABLE "public"."mu_professoresmodalidades" (
  "numg_modalidade" INTEGER, 
  "numg_professor" INTEGER, 
  "numr_diasemana" INTEGER, 
  "hora_inicioaula" DATE,
  "hora_fimaula" DATE
) WITH OIDS;
  
--------------- SQL ---------------

CREATE TABLE "public"."mu_professores" (
  "numg_professor" BIGSERIAL NOT NULL,
  "data_ativacao" timestamp without time zone,
  "numg_usuarioativacao" integer,
  "data_desativacao" timestamp without time zone,
  "numg_usuariodesativacao" integer,
  "desc_status" character(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY("numg_professor")
) WITH OIDS;
  
--------------- SQL ---------------

ALTER TABLE "public"."mu_matriculas"
  ADD CONSTRAINT "mu_matriculas_fk" FOREIGN KEY ("numg_aluno")
    REFERENCES "public"."mu_alunos"("numg_aluno")
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
	--------------- SQL ---------------

ALTER TABLE "public"."mu_alunos"
  ADD CONSTRAINT "mu_alunos_fk" FOREIGN KEY ("numg_aluno")
    REFERENCES "public"."ge_pessoas"("numg_pessoa")
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
	--------------- SQL ---------------

ALTER TABLE "public"."mu_professores"
  ADD CONSTRAINT "mu_professores_fk" FOREIGN KEY ("numg_professor")
    REFERENCES "public"."ge_pessoas"("numg_pessoa")
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
	--------------- SQL ---------------

ALTER TABLE "public"."mu_professoresmodalidades"
  ADD CONSTRAINT "mu_professoresmodalidades_fk" FOREIGN KEY ("numg_modalidade")
    REFERENCES "public"."mu_modalidades"("numg_modalidade")
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
	--------------- SQL ---------------

ALTER TABLE "public"."mu_professoresmodalidades"
  ADD CONSTRAINT "mu_professoresmodalidades_fk1" FOREIGN KEY ("numg_professor")
    REFERENCES "public"."mu_professores"("numg_professor")
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;