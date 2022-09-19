SELECT name, amount FROM medicines WHERE amount > 25 ORDER BY amount;

SELECT COUNT(name) FROM medicines WHERE amount > 50;

SELECT name FROM  diseases
UNION
SELECT name FROM medicines

SELECT name, amount FROM medicines
WHERE amount > (SELECT AVG(amount) FROM medicines) ORDER BY amount;

SELECT patients.first_name, patients.last_name AS patients, medicines.name, medicines.amount AS medicines, diseases.name AS diseases
FROM models
         LEFT JOIN diseases_medicines ON medicines.id = diseases_medicines.medicines_id
         LEFT JOIN diseases_medicines ON diseases.id = diseases_medicines.diseases_id
ORDER BY medicines.name;