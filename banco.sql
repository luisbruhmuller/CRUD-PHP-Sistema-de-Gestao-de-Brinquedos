CREATE DATABASE IF NOT EXISTS gestao_brinquedos
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE gestao_brinquedos;

CREATE TABLE IF NOT EXISTS brinquedos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    categoria VARCHAR(100) NOT NULL,
    faixa_etaria VARCHAR(50) NOT NULL,
    preco DECIMAL(10, 2) NOT NULL,
    quantidade_estoque INT UNSIGNED NOT NULL
);
