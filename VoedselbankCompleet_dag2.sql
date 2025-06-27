-- VoedselbankCompleet_dag2.sql
-- Complete Database script voor Voedselbank Maaskantje (MySQL/PhpMyAdmin)
-- Inclusief Leveranciers en Klanten functionaliteit
-- Datum: 27-06-2025

-- Database aanmaken
CREATE DATABASE IF NOT EXISTS voedselbank_maaskantje CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE voedselbank_maaskantje;

-- Drop tables if they exist (in reverse order due to foreign keys)
DROP TABLE IF EXISTS pakket_producten;
DROP TABLE IF EXISTS voedselpakketten;
DROP TABLE IF EXISTS leveringsdetails;
DROP TABLE IF EXISTS leveringen;
DROP TABLE IF EXISTS producten;
DROP TABLE IF EXISTS klant_wensen;
DROP TABLE IF EXISTS klanten;
DROP TABLE IF EXISTS productcategorieen;
DROP TABLE IF EXISTS leveranciers;
DROP TABLE IF EXISTS users;

-- ===========================================
-- CORE TABLES
-- ===========================================

-- Tabel: users (voor authenticatie)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('directie', 'magazijnmedewerker', 'vrijwilliger') DEFAULT 'vrijwilliger',
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabel: leveranciers
CREATE TABLE leveranciers (
    leverancier_id INT AUTO_INCREMENT PRIMARY KEY,
    bedrijfsnaam VARCHAR(255) NOT NULL,
    adres VARCHAR(255) NOT NULL,
    contactpersoon_naam VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telefoonnummer VARCHAR(20) NOT NULL,
    eerstvolgende_levering DATETIME NULL,
    actief BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_leveranciers_actief (actief),
    INDEX idx_leveranciers_levering (eerstvolgende_levering)
) ENGINE=InnoDB;

-- Tabel: klanten
CREATE TABLE klanten (
    klant_id INT AUTO_INCREMENT PRIMARY KEY,
    gezinsnaam VARCHAR(255) NOT NULL,
    voornaam VARCHAR(255) NOT NULL,
    achternaam VARCHAR(255) NOT NULL,
    straat VARCHAR(255) NOT NULL,
    huisnummer VARCHAR(10) NOT NULL,
    postcode VARCHAR(10) NOT NULL,
    plaats VARCHAR(255) NOT NULL,
    telefoonnummer VARCHAR(20) NOT NULL,
    email VARCHAR(255) NULL,
    
    -- Gezinssamenstelling
    aantal_volwassenen INT DEFAULT 1,
    aantal_kinderen INT DEFAULT 0,
    aantal_babies INT DEFAULT 0,
    
    -- Status
    actief BOOLEAN DEFAULT TRUE,
    aanmelddatum DATE DEFAULT (CURRENT_DATE),
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_klanten_postcode (postcode),
    INDEX idx_klanten_actief (actief),
    INDEX idx_klanten_gezinsnaam (gezinsnaam)
) ENGINE=InnoDB;

