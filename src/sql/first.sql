CREATE DATABASE hospital;

CREATE TABLE diseases
(
    id          	INT UNSIGNED  AUTO_INCREMENT NOT NULL PRIMARY KEY,
    name            UNIQUE VARCHAR
);

INSERT INTO diseases (name)
VALUES ('firstdiseases'), ('seconddiseases'), ('thirddiseases');

CREATE TABLE medicines
(
    id                      INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
    name                    VARCHAR(50) NOT NULL,
    amount			        INT, NOT NULL,
    diseases_id             INT UNSIGNED NOT NULL,
    FOREIGN KEY (diseases_id) REFERENCES diseases(id)
);

INSERT INTO medicines(name, amount, diseasesId)
VALUES ('firstMedicinesa', 50, 3), ('secondMedicinesa', 70, 2), ('thirdMedicinesa', 25, 1);

CREATE TABLE patients
(
    id                    INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
    first_name            VARCHAR(50) NOT NULL,
    last_name              VARCHAR(50) NOT NULL,
    gender                BOOLEAN  NOT NULL,
    medicines_id          INT UNSIGNED NOT NULL,
    FOREIGN KEY (medicinesId) REFERENCES medicines(id)
);

INSERT INTO patients (firstName, lastName, gender, medicinesId)
VALUES ('Marian','Danyliv', 'mal' 1), ('Tanuya','Ivanisha', 'fem' 2), ('Volodia','Danyliv', 'mal' 3);

CREATE TABLE IF NOT EXISTS `diseases_medicines` (
    `diseases_id` INT NOT NULL,
    `medicines_id` INT NOT NULL,
    FOREIGN KEY (`diseases_id`) REFERENCES `diseases`(`id`) ON UPDATE CASCADE ON DELETE CASCADE;
    FOREIGN KEY (`medicines_id`) REFERENCES `medicines`(`id`) ON UPDATE CASCADE ON DELETE CASCADE;
    );

CREATE TABLE IF NOT EXISTS `diseases_patients` (
    `diseases_id` INT NOT NULL,
    `patients_id` INT NOT NULL,
    FOREIGN KEY (`diseases_id`) REFERENCES `diseases`(`id`) ON UPDATE CASCADE ON DELETE CASCADE;
    FOREIGN KEY (`patients_id`) REFERENCES `patients`(`id`) ON UPDATE CASCADE ON DELETE CASCADE;
);
CREATE TABLE IF NOT EXISTS `patients_diseases` (
    `patients_id` INT NOT NULL,
    `diseases_id` INT NOT NULL,
    FOREIGN KEY (`diseases_id`) REFERENCES `diseases`(`id`) ON UPDATE CASCADE ON DELETE CASCADE;
    FOREIGN KEY (`patients_id`) REFERENCES `patients`(`id`) ON UPDATE CASCADE ON DELETE CASCADE;
);

INSERT INTO diseases_medicines (diseases_id, medicines_id)
VALUES (1,2), (2,3), (3,1), (3,2);
INSERT INTO diseases_patients (diseases_id, patients_id)
VALUES (1,2), (2,3), (3,1), (3,2);
INSERT INTO patients_diseases (patients_id, diseases_id)
VALUES (1,2), (2,3), (3,1), (3,2);