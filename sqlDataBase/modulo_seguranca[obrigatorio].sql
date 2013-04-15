CREATE TABLE se_formularios(
  numg_formulario BIGSERIAL NOT NULL,
  codg_formulario character varying(30) NOT NULL,
  nome_formulario character varying(30) NOT NULL,
  nome_completo character varying(50) NOT NULL,
  desc_formulario character varying(255) NOT NULL,
  flag_oculto boolean DEFAULT false,
  numr_ordem smallint,
  data_cadastro timestamp without time zone NOT NULL DEFAULT ('now'::text)::timestamp(6) with time zone,
  numg_operadorcad smallint DEFAULT 1,
  data_bloqueio timestamp without time zone,
  numg_operadorbloq smallint,
  numg_modulo integer NOT NULL,
  CONSTRAINT pk_se_formularios PRIMARY KEY (numg_formulario)
);

CREATE TABLE se_grupos(
  numg_grupo BIGSERIAL NOT NULL,
  nome_grupo character varying(50) NOT NULL,
  desc_grupo character varying(255) NOT NULL,
  data_cadastro timestamp without time zone NOT NULL DEFAULT ('now'::text)::timestamp(6) with time zone,
  numg_operadorcad smallint NOT NULL,
  data_bloqueio timestamp without time zone,
  numg_operadorbloq smallint,
  CONSTRAINT pk_se_grupos PRIMARY KEY (numg_grupo)
);

CREATE TABLE se_operadores(
  numg_operador BIGSERIAL NOT NULL,
  nome_operador character varying(20) NOT NULL,
  nome_completo character varying(50) NOT NULL,
  desc_senha character varying(8) NOT NULL,
  desc_email character varying(50) NOT NULL,
  data_cadastro timestamp without time zone NOT NULL DEFAULT ('now'::text)::timestamp(6) with time zone,
  numg_operadorcad smallint NOT NULL,
  data_ultimaalt timestamp without time zone,
  numg_operadoralt smallint,
  data_bloqueio timestamp without time zone,
  numg_operadorbloq smallint,
  data_ultimoacesso timestamp without time zone,
  CONSTRAINT pk_se_operadores PRIMARY KEY (numg_operador)
);

CREATE TABLE se_operadoresgrupos (
    numg_operador smallint NOT NULL,
    numg_grupo smallint NOT NULL
);

CREATE TABLE se_modulos(
  numg_modulo BIGSERIAL NOT NULL,
  codg_modulo character varying(50) NOT NULL,
  desc_modulo character varying(250),
  numg_operadorcad smallint DEFAULT 1,
  numg_operadorbloq smallint,
  numr_ordem integer NOT NULL,
  data_cadastro timestamp without time zone,
  data_bloqueio timestamp without time zone,
  desc_nome character varying(50) NOT NULL,
  CONSTRAINT se_modulos_pkey PRIMARY KEY (numg_modulo),
  CONSTRAINT se_modulos_numg_operadorbloq_fkey FOREIGN KEY (numg_operadorbloq)
      REFERENCES se_operadores (numg_operador) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT se_modulos_numg_operadorcad_fkey FOREIGN KEY (numg_operadorcad)
      REFERENCES se_operadores (numg_operador) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT se_modulos_codg_modulo_key UNIQUE (codg_modulo)
);

CREATE INDEX fki_se_modulos_numg_operadorbloq_fkey
  ON se_modulos
  USING btree
  (numg_operadorbloq);

CREATE INDEX fki_se_modulos_numg_operadorcad_fkey
  ON se_modulos
  USING btree
  (numg_operadorcad);

CREATE TABLE se_gruposmodulos(
  numg_grupo integer NOT NULL,
  numg_modulo integer NOT NULL,
  CONSTRAINT fk_numg_grupo FOREIGN KEY (numg_grupo)
      REFERENCES se_grupos (numg_grupo) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fk_numg_modulo FOREIGN KEY (numg_modulo)
      REFERENCES se_modulos (numg_modulo) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

ALTER TABLE ONLY se_formularios
    ADD CONSTRAINT se_formularios_numg_operadorbloq_fkey FOREIGN KEY (numg_operadorbloq) REFERENCES se_operadores(numg_operador) ON UPDATE RESTRICT ON DELETE RESTRICT;

ALTER TABLE ONLY se_formularios
    ADD CONSTRAINT se_formularios_numg_operadorcad_fkey FOREIGN KEY (numg_operadorcad) REFERENCES se_operadores(numg_operador) ON UPDATE RESTRICT ON DELETE RESTRICT;

ALTER TABLE ONLY se_grupos
    ADD CONSTRAINT se_grupos_numg_operadorbloq_fkey FOREIGN KEY (numg_operadorbloq) REFERENCES se_operadores(numg_operador) ON UPDATE RESTRICT ON DELETE RESTRICT;

ALTER TABLE ONLY se_grupos
    ADD CONSTRAINT se_grupos_numg_operadorcad_fkey FOREIGN KEY (numg_operadorcad) REFERENCES se_operadores(numg_operador) ON UPDATE RESTRICT ON DELETE RESTRICT;

ALTER TABLE ONLY se_operadores
    ADD CONSTRAINT se_operadores_numg_operadoralt_fkey FOREIGN KEY (numg_operadoralt) REFERENCES se_operadores(numg_operador) ON UPDATE RESTRICT ON DELETE RESTRICT;

ALTER TABLE ONLY se_operadores
    ADD CONSTRAINT se_operadores_numg_operadorbloq_fkey FOREIGN KEY (numg_operadorbloq) REFERENCES se_operadores(numg_operador) ON UPDATE RESTRICT ON DELETE RESTRICT;

ALTER TABLE ONLY se_operadores
    ADD CONSTRAINT se_operadores_numg_operadorcad_fkey FOREIGN KEY (numg_operadorcad) REFERENCES se_operadores(numg_operador) ON UPDATE RESTRICT ON DELETE RESTRICT;

ALTER TABLE ONLY se_operadoresgrupos
    ADD CONSTRAINT se_operadoresgrupos_numg_grupo_fkey FOREIGN KEY (numg_grupo) REFERENCES se_grupos(numg_grupo) ON UPDATE RESTRICT ON DELETE RESTRICT;

ALTER TABLE ONLY se_operadoresgrupos
    ADD CONSTRAINT se_operadoresgrupos_numg_operador_fkey FOREIGN KEY (numg_operador) REFERENCES se_operadores(numg_operador) ON UPDATE RESTRICT ON DELETE RESTRICT;

ALTER TABLE ONLY se_formularios
  ADD CONSTRAINT se_formularios_fk FOREIGN KEY (numg_modulo) REFERENCES se_modulos(numg_modulo) ON DELETE NO ACTION ON UPDATE NO ACTION NOT DEFERRABLE;

CREATE TABLE se_logs (
    numg_modalidade BIGSERIAL NOT NULL,
    numg_modulo INTEGER NOT NULL,
    desc_formulario character varying(50) NOT NULL,
    descricao character varying(255) NOT NULL,
    desc_tipoacao character varying(255) NOT NULL,
    data_cadastro DATE NOT NULL,
    datahora_cadastro timestamp without time zone NOT NULL,
    desc_usuario character varying(50) NOT NULL,
    PRIMARY KEY("numg_log")
);