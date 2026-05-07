-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema ejobs2.0
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema ejobs2.0
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `ejobs2` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci ;
USE `ejobs2` ;

-- -----------------------------------------------------
-- Table `ejobs2.0`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ejobs2`.`usuarios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL,
  `status` ENUM('ATIVO', 'INATIVO') NULL,
  `cidade_id` INT NULL,
  `end_logradouro` VARCHAR(255) NULL,
  `end_bairro` VARCHAR(255) NULL,
  `end_numero` VARCHAR(255) NULL,
  `cep` VARCHAR(255) NULL,
  `telefone` VARCHAR(255) NULL,
  `data_criacao` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tipo_usuario` ENUM('EMPRESA', 'CANDIDATO', 'ADMINISTRADOR') NULL,
  PRIMARY KEY (`id`),
  INDEX `usuarios_ibfk_1_idx` (`cidade_id` ASC) VISIBLE,
  CONSTRAINT `usuarios_ibfk_1`
    FOREIGN KEY (`cidade_id`)
    REFERENCES `ejobs2`.`cidades` (`codigo_ibge`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `ejobs2.0`.`empresas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ejobs2`.`empresas` (
  `usuario_id` INT NOT NULL,
  `nome_fantasia` VARCHAR(255) NULL,
  `razao_social` VARCHAR(255) NULL,
  `descricao` VARCHAR(255) NULL,
  `cnpj` VARCHAR(255) NOT NULL,
  `inscricao_estadual` VARCHAR(255) NOT NULL,
  `data_abertura` DATE NULL,
  `logo_url` VARCHAR(500) NULL,
  `site` VARCHAR(255) NULL,
  `numero_funcionarios` INT NULL,
  PRIMARY KEY (`usuario_id`, `inscricao_estadual`),
  INDEX `empresa_ibfk_1_idx` (`usuario_id` ASC) VISIBLE,
  UNIQUE INDEX `cnpj_UNIQUE` (`cnpj` ASC) VISIBLE,
  CONSTRAINT `empresa_ibfk_1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `ejobs2`.`usuarios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ejobs2.0`.`cargos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ejobs2`.`cargos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `ejobs2.0`.`categorias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ejobs2`.`categorias` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NULL DEFAULT NULL,
  `icone` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `ejobs2.0`.`vagas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ejobs2`.`vagas` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(255) NULL DEFAULT NULL,
  `modalidade` ENUM('Home Office', 'Presencial', 'Híbrido') NULL DEFAULT NULL,
  `horario` ENUM('20h', '30h', '40h', '44h', 'Outros') NULL DEFAULT NULL,
  `regime` ENUM('CLT', 'PJ', 'Estágio') NULL DEFAULT NULL,
  `salario` DECIMAL(10,2) NULL DEFAULT NULL,
  `descricao` TEXT NULL DEFAULT NULL,
  `requisitos` TEXT NULL DEFAULT NULL,
  `empresa_id` INT NULL DEFAULT NULL,
  `cargos_id` INT NULL DEFAULT NULL,
  `status` ENUM('Ativo', 'Inativo') NULL DEFAULT NULL,
  `categoria_id` INT NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `cargos_id` (`cargos_id` ASC) VISIBLE,
  INDEX `categoria_id` (`categoria_id` ASC) VISIBLE,
  INDEX `vaga_ibfk_1_idx` (`empresa_id` ASC) VISIBLE,
  CONSTRAINT `vaga_ibfk_1`
    FOREIGN KEY (`empresa_id`)
    REFERENCES `ejobs2`.`empresas` (`usuario_id`),
  CONSTRAINT `vaga_ibfk_2`
    FOREIGN KEY (`cargos_id`)
    REFERENCES `ejobs2`.`cargos` (`id`),
  CONSTRAINT `vaga_ibfk_3`
    FOREIGN KEY (`categoria_id`)
    REFERENCES `ejobs2`.`categorias` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 73
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `ejobs2.0`.`candidatos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ejobs2`.`candidatos` (
  `usuario_id` INT NOT NULL,
  `primeiro_nome` VARCHAR(255) NOT NULL,
  `segundo_nome` VARCHAR(255) NOT NULL,
  `cpf` VARCHAR(255) NOT NULL,
  `genero` VARCHAR(255) NULL,
  `descricao` TEXT NULL DEFAULT NULL,
  `curriculo_url` VARCHAR(255) NULL,
  `foto_perfil_url` VARCHAR(500) NULL,
  `data_nascimento` DATE NOT NULL,
  `linkedin` VARCHAR(255) NULL,
  `github` VARCHAR(255) NULL,
  `escolaridade` VARCHAR(255) NULL,
  `experiencia` VARCHAR(255) NULL,
  INDEX `tipo_usuario_id` (`usuario_id` ASC) VISIBLE,
  PRIMARY KEY (`usuario_id`),
  UNIQUE INDEX `cpf_UNIQUE` (`cpf` ASC) VISIBLE,
  CONSTRAINT `usuario_ibfk_1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `ejobs2`.`usuarios` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 36
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `ejobs2.0`.`candidaturas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ejobs2`.`candidaturas` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `candidato_id` INT NULL DEFAULT NULL,
  `vaga_id` INT NULL DEFAULT NULL,
  `data_candidatura` DATETIME NULL DEFAULT NULL,
  `status` ENUM('EM_ANDAMENTO', 'FINALIZADO', 'APROVADO') CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_0900_ai_ci' NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `vaga_id` (`vaga_id` ASC) VISIBLE,
  INDEX `candidatura_ibfk_2_idx` (`candidato_id` ASC) VISIBLE,
  CONSTRAINT `candidatura_ibfk_1`
    FOREIGN KEY (`vaga_id`)
    REFERENCES `ejobs2`.`vagas` (`id`),
  CONSTRAINT `candidatura_ibfk_2`
    FOREIGN KEY (`candidato_id`)
    REFERENCES `ejobs2`.`candidatos` (`usuario_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 48
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `ejobs2.0`.`notificacoes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ejobs2`.`notificacoes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_origem` INT NULL DEFAULT NULL,
  `id_destino` INT NULL DEFAULT NULL,
  `tipo` ENUM('Candidatura', 'Aprovacao') NOT NULL,
  `mensagem` TEXT NOT NULL,
  `id_vaga` INT NULL DEFAULT NULL,
  `lida` TINYINT(1) NULL DEFAULT '0',
  `data_criacao` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `fk_notif_vaga` (`id_vaga` ASC) VISIBLE,
  INDEX `fk_notif_destino_idx` (`id_destino` ASC) VISIBLE,
  INDEX `fk_notif_origem_idx` (`id_origem` ASC) VISIBLE,
  CONSTRAINT `fk_notif_destino`
    FOREIGN KEY (`id_destino`)
    REFERENCES `ejobs2`.`usuarios` (`id`),
  CONSTRAINT `fk_notif_origem`
    FOREIGN KEY (`id_origem`)
    REFERENCES `ejobs2`.`usuarios` (`id`),
  CONSTRAINT `fk_notif_vaga`
    FOREIGN KEY (`id_vaga`)
    REFERENCES `ejobs2`.`vagas` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 25
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `ejobs2.0`.`usuarios_auth`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ejobs2`.`usuarios_auth` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `usuario_id` INT NOT NULL,
  `provider` ENUM('LOCAL', 'GOOGLE') NOT NULL,
  `provider_id` VARCHAR(255) NULL,
  `senha` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `provider_id_UNIQUE` (`provider_id` ASC) VISIBLE,
  INDEX `usuario_auth_ibfk_1_idx` (`usuario_id` ASC) VISIBLE,
  CONSTRAINT `usuario_auth_ibfk_1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `ejobs2`.`usuarios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ejobs2.0`.`administrador`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ejobs2`.`administrador` (
  `usuario_id` INT NOT NULL,
  PRIMARY KEY (`usuario_id`),
  CONSTRAINT `administrador_ppk1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `ejobs2`.`usuarios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
