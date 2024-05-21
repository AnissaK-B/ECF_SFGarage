CREATE TABLE car (
    id INT AUTO_INCREMENT PRIMARY KEY,
    marque VARCHAR(255) NOT NULL,
    mileage INT NOT NULL,
    year INT NOT NULL,
    image VARCHAR(255) NULL,
    price INT NOT NULL,
    imageName VARCHAR(255) NULL,
    updatedAt DATETIME NULL
);


// ajout de véhiculeINSERT INTO car (marque, mileage, year, image, price, imageName, updatedAt) VALUES
('Toyota', 50000, 2020, 'toyota.jpg', 25000, 'Toyota_image.jpg', NOW()),
('Tesla', 550000, 2020, 'tesla.jpg', 25000, 'Tesla_image.jpg', NOW());



ALTER TABLE car
ADD COLUMN user_id INT,
ADD CONSTRAINT FK_user_id FOREIGN KEY (user_id) REFERENCES user(id);



CREATE TABLE formulaire (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    tel VARCHAR(255) NOT NULL,
    message TEXT NOT NULL
);


// ajout de message
INSERT INTO formulaire (email, name, lastname, tel, message) 
VALUES ('essai@hotmail.com', 'Caroline', 'Caroline', '1234567890', 'Je souhaiterai prendre rdv avec un de vos conseillers.');

ALTER TABLE formulaire
MODIFY COLUMN email VARCHAR(255) NOT NULL;

CREATE TABLE schedule (
    id INT AUTO_INCREMENT PRIMARY KEY,
    day_of_week VARCHAR(255) NOT NULL,
    morning_hours VARCHAR(255) NOT NULL,
    evening_hours VARCHAR(255) NOT NULL,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES user(id)
);

// ajout d'horaire d'ouverture et fermeture
INSERT INTO schedule (day_of_week, morning_hours, evening_hours, user_id) 
VALUES (12, 'Monday', '9:00 AM - 12:00 PM', '1:00 PM - 5:00 PM' ;

// contrainte table schedule
ALTER TABLE schedule
ADD CONSTRAINT fk_user_id
FOREIGN KEY (user_id)
REFERENCES user(id);



CREATE TABLE service (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    text TEXT NOT NULL
);

// ajout de titre et description
INSERT INTO service (title, text) VALUES 
('Carrosserie', 'Vous avez eu un accident ou une rayure sur votre voiture ? Vous cherchez un garage de confiance pour réparer votre carrosserie ? Ne cherchez plus, vous êtes au bon endroit ! Chez V.Parrot, nous vous offrons un service carrosserie de qualité, rapide et à des prix compétitifs. Nous disposons d’un matériel moderne et d’une équipe de professionnels qualifiés, capables de réparer tous les types de dommages sur votre véhicule....'),
('Mécanique', 'Vous cherchez un garage de confiance pour l'entretien et la réparation de votre voiture ? Ne cherchez plus, vous avez trouvé le bon endroit ! Chez Garage Dupont, nous vous offrons un service de qualité, rapide et à des prix compétitifs. Que ce soit pour une vidange, un changement de pneus, une révision ou une réparation plus complexe, nous avons les compétences et le matériel nécessaires pour prendre soin de votre véhicule. Nous travaillons avec les meilleures marques de pièces détachées et nous vous garantissons une garantie sur toutes nos interventions.'),


ALTER TABLE service
MODIFY COLUMN title VARCHAR(255) NOT NULL;

CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(180) UNIQUE NOT NULL,
    roles JSON NOT NULL,
    password VARCHAR(255) NOT NULL
);
//ajout d'un user
INSERT INTO user (email, roles, password) VALUES 
('ester@yahoo.com', '["ROLE_USER"]', 'password123'),
('jane@example.com', '["ROLE_USER"]', 'admin123'),
('test@test.com', '["ROLE_ADMIN"]', 'test');

// modifier la table user
ALTER TABLE user
MODIFY COLUMN password VARCHAR(255) NOT NULL;



CREATE TABLE testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    comment TEXT NOT NULL,
    rate SMALLINT NOT NULL,
    approved BOOLEAN NOT NULL,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES user(id)
);
// ajout de temoignage
INSERT INTO testimonials (name, comment, rate, approved, user_id) VALUES 
('Laurence', 'Service Impeccable, je recommande ce garage', 5, true, 1),
('Corinne', 'Réparation faite dans les regles de l'art', 4, true, 2),
('Karine', 'Le langage parrot est une belle découverte', 3, true, 3);

ALTER TABLE testimonials
ADD CONSTRAINT fk_user_id
FOREIGN KEY (user_id) REFERENCES user(id);
