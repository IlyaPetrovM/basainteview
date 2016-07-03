SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `gb_x_basaibb2` ;
CREATE SCHEMA IF NOT EXISTS `gb_x_basaibb2` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `gb_x_basaibb2` ;

-- -----------------------------------------------------
-- Table `gb_x_basaibb2`.`sobiratel`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gb_x_basaibb2`.`sobiratel` ;

CREATE TABLE IF NOT EXISTS `gb_x_basaibb2`.`sobiratel` (
  `first_name` VARCHAR(45) NOT NULL,
  `last_name` VARCHAR(45) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `id` INT NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gb_x_basaibb2`.`informant`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gb_x_basaibb2`.`informant` ;

CREATE TABLE IF NOT EXISTS `gb_x_basaibb2`.`informant` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(45) NOT NULL,
  `middle_name` VARCHAR(45) NULL,
  `last_name` VARCHAR(45) NOT NULL,
  `mother_last_name` VARCHAR(45) NULL,
  `year_of_birth` YEAR NULL DEFAULT NULL,
  `place_of_birth` VARCHAR(200) NULL,
  `place_of_living` VARCHAR(200) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `gb_x_basaibb2`.`place`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gb_x_basaibb2`.`place` ;

CREATE TABLE IF NOT EXISTS `gb_x_basaibb2`.`place` (
  `address` VARCHAR(255) NOT NULL,
  `id` CHAR(1) NOT NULL,
  UNIQUE INDEX `address_UNIQUE` (`address` ASC),
  PRIMARY KEY (`id`),
  UNIQUE INDEX `let_UNIQUE` (`id` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gb_x_basaibb2`.`interview`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gb_x_basaibb2`.`interview` ;

CREATE TABLE IF NOT EXISTS `gb_x_basaibb2`.`interview` (
  `id` CHAR(4) NOT NULL,
  `place_id` CHAR(1) NOT NULL,
  `start_date` DATE NOT NULL,
  `record_start_time` TIME NOT NULL,
  `context` VARCHAR(255) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_interview_place1_idx` (`place_id` ASC),
  UNIQUE INDEX `cnt_UNIQUE` (`id` ASC),
  CONSTRAINT `fk_interview_place1`
    FOREIGN KEY (`place_id`)
    REFERENCES `gb_x_basaibb2`.`place` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gb_x_basaibb2`.`device`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gb_x_basaibb2`.`device` ;

CREATE TABLE IF NOT EXISTS `gb_x_basaibb2`.`device` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(45) NOT NULL,
  `title` VARCHAR(50) NOT NULL COMMENT 'Обычно даются прозвища птиц',
  `tech_name` VARCHAR(60) NOT NULL,
  `inv_no` VARCHAR(45) NULL,
  `sobiratel_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `title_UNIQUE` (`title` ASC),
  UNIQUE INDEX `inv_no_UNIQUE` (`inv_no` ASC),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_device_sobiratel1_idx` (`sobiratel_id` ASC),
  CONSTRAINT `fk_device_sobiratel1`
    FOREIGN KEY (`sobiratel_id`)
    REFERENCES `gb_x_basaibb2`.`sobiratel` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gb_x_basaibb2`.`record`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gb_x_basaibb2`.`record` ;

CREATE TABLE IF NOT EXISTS `gb_x_basaibb2`.`record` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `device_id` INT NOT NULL,
  `path` VARCHAR(100) NOT NULL,
  `interview_id` CHAR(4) NOT NULL,
  PRIMARY KEY (`id`, `interview_id`),
  INDEX `fk_record_device1_idx` (`device_id` ASC),
  UNIQUE INDEX `path_UNIQUE` (`path` ASC),
  INDEX `fk_record_interview1_idx` (`interview_id` ASC),
  CONSTRAINT `fk_captured_by`
    FOREIGN KEY (`device_id`)
    REFERENCES `gb_x_basaibb2`.`device` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_record_interview1`
    FOREIGN KEY (`interview_id`)
    REFERENCES `gb_x_basaibb2`.`interview` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gb_x_basaibb2`.`take`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gb_x_basaibb2`.`take` ;

CREATE TABLE IF NOT EXISTS `gb_x_basaibb2`.`take` (
  `sobiratel_id` INT NOT NULL,
  `interview_id` CHAR(4) NOT NULL,
  PRIMARY KEY (`sobiratel_id`, `interview_id`),
  INDEX `fk_sobiratel_has_interview_interview1_idx` (`interview_id` ASC),
  INDEX `fk_sobiratel_has_interview_sobiratel1_idx` (`sobiratel_id` ASC),
  CONSTRAINT `fk_sobiratel_has_interview_sobiratel1`
    FOREIGN KEY (`sobiratel_id`)
    REFERENCES `gb_x_basaibb2`.`sobiratel` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sobiratel_has_interview_interview1`
    FOREIGN KEY (`interview_id`)
    REFERENCES `gb_x_basaibb2`.`interview` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gb_x_basaibb2`.`give`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gb_x_basaibb2`.`give` ;

CREATE TABLE IF NOT EXISTS `gb_x_basaibb2`.`give` (
  `informant_id` INT NOT NULL,
  `interview_id` CHAR(4) NOT NULL,
  PRIMARY KEY (`informant_id`, `interview_id`),
  INDEX `fk_informant_has_interview_interview1_idx` (`interview_id` ASC),
  INDEX `fk_informant_has_interview_informant1_idx` (`informant_id` ASC),
  CONSTRAINT `fk_informant_has_interview_informant1`
    FOREIGN KEY (`informant_id`)
    REFERENCES `gb_x_basaibb2`.`informant` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_informant_has_interview_interview1`
    FOREIGN KEY (`interview_id`)
    REFERENCES `gb_x_basaibb2`.`interview` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

USE `gb_x_basaibb2` ;

-- -----------------------------------------------------
-- Placeholder table for view `gb_x_basaibb2`.`view_informant`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gb_x_basaibb2`.`view_informant` (`'Номер'` INT, `'Фамилия'` INT, `'Имя'` INT, `'Отчество'` INT, `'Год рождения'` INT, `'Место рождения'` INT, `'Место частого пребывания'` INT, `'Изменить'` INT);

-- -----------------------------------------------------
-- Placeholder table for view `gb_x_basaibb2`.`option_device`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gb_x_basaibb2`.`option_device` (`Col_placeholder1` INT);

-- -----------------------------------------------------
-- Placeholder table for view `gb_x_basaibb2`.`option_interview`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gb_x_basaibb2`.`option_interview` (`CONCAT('<option value=',id,'>',start_date,"</option>")` INT);

-- -----------------------------------------------------
-- Placeholder table for view `gb_x_basaibb2`.`view_interview`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gb_x_basaibb2`.`view_interview` (`'Номер'` INT, `'Дата интервью'` INT, `'Начало записи'` INT, `'Информанты'` INT, `'Собиратели'` INT, `'Обстоятельства'` INT, `'Изменение'` INT);

-- -----------------------------------------------------
-- Placeholder table for view `gb_x_basaibb2`.`meetings`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gb_x_basaibb2`.`meetings` (`'Номер'` INT, `'Информант'` INT, `'Год рождения'` INT, `'Место рождения'` INT, `'Место частого пребывания'` INT, `'Собиратели'` INT);

-- -----------------------------------------------------
-- Placeholder table for view `gb_x_basaibb2`.`interview_file_title`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gb_x_basaibb2`.`interview_file_title` (`'Номер'` INT, `'Название папки'` INT);

-- -----------------------------------------------------
-- View `gb_x_basaibb2`.`view_informant`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `gb_x_basaibb2`.`view_informant` ;
DROP TABLE IF EXISTS `gb_x_basaibb2`.`view_informant`;
USE `gb_x_basaibb2`;
CREATE  OR REPLACE VIEW view_informant AS
select 
  id as 'Номер',
  last_name as 'Фамилия',
  first_name as 'Имя',
  middle_name as 'Отчество',
  year_of_birth as 'Год рождения',
  place_of_birth as 'Место рождения',
  place_of_living as 'Место частого пребывания',
  concat('<a href=?p=add_informant&update_id=',id,'>Изменить</a>') as 'Изменить'
from informant;

-- -----------------------------------------------------
-- View `gb_x_basaibb2`.`option_device`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `gb_x_basaibb2`.`option_device` ;
DROP TABLE IF EXISTS `gb_x_basaibb2`.`option_device`;
USE `gb_x_basaibb2`;
CREATE  OR REPLACE VIEW `option_device` AS
select CONCAT('<option value=',device.id,'>',device.title," (", device.type, ")</option>") AS 'Col_placeholder1'  from device
order by device.title;


-- -----------------------------------------------------
-- View `gb_x_basaibb2`.`option_interview`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `gb_x_basaibb2`.`option_interview` ;
DROP TABLE IF EXISTS `gb_x_basaibb2`.`option_interview`;
USE `gb_x_basaibb2`;
CREATE  OR REPLACE VIEW `option_interview` AS
select CONCAT('<option value=',id,'>',start_date,"</option>") from interview;


-- -----------------------------------------------------
-- View `gb_x_basaibb2`.`view_interview`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `gb_x_basaibb2`.`view_interview` ;
DROP TABLE IF EXISTS `gb_x_basaibb2`.`view_interview`;
USE `gb_x_basaibb2`;
create  OR REPLACE view view_interview as
select 
  i.id as 'Номер',  
  i.start_date as 'Дата интервью',
  i.record_start_time as 'Начало записи',
  group_concat(distinct 
    "<a href='?l=view_informant&col=Номер&val=",inf.id,"'>",
    inf.last_name,' ',
    substring(inf.first_name,1,1),'.',
    substring(inf.middle_name,1,1),'.',
    IF(ISNULL(inf.year_of_birth),'',concat('(',inf.year_of_birth,' г.р.)')), "</a>"
    order by inf.last_name 
    ASC SEPARATOR ', ') as 'Информанты',
  group_concat(distinct 
    sob.last_name,' ',
    substring(sob.first_name,1,1),'.' 
    order by sob.last_name SEPARATOR ', ') as 'Собиратели',
  i.context as 'Обстоятельства',
  concat("<a href='?p=update_interview&update_id=",i.id,"'>Изменить</a>") as 'Изменение'
from
    interview as i,
  informant as inf,
  sobiratel as sob,
    give as g,
  take as t
where
    (inf.id = g.informant_id
        and i.id = g.interview_id
and i.id = t.interview_id
and sob.id = t.sobiratel_id)
group by i.id;

-- -----------------------------------------------------
-- View `gb_x_basaibb2`.`meetings`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `gb_x_basaibb2`.`meetings` ;
DROP TABLE IF EXISTS `gb_x_basaibb2`.`meetings`;
USE `gb_x_basaibb2`;
-- BUG имя информанта съезжает в левую колонку
CREATE  OR REPLACE VIEW `meetings` AS
select 
  group_concat(distinct 
    i.id
    order by i.id DESC separator ', ') as 'Номер',  
  concat("<a href='?l=view_informant&col=Номер&val=",inf.id,"'>",
    inf.last_name,' ',
    inf.first_name,' ', 
    inf.middle_name, "</a>") as 'Информант',
  inf.year_of_birth as 'Год рождения',
  inf.place_of_birth as 'Место рождения',
  inf.place_of_living as 'Место частого пребывания',
  group_concat(distinct sob.last_name,' ',
    substring(sob.first_name,1,1),'.' 
    order by sob.last_name ASC separator ',<br>') as 'Собиратели'
from
    interview as i,
  informant as inf,
  sobiratel as sob,
    give as g,
  take as t
where
    (inf.id = g.informant_id
        and i.id = g.interview_id
and i.id = t.interview_id
and sob.id = t.sobiratel_id)
group by inf.id 
order by inf.last_name ASC;

-- -----------------------------------------------------
-- View `gb_x_basaibb2`.`interview_file_title`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `gb_x_basaibb2`.`interview_file_title` ;
DROP TABLE IF EXISTS `gb_x_basaibb2`.`interview_file_title`;
USE `gb_x_basaibb2`;
CREATE  OR REPLACE VIEW `interview_file_title` AS
select 
  i.id as 'Номер',
  concat(
  i.id,' ' ,
  i.start_date,' ' , 
  inf.last_name,' ',
  substring(inf.first_name,1,1),'.',
  substring(inf.middle_name,1,1),'., ',
  sob.last_name,' ',
  substring(sob.first_name,1,1),'.') as 'Название папки'
from
    interview as i,
  informant as inf,
  sobiratel as sob,
    give as g,
  take as t
where
    (inf.id = g.informant_id
        and i.id = g.interview_id
and i.id = t.interview_id
and sob.id = t.sobiratel_id)
group by i.id desc;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `gb_x_basaibb2`.`place`
-- -----------------------------------------------------
START TRANSACTION;
USE `gb_x_basaibb2`;
INSERT INTO `gb_x_basaibb2`.`place` (`address`, `id`) VALUES ('село Чаваньга Терского района Мурманской области', 'Ч');
INSERT INTO `gb_x_basaibb2`.`place` (`address`, `id`) VALUES ('село Варзуга Терского района Мурманской области', 'В');
INSERT INTO `gb_x_basaibb2`.`place` (`address`, `id`) VALUES ('село Кузомень Терского района Мурманской области', 'К');

COMMIT;

