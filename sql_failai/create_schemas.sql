# Sukuria duomenų bazę pavadinimu 'akademija'
CREATE DATABASE akademija;

# Sukuria vartotoją jonas su spaltažodžiu mano_pass
CREATE USER 'tautvydas'@'%' IDENTIFIED BY 'slaptazodis';
# Vartotojui jonas suteikia visas teises redaguoti DB jono_db
GRANT ALL PRIVILEGES ON akademija.* TO 'tautvydas'@'%';
# Patvirtina/išsaugo privilegijų/teisių pakeitimus
FLUSH PRIVILEGES;

# Nustato kad toliau naudosimės 'akademija' duomenų baze
USE akademija;

# Kuriama adresų lentelė
create table addresses
(
    id          INT NOT NULL AUTO_INCREMENT,
    country_iso VARCHAR(50),
    city        VARCHAR(50),
    street      VARCHAR(50),
    postcode    VARCHAR(50),
    PRIMARY KEY (id)
);

# Kuriama šalių lentelė
create table countries
(
    id    INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(50),
    iso   VARCHAR(50),
    PRIMARY KEY (id)
);

# Kuriama studentų grupių lentelė
create table `groups`
(
    id         INT NOT NULL AUTO_INCREMENT,
    title      VARCHAR(10), # 10 - DĖMESIO: simbolių limitas ;)
    address_id INT,
    state      INT,
    PRIMARY KEY (id)
);

# Kuriama ryšiams nurodyti tarp asmenų ir grupių lentelė
create table person2gruop
(
    id        INT NOT NULL AUTO_INCREMENT,
    person_id INT,
    groups_id INT,
    PRIMARY KEY (id)
);

# Kuriama asmenų lentelė
create table persons
(
    id         INT NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(50),
    last_name  VARCHAR(50),
    email      VARCHAR(50),
    code       VARCHAR(50),
    phone      VARCHAR(50),
    address_id INT,
    PRIMARY KEY (id)
);

# Kuriama Būsenų lentelė
create table states
(
    id    INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(9),
    type  VARCHAR(7),
    PRIMARY KEY (id)
);

# Kuriama vartotojų kurie gali jungtis į sistemą lentelė
create table users
(
    id        INT NOT NULL AUTO_INCREMENT,
    person_id INT,
    password  VARCHAR(50),
    name      VARCHAR(50),
    state     INT,
    PRIMARY KEY (id)
);