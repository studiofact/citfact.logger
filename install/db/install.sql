CREATE TABLE IF NOT EXISTS b_citfact_logger (
  ID int(11) unsigned NOT NULL AUTO_INCREMENT,
  CHANNEL varchar(255) NOT NULL,
  LEVEL int(11) NOT NULL,
  MESSAGE text NOT NULL,
  TIME int(11) unsigned,
  PRIMARY KEY (ID)
);