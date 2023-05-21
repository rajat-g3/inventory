CREATE TABLE `inventorydb`.`items` (
  `id` INT NOT NULL,
  `item` VARCHAR(45) NULL,
  `item_type` INT NULL,
  PRIMARY KEY (`id`));


INSERT INTO `inventorydb`.`items` (`id`, `item`, `item_type`) VALUES ('1', 'Pen', '1');
INSERT INTO `inventorydb`.`items` (`id`, `item`, `item_type`) VALUES ('2', 'Printer', '2');
INSERT INTO `inventorydb`.`items` (`id`, `item`, `item_type`) VALUES ('3', 'Marker', '1');
INSERT INTO `inventorydb`.`items` (`id`, `item`, `item_type`) VALUES ('4', 'Scanner', '2');
INSERT INTO `inventorydb`.`items` (`id`, `item`, `item_type`) VALUES ('5', 'Clear Tape', '1');
INSERT INTO `inventorydb`.`items` (`id`, `item`, `item_type`) VALUES ('6', 'Standing Table', '2');
INSERT INTO `inventorydb`.`items` (`id`, `item`, `item_type`) VALUES ('7', 'Shredder', '2');
INSERT INTO `inventorydb`.`items` (`id`, `item`, `item_type`) VALUES ('8', 'Thumbtack', '1');
INSERT INTO `inventorydb`.`items` (`id`, `item`, `item_type`) VALUES ('9', 'Paper Clip', '1');
INSERT INTO `inventorydb`.`items` (`id`, `item`, `item_type`) VALUES ('10', 'A4 Sheet', '1');
INSERT INTO `inventorydb`.`items` (`id`, `item`, `item_type`) VALUES ('11', 'Notebook', '1');
INSERT INTO `inventorydb`.`items` (`id`, `item`, `item_type`) VALUES ('12', 'Chair', '3');


CREATE TABLE `inventorydb`.`requests` (
  `req_id` INT NOT NULL AUTO_INCREMENT,
  `requested_by` VARCHAR(45) NULL,
  `requested_on` DATE NULL,
  `ordered_on` DATE NULL,
  `items` VARCHAR(45) NULL ,
  PRIMARY KEY (`req_id`)) ;


CREATE TABLE `inventorydb`.`itemType` (
  `id` INT NOT NULL,
  `value` VARCHAR(45) NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `inventorydb`.`itemType` (`id`, `value`) VALUES ('1', 'Office Supply');
INSERT INTO `inventorydb`.`itemType` (`id`, `value`) VALUES ('2', 'Equipment');
INSERT INTO `inventorydb`.`itemType` (`id`, `value`) VALUES ('3', 'Furniture');

CREATE TABLE `inventorydb`.`summary` (
  `req_id` INT NOT NULL AUTO_INCREMENT,
  `requested_by` VARCHAR(45) NULL,
  `ordered_on` VARCHAR(45) NULL,
  `items` VARCHAR(45) NULL,
  PRIMARY KEY (`req_id`));
