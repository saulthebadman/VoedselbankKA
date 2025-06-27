-- VoedselbankSql_dag2.sql
-- Database script voor Voedselbank Maaskantje
-- Datum: 27-06-2025

-- Drop tables if they exist (in reverse order due to foreign keys)
DROP TABLE IF EXISTS leveringsdetails;
DROP TABLE IF EXISTS leveringen;
DROP TABLE IF EXISTS producten;
DROP TABLE IF EXISTS productcategorieen;
DROP TABLE IF EXISTS leveranciers;

-- Tabel: leveranciers
CREATE TABLE leveranciers (
    leverancier_id INTEGER PRIMARY KEY AUTOINCREMENT,
    bedrijfsnaam VARCHAR(255) NOT NULL,
    adres VARCHAR(255) NOT NULL,
    contactpersoon_naam VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telefoonnummer VARCHAR(20) NOT NULL,
    eerstvolgende_levering TIMESTAMP NULL,
    actief BOOLEAN DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel: productcategorieen
CREATE TABLE productcategorieen (
    categorie_id INTEGER PRIMARY KEY AUTOINCREMENT,
    omschrijving VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel: producten
CREATE TABLE producten (
    product_id INTEGER PRIMARY KEY AUTOINCREMENT,
    naam VARCHAR(255) NOT NULL,
    streepjescode VARCHAR(255) UNIQUE NOT NULL,
    aantal_in_voorraad INTEGER DEFAULT 0,
    houdbaar_tot DATE NULL,
    categorie_id INTEGER NOT NULL,
    leverancier_id INTEGER NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categorie_id) REFERENCES productcategorieen(categorie_id),
    FOREIGN KEY (leverancier_id) REFERENCES leveranciers(leverancier_id)
);

-- Tabel: leveringen
CREATE TABLE leveringen (
    levering_id INTEGER PRIMARY KEY AUTOINCREMENT,
    leverancier_id INTEGER NOT NULL,
    leveringsdatum DATE NOT NULL,
    status VARCHAR(20) DEFAULT 'gepland' CHECK (status IN ('gepland', 'onderweg', 'geleverd', 'geannuleerd')),
    opmerkingen TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (leverancier_id) REFERENCES leveranciers(leverancier_id)
);

-- Tabel: leveringsdetails
CREATE TABLE leveringsdetails (
    levering_id INTEGER NOT NULL,
    product_id INTEGER NOT NULL,
    aantal_geleverd INTEGER NOT NULL,
    vervaldatum DATE NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (levering_id, product_id),
    FOREIGN KEY (levering_id) REFERENCES leveringen(levering_id),
    FOREIGN KEY (product_id) REFERENCES producten(product_id)
);

-- Insert test data - minimaal 5 records per tabel zoals gevraagd

-- Leveranciers (5 records)
INSERT INTO leveranciers (bedrijfsnaam, adres, contactpersoon_naam, email, telefoonnummer, eerstvolgende_levering, actief) VALUES
('Albert Heijn Distributie', 'Provincialeweg 11, 1506 MA Zaandam', 'Jan de Vries', 'jan.devries@ah.nl', '075-6589741', '2025-07-01 08:00:00', 1),
('Jumbo Supermarkten BV', 'Industrieweg 1, 5466 AC Veghel', 'Marie van der Berg', 'marie.vdberg@jumbo.com', '0413-366200', '2025-07-02 10:30:00', 1),
('Bakkerij de Korenwolf', 'Hoofdstraat 45, 5421 CV Gemert', 'Piet Bakker', 'info@korenwolf.nl', '0492-361254', '2025-07-03 07:00:00', 1),
('Boerderij Verse Groenten', 'Akkerweg 23, 5431 NL Cuijk', 'Anna Groentemaker', 'anna@versegroenten.nl', '0485-123456', '2025-07-04 14:00:00', 1),
('Zuivel Coöperatie Limburg', 'Melkweg 12, 6001 AB Weert', 'Henk Melkboer', 'henk@zuivelcoop.nl', '0495-789123', '2025-07-05 09:15:00', 1);

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

-- Producten (minimaal 5 records)
INSERT INTO producten (naam, streepjescode, aantal_in_voorraad, houdbaar_tot, categorie_id, leverancier_id) VALUES
('Witte brood', '8710398123456', 25, '2025-06-29', 4, 3),
('Verse melk 1L', '8712345678901', 40, '2025-07-05', 3, 5),
('Bananen 1kg', '8712100001234', 30, '2025-07-02', 1, 4),
('Gouda kaas jong belegen', '8711234567890', 15, '2025-08-15', 2, 1),
('Spaghetti 500g', '8710123456789', 50, '2025-12-31', 6, 2),
('Appelsap 1L', '8712345001234', 20, '2025-09-30', 5, 1),
('Tomatensoep blik', '8711111222333', 35, '2026-03-15', 7, 2);

-- Leveringen (minimaal 5 records)
INSERT INTO leveringen (leverancier_id, leveringsdatum, status, opmerkingen) VALUES
(1, '2025-06-25', 'geleverd', 'Levering verliep soepel'),
(2, '2025-06-26', 'geleverd', 'Enkele producten beschadigd, rest OK'),
(3, '2025-06-27', 'onderweg', 'Verwacht rond 14:00'),
(4, '2025-06-28', 'gepland', 'Wekelijkse groentlevering'),
(5, '2025-06-29', 'gepland', 'Extra zuivelproducten besteld');

-- Leveringsdetails (minimaal 5 records)
INSERT INTO leveringsdetails (levering_id, product_id, aantal_geleverd, vervaldatum) VALUES
(1, 4, 10, '2025-08-15'),
(1, 6, 15, '2025-09-30'),
(2, 5, 25, '2025-12-31'),
(2, 7, 20, '2026-03-15'),
(3, 1, 30, '2025-06-29'),
(4, 3, 25, '2025-07-02'),
(5, 2, 30, '2025-07-05');

-- Indexes voor betere performance
CREATE INDEX idx_leveranciers_actief ON leveranciers(actief);
CREATE INDEX idx_producten_streepjescode ON producten(streepjescode);
CREATE INDEX idx_producten_categorie ON producten(categorie_id);
CREATE INDEX idx_leveringen_datum ON leveringen(leveringsdatum);
CREATE INDEX idx_leveringen_status ON leveringen(status);

-- Views voor rapportage (bonus)
CREATE VIEW v_actieve_leveranciers AS
SELECT 
    leverancier_id,
    bedrijfsnaam,
    contactpersoon_naam,
    email,
    telefoonnummer,
    eerstvolgende_levering
FROM leveranciers 
WHERE actief = 1;

CREATE VIEW v_voorraad_overzicht AS
SELECT 
    p.product_id,
    p.naam as product_naam,
    p.streepjescode,
    p.aantal_in_voorraad,
    p.houdbaar_tot,
    pc.omschrijving as categorie,
    l.bedrijfsnaam as leverancier
FROM producten p
JOIN productcategorieen pc ON p.categorie_id = pc.categorie_id
JOIN leveranciers l ON p.leverancier_id = l.leverancier_id
WHERE l.actief = 1;

-- Einde script
