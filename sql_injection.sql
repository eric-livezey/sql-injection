CREATE DATABASE sql_injection;
USE sql_injection;

CREATE TABLE user (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  email VARCHAR(32) NOT NULL,
  password VARCHAR(100) NOT NULL,
  first_name VARCHAR(30) NOT NULL,
  last_name VARCHAR(30) DEFAULT NULL,
  dob DATE NOT NULL,
  gender VARCHAR(6) NOT NULL,
  salary INT DEFAULT 0,
  address VARCHAR(100) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE INDEX email_UNIQUE (email ASC)
);


INSERT INTO user (email, password, first_name, last_name, dob, gender, salary, address) VALUES
         ("admin@email.com", /* sha256 hash of "change_me" */ "fb86fb757d1241d512865070e05ccb5d17dfaa11a4b2ca04b89bacad17530ad4", "Admin", NULL, "2000-01-01", "male", 250000, "123 Admin Lane, Boston, MA"),
         ("eric@email.com", /* sha256 hash of "password" */ "5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8", "Eric", "Livezey", "2003-07-22", "male", 80000, "122 Anonymous Lane, Boston MA"),
         ("john@email.com", /* sha256 hash of "john_password" */ "3e65b8141040e60975f6f54ec0ffc944971a3d3acb0271c36133332f7f4c7d1a", "John", "Doe", "1993-09-09", "male", 75000, "123 Anonymous Lane, Boston MA"),
         ("jane@email.com", /* sha256 hash of "jane_password" */ "faa1bf537345a655ff3124698941155b2d1dc2e439e64c0ec45c754e27730089", "Jane", "Doe", "1996-02-23", "female", 90000, "124 Anonymous Lane, Boston MA");

SELECT * FROM user;