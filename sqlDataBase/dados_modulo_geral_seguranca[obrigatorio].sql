ALTER TABLE se_formularios DISABLE TRIGGER ALL;
INSERT INTO se_formularios (codg_formulario, nome_formulario, nome_completo, desc_formulario, flag_oculto, numr_ordem, data_cadastro, numg_operadorcad, data_bloqueio, numg_operadorbloq, numg_modulo) VALUES ('cadformularios', 'Formulários', 'Cadastro de Formulários', 'Cadastro de Formulários do sistema', false, 1, '2008-03-13 16:26:15.046', 1, NULL, NULL, 1);
INSERT INTO se_formularios (codg_formulario, nome_formulario, nome_completo, desc_formulario, flag_oculto, numr_ordem, data_cadastro, numg_operadorcad, data_bloqueio, numg_operadorbloq, numg_modulo) VALUES ('cadgrupos', 'Grupos de Acesso', 'Cadastro de Grupos de Acesso', 'Cadastro de Grupos de Acesso ao sistema', false, 3, '2008-03-13 16:26:15.046', 1, NULL, NULL, 1);
INSERT INTO se_formularios (codg_formulario, nome_formulario, nome_completo, desc_formulario, flag_oculto, numr_ordem, data_cadastro, numg_operadorcad, data_bloqueio, numg_operadorbloq, numg_modulo) VALUES ('cadoperadores', 'Operadores do Sistema', 'Cadastro de Operadores do Sistema', 'Cadastro de Operadores do Sistema as', false, 4, '2008-03-13 16:26:15.046', 1, NULL, NULL, 1);
INSERT INTO se_formularios (codg_formulario, nome_formulario, nome_completo, desc_formulario, flag_oculto, numr_ordem, data_cadastro, numg_operadorcad, data_bloqueio, numg_operadorbloq, numg_modulo) VALUES ('cadmodulos', 'Módulos', 'Cadastro de módulos', 'Cadastro de Módulos', false, 0, '2010-09-01 00:00:00', 1, NULL, NULL, 1);
ALTER TABLE se_formularios ENABLE TRIGGER ALL;

ALTER TABLE se_grupos DISABLE TRIGGER ALL;
INSERT INTO se_grupos (nome_grupo, desc_grupo, data_cadastro, numg_operadorcad, data_bloqueio, numg_operadorbloq) VALUES ('Administradores', 'Administradores', '2010-08-30 11:34:37.234', 1, NULL, NULL);
ALTER TABLE se_grupos ENABLE TRIGGER ALL;

ALTER TABLE se_gruposmodulos DISABLE TRIGGER ALL;
INSERT INTO se_gruposmodulos (numg_grupo, numg_modulo) VALUES (1, 1);
ALTER TABLE se_gruposmodulos ENABLE TRIGGER ALL;

ALTER TABLE se_modulos DISABLE TRIGGER ALL;
INSERT INTO se_modulos (codg_modulo, desc_modulo, numg_operadorcad, numg_operadorbloq, numr_ordem, data_cadastro, data_bloqueio, desc_nome) VALUES ('seguranca', 'Modulo de segurança do sistema', 1, NULL, 1, '2010-09-06 00:00:00', NULL, 'Segurança');
ALTER TABLE se_modulos ENABLE TRIGGER ALL;

ALTER TABLE se_operadores DISABLE TRIGGER ALL;
INSERT INTO se_operadores (nome_operador, nome_completo, desc_senha, desc_email, data_cadastro, numg_operadorcad, data_ultimaalt, numg_operadoralt, data_bloqueio, numg_operadorbloq, data_ultimoacesso) VALUES ('admin', 'Administrador Geral do Sistema', '13579;=?', 'suporte.sis.setal@gmail.com', '2008-12-18 11:34:37.234', 1, NULL, NULL, NULL, NULL, '2010-09-10 00:24:30.412');
ALTER TABLE se_operadores ENABLE TRIGGER ALL;

ALTER TABLE se_operadoresgrupos DISABLE TRIGGER ALL;
INSERT INTO se_operadoresgrupos (numg_operador, numg_grupo) VALUES (1, 1);
ALTER TABLE se_operadoresgrupos ENABLE TRIGGER ALL;