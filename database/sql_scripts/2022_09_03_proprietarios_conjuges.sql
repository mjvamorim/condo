use condo1;
alter table proprietarios add column conjuge_nome  varchar(100) after cpf;
alter table proprietarios add column conjuge_cpf varchar(20) after conjuge_nome;
