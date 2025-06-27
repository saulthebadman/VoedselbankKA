-- CRUD Scripts voor Leveranciers - Voedselbank Maaskantje (MySQL/PhpMyAdmin)
-- Datum: 27-06-2025

USE voedselbank_maaskantje;

-- ===========================================
-- CREATE (INSERT) OPERATIONS
-- ===========================================

-- Nieuwe leverancier toevoegen
INSERT INTO leveranciers (
    bedrijfsnaam, 
    adres, 
    contactpersoon_naam, 
    email, 
    telefoonnummer, 
    eerstvolgende_levering, 
    actief,
    created_at,
    updated_at
) VALUES (
    'Verse Boer BV',
    'Landweg 15, 5555 AB Dorpstad',
    'Kees Boersma',
    'kees@verseboer.nl',
    '0123-456789',
    '2025-07-10 09:00:00',
    1,
    CURRENT_TIMESTAMP,
    CURRENT_TIMESTAMP
);

-- ===========================================
-- READ (SELECT) OPERATIONS
-- ===========================================

-- Alle actieve leveranciers
SELECT 
    leverancier_id,
    bedrijfsnaam,
    adres,
    contactpersoon_naam,
    email,
    telefoonnummer,
    eerstvolgende_levering
FROM leveranciers 
WHERE actief = 1
ORDER BY bedrijfsnaam;

-- Leverancier zoeken op bedrijfsnaam
SELECT * FROM leveranciers 
WHERE bedrijfsnaam LIKE '%Albert%'
AND actief = 1;

-- Leveranciers met levering deze week
SELECT 
    bedrijfsnaam,
    contactpersoon_naam,
    eerstvolgende_levering
FROM leveranciers 
WHERE eerstvolgende_levering BETWEEN '2025-06-27' AND '2025-07-03'
AND actief = 1
ORDER BY eerstvolgende_levering;

-- Aantal leveranciers per status
SELECT 
    CASE WHEN actief = 1 THEN 'Actief' ELSE 'Inactief' END as status,
    COUNT(*) as aantal
FROM leveranciers 
GROUP BY actief;

-- ===========================================
-- UPDATE OPERATIONS
-- ===========================================

-- Contactgegevens bijwerken
UPDATE leveranciers 
SET 
    email = 'nieuwe.email@leverancier.nl',
    telefoonnummer = '0987-654321',
    updated_at = CURRENT_TIMESTAMP
WHERE leverancier_id = 1;

-- Levering plannen
UPDATE leveranciers 
SET 
    eerstvolgende_levering = '2025-07-15 10:00:00',
    updated_at = CURRENT_TIMESTAMP
WHERE leverancier_id = 2;

-- Leverancier deactiveren
UPDATE leveranciers 
SET 
    actief = 0,
    updated_at = CURRENT_TIMESTAMP
WHERE leverancier_id = 3;

-- Bulk update: alle leveringen een dag uitstellen
UPDATE leveranciers 
SET 
    eerstvolgende_levering = DATE_ADD(eerstvolgende_levering, INTERVAL 1 DAY),
    updated_at = CURRENT_TIMESTAMP
WHERE eerstvolgende_levering IS NOT NULL
AND actief = 1;

-- ===========================================
-- DELETE OPERATIONS
-- ===========================================

-- Soft delete: leverancier inactief maken (aanbevolen)
UPDATE leveranciers 
SET 
    actief = 0,
    updated_at = CURRENT_TIMESTAMP
WHERE leverancier_id = 999;

-- Hard delete: leverancier permanent verwijderen
-- Let op: alleen als er geen gekoppelde data is!
DELETE FROM leveranciers 
WHERE leverancier_id = 999 
AND NOT EXISTS (
    SELECT 1 FROM producten WHERE leverancier_id = 999
)
AND NOT EXISTS (
    SELECT 1 FROM leveringen WHERE leverancier_id = 999
);

-- ===========================================
-- ADVANCED QUERIES
-- ===========================================

-- Leveranciers met hun aantal producten
SELECT 
    l.leverancier_id,
    l.bedrijfsnaam,
    l.contactpersoon_naam,
    COUNT(p.product_id) as aantal_producten
FROM leveranciers l
LEFT JOIN producten p ON l.leverancier_id = p.leverancier_id
WHERE l.actief = 1
GROUP BY l.leverancier_id, l.bedrijfsnaam, l.contactpersoon_naam
ORDER BY aantal_producten DESC;

-- Leveranciers met hun laatste levering
SELECT 
    l.bedrijfsnaam,
    l.contactpersoon_naam,
    MAX(lev.leveringsdatum) as laatste_levering,
    COUNT(lev.levering_id) as aantal_leveringen
FROM leveranciers l
LEFT JOIN leveringen lev ON l.leverancier_id = lev.leverancier_id
WHERE l.actief = 1
GROUP BY l.leverancier_id, l.bedrijfsnaam, l.contactpersoon_naam
ORDER BY laatste_levering DESC;

-- ===========================================
-- STORED PROCEDURES (SQLite doesn't support, but here's the concept)
-- ===========================================

-- Concept voor stored procedure: Leverancier activeren/deactiveren
/*
CREATE PROCEDURE sp_toggle_leverancier_status(
    IN p_leverancier_id INT,
    IN p_actief BOOLEAN
)
BEGIN
    UPDATE leveranciers 
    SET 
        actief = p_actief,
        updated_at = CURRENT_TIMESTAMP
    WHERE leverancier_id = p_leverancier_id;
    
    -- Log de actie
    INSERT INTO activity_log (
        table_name, 
        record_id, 
        action, 
        timestamp
    ) VALUES (
        'leveranciers', 
        p_leverancier_id, 
        CONCAT('Status changed to: ', IF(p_actief, 'Actief', 'Inactief')),
        CURRENT_TIMESTAMP
    );
END;
*/

-- ===========================================
-- DATA VALIDATION QUERIES
-- ===========================================

-- Controleer leveranciers zonder geldige email
SELECT leverancier_id, bedrijfsnaam, email
FROM leveranciers 
WHERE email NOT LIKE '%@%' 
   OR email IS NULL 
   OR email = '';

-- Controleer leveranciers zonder telefoonnummer
SELECT leverancier_id, bedrijfsnaam, telefoonnummer
FROM leveranciers 
WHERE telefoonnummer IS NULL 
   OR telefoonnummer = '' 
   OR LENGTH(telefoonnummer) < 10;

-- Controleer leveranciers met verlopen leveringsdatum
SELECT 
    leverancier_id, 
    bedrijfsnaam, 
    eerstvolgende_levering,
    CASE 
        WHEN eerstvolgende_levering < NOW() THEN 'VERLOPEN'
        ELSE 'OK'
    END as status
FROM leveranciers 
WHERE eerstvolgende_levering IS NOT NULL
AND actief = 1;

-- Einde CRUD Scripts