-- Tabel: klant_wensen (specifieke wensen per klant)
CREATE TABLE klant_wensen (
    klant_id INT NOT NULL,
    wens_type ENUM('geen_varkensvlees', 'allergisch_gluten', 'allergisch_pinda', 'allergisch_schaaldieren', 'allergisch_hazelnoten', 'allergisch_lactose', 'allergisch_overig', 'veganistisch', 'vegetarisch') NOT NULL,
    omschrijving TEXT NULL, -- Voor 'allergisch_overig'
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (klant_id, wens_type),
    FOREIGN KEY (klant_id) REFERENCES klanten(klant_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Tabel: productcategorieen
CREATE TABLE productcategorieen (
    categorie_id INT AUTO_INCREMENT PRIMARY KEY,
    omschrijving VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabel: producten
CREATE TABLE producten (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    naam VARCHAR(255) NOT NULL,
    streepjescode VARCHAR(255) UNIQUE NOT NULL,
    aantal_in_voorraad INT DEFAULT 0,
    houdbaar_tot DATE NULL,
    categorie_id INT NOT NULL,
    leverancier_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (categorie_id) REFERENCES productcategorieen(categorie_id) ON DELETE RESTRICT,
    FOREIGN KEY (leverancier_id) REFERENCES leveranciers(leverancier_id) ON DELETE RESTRICT,
    INDEX idx_producten_streepjescode (streepjescode),
    INDEX idx_producten_categorie (categorie_id),
    INDEX idx_producten_voorraad (aantal_in_voorraad),
    INDEX idx_producten_houdbaar (houdbaar_tot)
) ENGINE=InnoDB;

-- Tabel: leveringen
CREATE TABLE leveringen (
    levering_id INT AUTO_INCREMENT PRIMARY KEY,
    leverancier_id INT NOT NULL,
    leveringsdatum DATE NOT NULL,
    status ENUM('gepland', 'onderweg', 'geleverd', 'geannuleerd') DEFAULT 'gepland',
    opmerkingen TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (leverancier_id) REFERENCES leveranciers(leverancier_id) ON DELETE RESTRICT,
    INDEX idx_leveringen_datum (leveringsdatum),
    INDEX idx_leveringen_status (status)
) ENGINE=InnoDB;

-- Tabel: leveringsdetails
CREATE TABLE leveringsdetails (
    levering_id INT NOT NULL,
    product_id INT NOT NULL,
    aantal_geleverd INT NOT NULL,
    vervaldatum DATE NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (levering_id, product_id),
    FOREIGN KEY (levering_id) REFERENCES leveringen(levering_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES producten(product_id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- Tabel: voedselpakketten
CREATE TABLE voedselpakketten (
    pakket_id INT AUTO_INCREMENT PRIMARY KEY,
    pakket_nummer VARCHAR(20) UNIQUE NOT NULL, -- Voor sticker
    klant_id INT NOT NULL,
    samensteldatum DATE NOT NULL,
    uitgiftedatum DATE NULL,
    status ENUM('samengesteld', 'klaar_voor_uitgifte', 'uitgegeven') DEFAULT 'samengesteld',
    opmerkingen TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (klant_id) REFERENCES klanten(klant_id) ON DELETE RESTRICT,
    INDEX idx_pakketten_klant (klant_id),
    INDEX idx_pakketten_datum (samensteldatum),
    INDEX idx_pakketten_status (status)
) ENGINE=InnoDB;

-- Tabel: pakket_producten (welke producten zitten er in een pakket)
CREATE TABLE pakket_producten (
    pakket_id INT NOT NULL,
    product_id INT NOT NULL,
    aantal INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (pakket_id, product_id),
    FOREIGN KEY (pakket_id) REFERENCES voedselpakketten(pakket_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES producten(product_id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ===========================================
-- INSERT TEST DATA (minimaal 5 records per tabel)
-- ===========================================

-- Users (voor authenticatie)
INSERT INTO users (name, email, password, role) VALUES
('Peter Abraham', 'peter@voedselbank.nl', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'directie'),
('Maria Janssen', 'maria@voedselbank.nl', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'magazijnmedewerker'),
('Henk de Vries', 'henk@voedselbank.nl', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'vrijwilliger'),
('Sandra Bakker', 'sandra@voedselbank.nl', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'vrijwilliger'),
('Tom Peters', 'tom@voedselbank.nl', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'magazijnmedewerker');

-- Leveranciers (6 records)
INSERT INTO leveranciers (bedrijfsnaam, adres, contactpersoon_naam, email, telefoonnummer, eerstvolgende_levering, actief) VALUES
('Albert Heijn Distributie', 'Provincialeweg 11, 1506 MA Zaandam', 'Jan de Vries', 'jan.devries@ah.nl', '075-6589741', '2025-07-01 08:00:00', TRUE),
('Jumbo Supermarkten BV', 'Industrieweg 1, 5466 AC Veghel', 'Marie van der Berg', 'marie.vdberg@jumbo.com', '0413-366200', '2025-07-02 10:30:00', TRUE),
('Bakkerij de Korenwolf', 'Hoofdstraat 45, 5421 CV Gemert', 'Piet Bakker', 'info@korenwolf.nl', '0492-361254', '2025-07-03 07:00:00', TRUE),
('Boerderij Verse Groenten', 'Akkerweg 23, 5431 NL Cuijk', 'Anna Groentemaker', 'anna@versegroenten.nl', '0485-123456', '2025-07-04 14:00:00', TRUE),
('Zuivel Coöperatie Limburg', 'Melkweg 12, 6001 AB Weert', 'Henk Melkboer', 'henk@zuivelcoop.nl', '0495-789123', '2025-07-05 09:15:00', TRUE),
('Slagerij van den Berg', 'Marktplein 8, 5401 GN Uden', 'Willem van den Berg', 'willem@slagerijvandenberg.nl', '0413-987654', '2025-07-06 11:00:00', FALSE);

-- Klanten (8 records - verschillende gezinssamenstellingen)
INSERT INTO klanten (gezinsnaam, voornaam, achternaam, straat, huisnummer, postcode, plaats, telefoonnummer, email, aantal_volwassenen, aantal_kinderen, aantal_babies, actief, aanmelddatum) VALUES
('Familie Jansen', 'Jan', 'Jansen', 'Dorpsstraat', '12', '5421AB', 'Gemert', '0492-123456', 'jan.jansen@email.nl', 2, 2, 0, TRUE, '2025-01-15'),
('Alleenstaande Peters', 'Maria', 'Peters', 'Kerkstraat', '8', '5421CD', 'Gemert', '0492-234567', 'maria.peters@email.nl', 1, 0, 0, TRUE, '2025-02-10'),
('Familie de Wit', 'Peter', 'de Wit', 'Schoolstraat', '25', '5421EF', 'Gemert', '0492-345678', 'peter.dewit@email.nl', 2, 3, 1, TRUE, '2025-01-28'),
('Familie Bakker', 'Sandra', 'Bakker', 'Molenstraat', '15', '5422GH', 'Gemert', '0492-456789', NULL, 1, 2, 0, TRUE, '2025-03-05'),
('Bejaarde Smit', 'Gerrit', 'Smit', 'Bosstraat', '3', '5423IJ', 'Gemert', '0492-567890', 'gerrit.smit@email.nl', 2, 0, 0, TRUE, '2025-02-20'),
('Familie Groot', 'Linda', 'Groot', 'Parkstraat', '42', '5424KL', 'Gemert', '0492-678901', 'linda.groot@email.nl', 2, 1, 1, TRUE, '2025-04-01'),
('Familie van Dam', 'Kees', 'van Dam', 'Nieuwstraat', '7', '5425MN', 'Gemert', '0492-789012', 'kees.vandam@email.nl', 2, 4, 0, TRUE, '2025-03-15'),
('Inactieve Klant', 'Ex', 'Klant', 'Wegstraat', '99', '5426OP', 'Gemert', '0492-890123', NULL, 1, 0, 0, FALSE, '2024-12-01');

-- Klant wensen
INSERT INTO klant_wensen (klant_id, wens_type, omschrijving) VALUES
(1, 'geen_varkensvlees', NULL),
(1, 'allergisch_lactose', NULL),
(3, 'vegetarisch', NULL),
(4, 'allergisch_gluten', NULL),
(4, 'allergisch_overig', 'Allergisch voor soja'),
(6, 'veganistisch', NULL),
(7, 'geen_varkensvlees', NULL);

-- Productcategorieen (9 records - alle categorieën uit de casus)
INSERT INTO productcategorieen (omschrijving) VALUES
('Aardappelen, groente, fruit'),
('Kaas, vleeswaren'),
('Zuivel, plantaardig en eieren'),
('Bakkerij en banket'),
('Frisdrank, sappen, koffie en thee'),
('Pasta, rijst en wereldkeuken'),
('Soepen, sauzen, kruiden en olie'),
('Snoep, koek, chips en chocolade'),
('Baby, verzorging en hygiëne');

-- Producten (12 records)
INSERT INTO producten (naam, streepjescode, aantal_in_voorraad, houdbaar_tot, categorie_id, leverancier_id) VALUES
('Witte brood', '8710398123456', 25, '2025-06-29', 4, 3),
('Verse melk 1L', '8712345678901', 40, '2025-07-05', 3, 5),
('Bananen 1kg', '8712100001234', 30, '2025-07-02', 1, 4),
('Gouda kaas jong belegen', '8711234567890', 15, '2025-08-15', 2, 1),
('Spaghetti 500g', '8710123456789', 50, '2025-12-31', 6, 2),
('Appelsap 1L', '8712345001234', 20, '2025-09-30', 5, 1),
('Tomatensoep blik', '8711111222333', 35, '2026-03-15', 7, 2),
('Aardappelen 2kg', '8713333444555', 60, '2025-07-10', 1, 4),
('Koffie gemalen 500g', '8714444555666', 18, '2026-01-15', 5, 1),
('Luiers maat 4', '8715555666777', 12, '2027-12-31', 9, 2),
('Chocoladereep', '8716666777888', 45, '2025-11-30', 8, 1),
('Olijfolie 500ml', '8717777888999', 22, '2026-06-30', 7, 3);

-- Leveringen (6 records)
INSERT INTO leveringen (leverancier_id, leveringsdatum, status, opmerkingen) VALUES
(1, '2025-06-25', 'geleverd', 'Levering verliep soepel'),
(2, '2025-06-26', 'geleverd', 'Enkele producten beschadigd, rest OK'),
(3, '2025-06-27', 'onderweg', 'Verwacht rond 14:00'),
(4, '2025-06-28', 'gepland', 'Wekelijkse groentlevering'),
(5, '2025-06-29', 'gepland', 'Extra zuivelproducten besteld'),
(1, '2025-06-30', 'gepland', 'Reguliere weeklevering');

-- Leveringsdetails (10 records)
INSERT INTO leveringsdetails (levering_id, product_id, aantal_geleverd, vervaldatum) VALUES
(1, 4, 10, '2025-08-15'),
(1, 6, 15, '2025-09-30'),
(1, 9, 8, '2026-01-15'),
(2, 5, 25, '2025-12-31'),
(2, 7, 20, '2026-03-15'),
(2, 10, 6, '2027-12-31'),
(3, 1, 30, '2025-06-29'),
(3, 12, 10, '2026-06-30'),
(4, 3, 25, '2025-07-02'),
(5, 2, 30, '2025-07-05');

-- Voedselpakketten (8 records)
INSERT INTO voedselpakketten (pakket_nummer, klant_id, samensteldatum, uitgiftedatum, status, opmerkingen) VALUES
('PKT-2025-001', 1, '2025-06-20', '2025-06-21', 'uitgegeven', 'Pakket voor gezin met lactose-intolerantie'),
('PKT-2025-002', 2, '2025-06-20', '2025-06-21', 'uitgegeven', 'Basis pakket alleenstaande'),
('PKT-2025-003', 3, '2025-06-20', '2025-06-21', 'uitgegeven', 'Vegetarisch pakket grote familie'),
('PKT-2025-004', 4, '2025-06-20', NULL, 'klaar_voor_uitgifte', 'Glutenvrij pakket'),
('PKT-2025-005', 5, '2025-06-20', NULL, 'klaar_voor_uitgifte', 'Pakket voor bejaarden'),
('PKT-2025-006', 6, '2025-06-27', NULL, 'samengesteld', 'Veganistisch pakket'),
('PKT-2025-007', 7, '2025-06-27', NULL, 'samengesteld', 'Groot gezin zonder varkensvlees'),
('PKT-2025-008', 1, '2025-06-27', NULL, 'samengesteld', 'Tweede pakket deze maand');

-- Pakket producten (20 records)
INSERT INTO pakket_producten (pakket_id, product_id, aantal) VALUES
-- Pakket 1 (Familie Jansen - lactosevrij)
(1, 1, 2), (1, 3, 1), (1, 5, 1), (1, 8, 1), (1, 11, 2),
-- Pakket 2 (Alleenstaande Peters)
(2, 1, 1), (2, 2, 1), (2, 6, 1), (2, 7, 2),
-- Pakket 3 (Familie de Wit - vegetarisch)
(3, 1, 2), (3, 2, 2), (3, 3, 2), (3, 5, 2), (3, 10, 1),
-- Pakket 4 (Familie Bakker - glutenvrij)
(4, 3, 1), (4, 2, 1), (4, 8, 1), (4, 11, 1),
-- Pakket 5 (Bejaarde Smit)
(5, 1, 1), (5, 2, 1), (5, 7, 1),
-- Pakket 6 (Familie Groot - veganistisch)
(6, 3, 1), (6, 5, 1), (6, 8, 1);

-- ===========================================
-- VIEWS VOOR RAPPORTAGE
-- ===========================================

-- View: Actieve leveranciers met contactinfo
CREATE VIEW v_actieve_leveranciers AS
SELECT 
    leverancier_id,
    bedrijfsnaam,
    contactpersoon_naam,
    email,
    telefoonnummer,
    eerstvolgende_levering
FROM leveranciers 
WHERE actief = TRUE;

-- View: Voorraad overzicht
CREATE VIEW v_voorraad_overzicht AS
SELECT 
    p.product_id,
    p.naam as product_naam,
    p.streepjescode,
    p.aantal_in_voorraad,
    p.houdbaar_tot,
    pc.omschrijving as categorie,
    l.bedrijfsnaam as leverancier,
    CASE 
        WHEN p.houdbaar_tot < CURDATE() THEN 'VERLOPEN'
        WHEN p.houdbaar_tot <= DATE_ADD(CURDATE(), INTERVAL 3 DAY) THEN 'BIJNA_VERLOPEN'
        ELSE 'OK'
    END as houdbaarheid_status
FROM producten p
JOIN productcategorieen pc ON p.categorie_id = pc.categorie_id
JOIN leveranciers l ON p.leverancier_id = l.leverancier_id
WHERE l.actief = TRUE;

-- View: Klanten overzicht met gezinsinfo
CREATE VIEW v_klanten_overzicht AS
SELECT 
    k.klant_id,
    k.gezinsnaam,
    CONCAT(k.voornaam, ' ', k.achternaam) as contactpersoon,
    CONCAT(k.straat, ' ', k.huisnummer, ', ', k.postcode, ' ', k.plaats) as adres,
    k.telefoonnummer,
    k.email,
    (k.aantal_volwassenen + k.aantal_kinderen + k.aantal_babies) as gezinsgrootte,
    k.aantal_volwassenen,
    k.aantal_kinderen,
    k.aantal_babies,
    k.actief,
    k.aanmelddatum,
    GROUP_CONCAT(kw.wens_type SEPARATOR ', ') as wensen
FROM klanten k
LEFT JOIN klant_wensen kw ON k.klant_id = kw.klant_id
GROUP BY k.klant_id;

-- View: Maandoverzicht per postcode (voor managementrapportage)
CREATE VIEW v_maandoverzicht_postcode AS
SELECT 
    k.postcode,
    YEAR(vp.samensteldatum) as jaar,
    MONTH(vp.samensteldatum) as maand,
    COUNT(vp.pakket_id) as aantal_pakketten,
    COUNT(DISTINCT k.klant_id) as aantal_klanten,
    pc.omschrijving as categorie,
    SUM(pp.aantal) as totaal_producten
FROM klanten k
JOIN voedselpakketten vp ON k.klant_id = vp.klant_id
JOIN pakket_producten pp ON vp.pakket_id = pp.pakket_id
JOIN producten p ON pp.product_id = p.product_id
JOIN productcategorieen pc ON p.categorie_id = pc.categorie_id
GROUP BY k.postcode, jaar, maand, pc.categorie_id;

-- ===========================================
-- INDEXES VOOR PERFORMANCE
-- ===========================================

-- Extra indexes voor queries
CREATE INDEX idx_voedselpakketten_datum_status ON voedselpakketten(samensteldatum, status);
CREATE INDEX idx_klanten_gezinssamenstelling ON klanten(aantal_volwassenen, aantal_kinderen, aantal_babies);
CREATE INDEX idx_producten_houdbaar_voorraad ON producten(houdbaar_tot, aantal_in_voorraad);

-- ===========================================
-- ADVANCED QUERIES MET JOINS (voor examenopdracht)
-- ===========================================

-- 1. INNER JOIN: Leveranciers met hun producten en voorraad
SELECT 
    l.bedrijfsnaam,
    l.contactpersoon_naam,
    p.naam as product_naam,
    p.aantal_in_voorraad,
    pc.omschrijving as categorie
FROM leveranciers l
INNER JOIN producten p ON l.leverancier_id = p.leverancier_id
INNER JOIN productcategorieen pc ON p.categorie_id = pc.categorie_id
WHERE l.actief = TRUE
ORDER BY l.bedrijfsnaam, pc.omschrijving;

-- 2. LEFT JOIN: Alle klanten met hun laatste pakket (ook klanten zonder pakket)
SELECT 
    k.gezinsnaam,
    CONCAT(k.voornaam, ' ', k.achternaam) as contactpersoon,
    k.postcode,
    k.aantal_volwassenen + k.aantal_kinderen + k.aantal_babies as gezinsgrootte,
    MAX(vp.samensteldatum) as laatste_pakket_datum,
    COUNT(vp.pakket_id) as totaal_pakketten
FROM klanten k
LEFT JOIN voedselpakketten vp ON k.klant_id = vp.klant_id
WHERE k.actief = TRUE
GROUP BY k.klant_id, k.gezinsnaam, k.voornaam, k.achternaam, k.postcode
ORDER BY laatste_pakket_datum DESC;

-- 3. RIGHT JOIN: Alle productcategorieën met aantal producten (ook lege categorieën)
SELECT 
    pc.omschrijving as categorie,
    COUNT(p.product_id) as aantal_producten,
    SUM(p.aantal_in_voorraad) as totale_voorraad
FROM producten p
RIGHT JOIN productcategorieen pc ON p.categorie_id = pc.categorie_id
GROUP BY pc.categorie_id, pc.omschrijving
ORDER BY aantal_producten DESC;

-- 4. MULTIPLE JOINS: Complete pakket informatie
SELECT 
    vp.pakket_nummer,
    CONCAT(k.voornaam, ' ', k.achternaam) as klant_naam,
    k.postcode,
    vp.samensteldatum,
    vp.status as pakket_status,
    p.naam as product_naam,
    pc.omschrijving as categorie,
    pp.aantal,
    l.bedrijfsnaam as leverancier
FROM voedselpakketten vp
INNER JOIN klanten k ON vp.klant_id = k.klant_id
INNER JOIN pakket_producten pp ON vp.pakket_id = pp.pakket_id
INNER JOIN producten p ON pp.product_id = p.product_id
INNER JOIN productcategorieen pc ON p.categorie_id = pc.categorie_id
INNER JOIN leveranciers l ON p.leverancier_id = l.leverancier_id
WHERE vp.samensteldatum >= '2025-06-01'
ORDER BY vp.pakket_nummer, pc.omschrijving;

-- 5. SUBQUERY met JOIN: Leveranciers met meeste producten
SELECT 
    l.bedrijfsnaam,
    l.contactpersoon_naam,
    l.email,
    product_count.aantal_producten,
    product_count.totale_voorraad
FROM leveranciers l
INNER JOIN (
    SELECT 
        leverancier_id,
        COUNT(*) as aantal_producten,
        SUM(aantal_in_voorraad) as totale_voorraad
    FROM producten 
    GROUP BY leverancier_id
) product_count ON l.leverancier_id = product_count.leverancier_id
WHERE l.actief = TRUE
ORDER BY product_count.aantal_producten DESC;

-- 6. SELF JOIN: Klanten uit dezelfde postcode
SELECT 
    k1.gezinsnaam as gezin1,
    k2.gezinsnaam as gezin2,
    k1.postcode,
    k1.plaats
FROM klanten k1
INNER JOIN klanten k2 ON k1.postcode = k2.postcode 
WHERE k1.klant_id < k2.klant_id  -- Voorkom duplicaten
AND k1.actief = TRUE 
AND k2.actief = TRUE
ORDER BY k1.postcode;

-- ===========================================
-- STORED PROCEDURES (MySQL)
-- ===========================================

DELIMITER $$

-- SP 1: Nieuwe leverancier toevoegen met validatie
CREATE PROCEDURE sp_AddLeverancier(
    IN p_bedrijfsnaam VARCHAR(255),
    IN p_adres VARCHAR(255),
    IN p_contactpersoon VARCHAR(255),
    IN p_email VARCHAR(255),
    IN p_telefoonnummer VARCHAR(20),
    IN p_levering DATETIME,
    OUT p_leverancier_id INT,
    OUT p_status VARCHAR(50)
)
BEGIN
    DECLARE v_count INT DEFAULT 0;
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SET p_status = 'ERROR: Database fout opgetreden';
        SET p_leverancier_id = 0;
    END;

    START TRANSACTION;
    
    -- Controleer of bedrijfsnaam al bestaat
    SELECT COUNT(*) INTO v_count 
    FROM leveranciers 
    WHERE bedrijfsnaam = p_bedrijfsnaam AND actief = TRUE;
    
    IF v_count > 0 THEN
        SET p_status = 'ERROR: Bedrijfsnaam bestaat al';
        SET p_leverancier_id = 0;
        ROLLBACK;
    ELSE
        -- Voeg leverancier toe
        INSERT INTO leveranciers (
            bedrijfsnaam, adres, contactpersoon_naam, 
            email, telefoonnummer, eerstvolgende_levering, actief
        ) VALUES (
            p_bedrijfsnaam, p_adres, p_contactpersoon, 
            p_email, p_telefoonnummer, p_levering, TRUE
        );
        
        SET p_leverancier_id = LAST_INSERT_ID();
        SET p_status = 'SUCCESS: Leverancier toegevoegd';
        COMMIT;
    END IF;
END$$

-- SP 2: Klant registreren met gezinssamenstelling
CREATE PROCEDURE sp_RegisterKlant(
    IN p_voornaam VARCHAR(255),
    IN p_achternaam VARCHAR(255),
    IN p_straat VARCHAR(255),
    IN p_huisnummer VARCHAR(10),
    IN p_postcode VARCHAR(10),
    IN p_plaats VARCHAR(255),
    IN p_telefoonnummer VARCHAR(20),
    IN p_email VARCHAR(255),
    IN p_volwassenen INT,
    IN p_kinderen INT,
    IN p_babies INT,
    OUT p_klant_id INT,
    OUT p_status VARCHAR(100)
)
BEGIN
    DECLARE v_gezinsnaam VARCHAR(255);
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SET p_status = 'ERROR: Database fout bij registratie';
        SET p_klant_id = 0;
    END;

    START TRANSACTION;
    
    -- Genereer gezinsnaam
    SET v_gezinsnaam = CONCAT('Familie ', p_achternaam);
    
    -- Voeg klant toe
    INSERT INTO klanten (
        gezinsnaam, voornaam, achternaam, straat, huisnummer,
        postcode, plaats, telefoonnummer, email,
        aantal_volwassenen, aantal_kinderen, aantal_babies,
        actief, aanmelddatum
    ) VALUES (
        v_gezinsnaam, p_voornaam, p_achternaam, p_straat, p_huisnummer,
        p_postcode, p_plaats, p_telefoonnummer, p_email,
        p_volwassenen, p_kinderen, p_babies,
        TRUE, CURDATE()
    );
    
    SET p_klant_id = LAST_INSERT_ID();
    SET p_status = CONCAT('SUCCESS: Klant geregistreerd met ID ', p_klant_id);
    COMMIT;
END$$

-- SP 3: Voorraad bijwerken na pakket samenstelling
CREATE PROCEDURE sp_UpdateVoorraadNaPakket(
    IN p_pakket_id INT,
    OUT p_status VARCHAR(100)
)
BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE v_product_id INT;
    DECLARE v_aantal INT;
    DECLARE v_huidige_voorraad INT;
    
    DECLARE pakket_cursor CURSOR FOR
        SELECT product_id, aantal 
        FROM pakket_producten 
        WHERE pakket_id = p_pakket_id;
    
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SET p_status = 'ERROR: Fout bij voorraad update';
    END;

    START TRANSACTION;
    
    OPEN pakket_cursor;
    
    update_loop: LOOP
        FETCH pakket_cursor INTO v_product_id, v_aantal;
        IF done THEN
            LEAVE update_loop;
        END IF;
        
        -- Controleer huidige voorraad
        SELECT aantal_in_voorraad INTO v_huidige_voorraad
        FROM producten
        WHERE product_id = v_product_id;
        
        IF v_huidige_voorraad >= v_aantal THEN
            -- Update voorraad
            UPDATE producten 
            SET aantal_in_voorraad = aantal_in_voorraad - v_aantal
            WHERE product_id = v_product_id;
        ELSE
            SET p_status = CONCAT('ERROR: Onvoldoende voorraad voor product ID ', v_product_id);
            ROLLBACK;
            CLOSE pakket_cursor;
            LEAVE update_loop;
        END IF;
    END LOOP;
    
    CLOSE pakket_cursor;
    
    IF p_status IS NULL THEN
        SET p_status = 'SUCCESS: Voorraad bijgewerkt';
        COMMIT;
    END IF;
END$$

-- SP 4: Maandrapportage genereren
CREATE PROCEDURE sp_MaandrapportagePostcode(
    IN p_jaar INT,
    IN p_maand INT,
    IN p_postcode VARCHAR(10)
)
BEGIN
    SELECT 
        k.postcode,
        COUNT(DISTINCT vp.pakket_id) as aantal_pakketten,
        COUNT(DISTINCT k.klant_id) as aantal_klanten,
        pc.omschrijving as productcategorie,
        SUM(pp.aantal) as totaal_producten_categorie,
        AVG(k.aantal_volwassenen + k.aantal_kinderen + k.aantal_babies) as gem_gezinsgrootte
    FROM klanten k
    INNER JOIN voedselpakketten vp ON k.klant_id = vp.klant_id
    INNER JOIN pakket_producten pp ON vp.pakket_id = pp.pakket_id
    INNER JOIN producten p ON pp.product_id = p.product_id
    INNER JOIN productcategorieen pc ON p.categorie_id = pc.categorie_id
    WHERE YEAR(vp.samensteldatum) = p_jaar
    AND MONTH(vp.samensteldatum) = p_maand
    AND (p_postcode IS NULL OR k.postcode = p_postcode)
    AND k.actief = TRUE
    GROUP BY k.postcode, pc.categorie_id
    ORDER BY k.postcode, totaal_producten_categorie DESC;
END$$

-- SP 5: Verlopen producten identificeren en rapporteren
CREATE PROCEDURE sp_VerlopenProductenRapport()
BEGIN
    -- Verlopen producten
    SELECT 
        'VERLOPEN' as status,
        p.naam as product_naam,
        p.streepjescode,
        p.aantal_in_voorraad,
        p.houdbaar_tot,
        DATEDIFF(CURDATE(), p.houdbaar_tot) as dagen_verlopen,
        pc.omschrijving as categorie,
        l.bedrijfsnaam as leverancier,
        l.contactpersoon_naam,
        l.telefoonnummer
    FROM producten p
    INNER JOIN productcategorieen pc ON p.categorie_id = pc.categorie_id
    INNER JOIN leveranciers l ON p.leverancier_id = l.leverancier_id
    WHERE p.houdbaar_tot < CURDATE()
    AND p.aantal_in_voorraad > 0
    
    UNION ALL
    
    -- Bijna verlopen (binnen 3 dagen)
    SELECT 
        'BIJNA_VERLOPEN' as status,
        p.naam as product_naam,
        p.streepjescode,
        p.aantal_in_voorraad,
        p.houdbaar_tot,
        DATEDIFF(p.houdbaar_tot, CURDATE()) as dagen_resterend,
        pc.omschrijving as categorie,
        l.bedrijfsnaam as leverancier,
        l.contactpersoon_naam,
        l.telefoonnummer
    FROM producten p
    INNER JOIN productcategorieen pc ON p.categorie_id = pc.categorie_id
    INNER JOIN leveranciers l ON p.leverancier_id = l.leverancier_id
    WHERE p.houdbaar_tot BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 3 DAY)
    AND p.aantal_in_voorraad > 0
    ORDER BY houdbaar_tot ASC;
END$$

DELIMITER ;

-- ===========================================
-- FUNCTIES (MySQL User-Defined Functions)
-- ===========================================

DELIMITER $$

-- Functie: Bereken totale gezinsgrootte
CREATE FUNCTION fn_BerekenGezinsgrootte(
    p_volwassenen INT,
    p_kinderen INT, 
    p_babies INT
) RETURNS INT
READS SQL DATA
DETERMINISTIC
BEGIN
    RETURN p_volwassenen + p_kinderen + p_babies;
END$$

-- Functie: Controleer product houdbaarheid status
CREATE FUNCTION fn_HoudbaarheidStatus(p_houdbaar_tot DATE) 
RETURNS VARCHAR(20)
READS SQL DATA
DETERMINISTIC
BEGIN
    DECLARE v_dagen_verschil INT;
    
    IF p_houdbaar_tot IS NULL THEN
        RETURN 'GEEN_DATUM';
    END IF;
    
    SET v_dagen_verschil = DATEDIFF(p_houdbaar_tot, CURDATE());
    
    CASE 
        WHEN v_dagen_verschil < 0 THEN RETURN 'VERLOPEN';
        WHEN v_dagen_verschil <= 3 THEN RETURN 'BIJNA_VERLOPEN';
        WHEN v_dagen_verschil <= 7 THEN RETURN 'WEEK_GELDIG';
        ELSE RETURN 'LANG_GELDIG';
    END CASE;
END$$

DELIMITER ;

-- ===========================================
-- TRIGGERS (automatische acties)
-- ===========================================

DELIMITER $$

-- Trigger: Log wijzigingen in leverancier status
CREATE TRIGGER tr_leverancier_status_log
AFTER UPDATE ON leveranciers
FOR EACH ROW
BEGIN
    IF OLD.actief != NEW.actief THEN
        INSERT INTO activity_log (
            table_name, record_id, action, old_value, new_value, timestamp
        ) VALUES (
            'leveranciers', 
            NEW.leverancier_id,
            'status_wijziging',
            IF(OLD.actief, 'actief', 'inactief'),
            IF(NEW.actief, 'actief', 'inactief'),
            NOW()
        );
    END IF;
END$$

-- Trigger: Automatisch pakket nummer genereren
CREATE TRIGGER tr_generate_pakket_nummer
BEFORE INSERT ON voedselpakketten
FOR EACH ROW
BEGIN
    DECLARE v_jaar INT;
    DECLARE v_volgnummer INT;
    
    SET v_jaar = YEAR(NEW.samensteldatum);
    
    SELECT COALESCE(MAX(CAST(SUBSTRING(pakket_nummer, -3) AS UNSIGNED)), 0) + 1
    INTO v_volgnummer
    FROM voedselpakketten
    WHERE pakket_nummer LIKE CONCAT('PKT-', v_jaar, '-%');
    
    SET NEW.pakket_nummer = CONCAT('PKT-', v_jaar, '-', LPAD(v_volgnummer, 3, '0'));
END$$

DELIMITER ;

-- Tabel voor activity logging (voor triggers)
CREATE TABLE activity_log (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    table_name VARCHAR(50) NOT NULL,
    record_id INT NOT NULL,
    action VARCHAR(50) NOT NULL,
    old_value TEXT NULL,
    new_value TEXT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ===========================================
-- COMPLEXE QUERIES VOOR MANAGEMENTRAPPORTAGE
-- ===========================================

-- Query 1: Top 5 leveranciers met meeste geleverde producten
SELECT 
    l.bedrijfsnaam,
    COUNT(DISTINCT lev.levering_id) as aantal_leveringen,
    SUM(ld.aantal_geleverd) as totaal_geleverd,
    COUNT(DISTINCT p.product_id) as aantal_verschillende_producten,
    MAX(lev.leveringsdatum) as laatste_levering
FROM leveranciers l
INNER JOIN leveringen lev ON l.leverancier_id = lev.leverancier_id
INNER JOIN leveringsdetails ld ON lev.levering_id = ld.levering_id
INNER JOIN producten p ON ld.product_id = p.product_id
WHERE lev.status = 'geleverd'
AND l.actief = TRUE
GROUP BY l.leverancier_id, l.bedrijfsnaam
ORDER BY totaal_geleverd DESC
LIMIT 5;

-- Query 2: Klanten die nog geen pakket hebben ontvangen deze maand
SELECT 
    k.klant_id,
    k.gezinsnaam,
    CONCAT(k.voornaam, ' ', k.achternaam) as contactpersoon,
    k.telefoonnummer,
    k.aanmelddatum,
    fn_BerekenGezinsgrootte(k.aantal_volwassenen, k.aantal_kinderen, k.aantal_babies) as gezinsgrootte
FROM klanten k
LEFT JOIN voedselpakketten vp ON k.klant_id = vp.klant_id 
    AND YEAR(vp.samensteldatum) = YEAR(CURDATE())
    AND MONTH(vp.samensteldatum) = MONTH(CURDATE())
WHERE k.actief = TRUE
AND vp.pakket_id IS NULL
ORDER BY k.aanmelddatum;

-- Query 3: Voorraad analyse met kritieke niveaus
SELECT 
    pc.omschrijving as categorie,
    COUNT(p.product_id) as aantal_producten,
    SUM(p.aantal_in_voorraad) as totale_voorraad,
    AVG(p.aantal_in_voorraad) as gemiddelde_voorraad,
    COUNT(CASE WHEN p.aantal_in_voorraad = 0 THEN 1 END) as uitverkocht,
    COUNT(CASE WHEN p.aantal_in_voorraad <= 5 THEN 1 END) as kritiek_niveau,
    COUNT(CASE WHEN fn_HoudbaarheidStatus(p.houdbaar_tot) = 'VERLOPEN' THEN 1 END) as verlopen_producten
FROM productcategorieen pc
LEFT JOIN producten p ON pc.categorie_id = p.categorie_id
GROUP BY pc.categorie_id, pc.omschrijving
ORDER BY kritiek_niveau DESC, verlopen_producten DESC;

-- ===========================================
-- TEST QUERIES VOOR STORED PROCEDURES
-- ===========================================

-- Test SP: Nieuwe leverancier toevoegen
-- CALL sp_AddLeverancier('Test Leverancier BV', 'Teststraat 1, 1234 AB Teststad', 'Test Contact', 'test@test.nl', '0123-456789', '2025-08-01 10:00:00', @new_id, @status);
-- SELECT @new_id as leverancier_id, @status as status;

-- Test SP: Maandrapportage
-- CALL sp_MaandrapportagePostcode(2025, 6, NULL);

-- Test SP: Verlopen producten rapport
-- CALL sp_VerlopenProductenRapport();

-- ===========================================
-- EINDE UITGEBREID SCRIPT
-- ===========================================
