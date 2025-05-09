CREATE DATABASE cadastropessoa;

use cadastropessoa;

CREATE TABLE pessoa (
  cpf char(14) NOT NULL PRIMARY KEY,
  nome varchar(100) NULL,
  contato char(11) NULL
);
