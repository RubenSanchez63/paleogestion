-- 1. Crear la Base de Datos
CREATE DATABASE IF NOT EXISTS PaleoGestion CHARACTER SET utf8mb4 COLLATE utf8mb4_es_0900_ai_ci;
USE PaleoGestion;

-- 2. Crear la tabla 'Esqueleto' (Entidad Padre)
-- Contiene la información taxonómica y contextual general.
CREATE TABLE Esqueleto (
    idEsq INT AUTO_INCREMENT PRIMARY KEY,
    especie VARCHAR(100) NOT NULL,
    periodo VARCHAR(100) NOT NULL,
    lugar VARCHAR(150),
    descripcion TEXT, 
    fechaEsq DATE,
    estadoEsq VARCHAR(50) NOT NULL DEFAULT 'En Almacén' -- Estados: En Almacén, En Exposición, Bajo Estudio
)
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_es_0900_ai_ci;

-- 3. Crear la tabla 'Fósil' (Entidad Hija/Débil)
-- Contiene la información de la pieza física específica.
CREATE TABLE Fosil (
    idFos INT AUTO_INCREMENT PRIMARY KEY,
    parte VARCHAR(100) NOT NULL,
    fechaFos DATE,
    estadoFos VARCHAR(50) NOT NULL DEFAULT 'En Almacén', -- Estados: En Almacén, En Exposición, Bajo Estudio
    idEsq INT NOT NULL, -- Clave Foránea para la relación 'forma_parte_de'
    
    -- Definición de la Relación:
    CONSTRAINT fk_fosil_esqueleto 
        FOREIGN KEY (idEsq) 
        REFERENCES Esqueleto(idEsq)
        ON DELETE CASCADE 
        ON UPDATE CASCADE
)
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_es_0900_ai_ci;

-- 4. Crear la tabla 'Usuario' (Entidad a parte)
-- Contiene la información de los usuarios.
CREATE TABLE Usuario (
    idUsu INT AUTO_INCREMENT PRIMARY KEY,
    user varchar(50) NOT NULL,
    passwordHash varchar(255) NOT NULL
)
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_es_0900_ai_ci;

-- ==========================================
-- DATOS DE EJEMPLO (SEEDING)
-- ==========================================

-- EJEMPLO 1: Un T-Rex incompleto bajo estudio
INSERT INTO Esqueleto (especie, periodo, lugar, descripcion, fechaEsq, estadoEsq) 
VALUES ('Tyrannosaurus Rex', 'Cretácico Superior', 'Montana, USA', 'Espécimen joven, faltan extremidades superiores.', '2023-05-12', 'Bajo Estudio');

-- Recuperamos el ID del T-Rex (asumimos que es 1) e insertamos sus partes
INSERT INTO Fosil (parte, fechaFos, estadoFos, idEsq) VALUES 
('Fémur Izquierdo', '2023-05-12', 'Bajo Estudio', 1),
('Mandíbula Inferior', '2023-05-14', 'Bajo Estudio', 1),
('Diente (Canino)', '2023-05-14', 'Bajo Estudio', 1);


-- EJEMPLO 2: Un Mamut completo en exposición
INSERT INTO Esqueleto (especie, periodo, lugar, descripcion, fechaEsq, estadoEsq) 
VALUES ('Mammuthus primigenius', 'Pleistoceno', 'Siberia, Rusia', 'Mamut lanudo en excelente estado de conservación.', '2020-08-20', 'En Exposición');

-- Recuperamos el ID del Mamut (asumimos que es 2)
INSERT INTO Fosil (parte, fechaFos, estadoFos, idEsq) VALUES 
('Cráneo completo', '2020-08-20', 'En Exposición', 2),
('Colmillo Derecho', '2020-08-21', 'En Exposición', 2),
('Colmillo Izquierdo', '2020-08-21', 'En Exposición', 2);


-- EJEMPLO 3: Un Triceratops recién llegado al almacén
INSERT INTO Esqueleto (especie, periodo, lugar, descripcion, fechaEsq, estadoEsq) 
VALUES ('Triceratops horridus', 'Cretácico', 'Dakota del Norte, USA', 'Restos parciales encontrados en lecho de río.', '2024-01-10', 'En Almacén');

-- Recuperamos el ID del Triceratops (asumimos que es 3)
INSERT INTO Fosil (parte, fechaFos, estadoFos, idEsq) VALUES 
('Cuerno Nasal', '2024-01-11', 'En Almacén', 3),
('Vertebra Cervical', '2024-01-12', 'En Almacén', 3);

-- EJEMPLO usuario

INSERT INTO Usuario (user, passwordHash)
VALUES ('admin', '$2y$12$d46rc94ImUPB/23SAi5uo.ktYA4LiG.WA.q/.4Z58HpYAeUON/6z.'), -- La contraseña es admin
       ('a', '$2y$12$ct.tAmraduQUWgw0Gl1urOUvhfYxOwE4uwJmJvD5huqJuRzJPXLFG') -- La contraseña es a
