CREATE DATABASE dialisi;

USE dialisi;

CREATE USER 'antonios'@'%';

GRANT ALL PRIVILEGES ON dialisi.* TO 'antonios'@'%' WITH GRANT OPTION;

CREATE TABLE USER(
  user_id  INT UNSIGNED NOT NULL AUTO_INCREMENT,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(40) NOT NULL,
  email    VARCHAR(40) NOT NULL,

  PRIMARY KEY(user_id),

  CONSTRAINT email_unique UNIQUE (email)
);


CREATE TABLE FILE(
  file_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  original_file_name VARCHAR(50) NOT NULL, #This is the original file name, the vcf_read script doesn't keep the original file name somewhere tho, should we add something to the vcf_read script?
  file_name VARCHAR(50) NOT NULL,
  user_id INT UNSIGNED NOT NULL,
  ts TIMESTAMP, #Automatically updates when a new file is uploaded

  PRIMARY KEY (file_id),

  CONSTRAINT user_file_id
   FOREIGN KEY (user_id) REFERENCES USER (user_id)
   ON DELETE CASCADE
   ON UPDATE RESTRICT
);


CREATE TABLE ANALYSES(
  analysis_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  user_id INT UNSIGNED NOT NULL,
  file_id_1 INT UNSIGNED NOT NULL,
  file_id_2 INT UNSIGNED NOT NULL,
  analysis_type VARCHAR(40) NOT NULL,
  output_file_name VARCHAR(40) NOT NULL,
  #I didn't use the timestamp data type in this case because we need both the starting and ending time of the analysis which I found would be easy to do with a python function.
  start_time VARCHAR(19), #timestamp length from python is 19
  end_time VARCHAR(19),

  PRIMARY KEY(analysis_id),
  CONSTRAINT user_to_analyses
   FOREIGN KEY (user_id) REFERENCES USER (user_id),

  CONSTRAINT file_1_to_analyses
   FOREIGN KEY (file_id_1) REFERENCES FILE (file_id),

  CONSTRAINT file_2_to_analyses
   FOREIGN KEY (file_id_2) REFERENCES FILE (file_id),

  CONSTRAINT uniq_dboutfilename UNIQUE (output_file_name)

);

CREATE TABLE VCF(
  line_id     INT UNSIGNED NOT NULL AUTO_INCREMENT,
  file_id     INT UNSIGNED NOT NULL,
  chromosome  INT UNSIGNED NOT NULL,
  position    INT UNSIGNED NOT NULL,
  id          VARCHAR(50) NOT NULL,
  reference   VARCHAR(50) NOT NULL,
  alternative VARCHAR(50) NOT NULL,
  quality     VARCHAR(50) NOT NULL,
  filter      VARCHAR(50) NOT NULL,
  information VARCHAR(50) NOT NULL,

  PRIMARY KEY (line_id),

  CONSTRAINT file_vcf_id
    FOREIGN KEY (file_id) REFERENCES FILE (file_id)
    ON DELETE CASCADE
    ON UPDATE RESTRICT
);


CREATE TABLE JOB(
   job_id       INT NOT NULL AUTO_INCREMENT,
   job_name     VARCHAR(50) NOT NULL,
   job_creator  VARCHAR(40) NOT NULL,
   vcf_1_id     INT UNSIGNED NOT NULL,
   vcf_2_id     INT UNSIGNED NOT NULL,
   status       VARCHAR(40),

   PRIMARY KEY ( job_id ),

   CONSTRAINT vcf_file1_id
    FOREIGN KEY (vcf_1_id) REFERENCES VCF (file_id)
    ON DELETE CASCADE
    ON UPDATE RESTRICT,

   CONSTRAINT vcf_file2_id
    FOREIGN KEY (vcf_2_id) REFERENCES VCF (file_id)
    ON DELETE CASCADE
    ON UPDATE RESTRICT
);
