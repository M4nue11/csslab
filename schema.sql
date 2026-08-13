-- ============================================================
-- Savanna Edge Camp — database schema
-- Import this in phpMyAdmin (or run via the MySQL CLI) before
-- using the PHP pages. Works with XAMPP's default MySQL setup.
-- ============================================================

CREATE DATABASE IF NOT EXISTS savanna_edge_camp
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE savanna_edge_camp;

-- ------------------------------------------------------------
-- Stores every reservation request submitted through
-- contact.php -> process_reservation.php
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS reservations (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  full_name     VARCHAR(120)  NOT NULL,
  email         VARCHAR(150)  NOT NULL,
  phone         VARCHAR(30)   NOT NULL,
  arrival_date  DATE          NOT NULL,
  nights        TINYINT UNSIGNED NOT NULL,
  guests        TINYINT UNSIGNED NOT NULL,
  camp_option   VARCHAR(30)   NOT NULL,
  activities    VARCHAR(150)  NULL,
  meal_plan     VARCHAR(20)   NOT NULL,
  notes         TEXT          NULL,
  submitted_at  TIMESTAMP     DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Weekend packages shown on stay.php — pulled from the DB
-- instead of being hard-coded in HTML.
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS packages (
  id             INT AUTO_INCREMENT PRIMARY KEY,
  name           VARCHAR(60)  NOT NULL,
  description    TEXT         NOT NULL,
  price_display  VARCHAR(30)  NOT NULL,
  sort_order     TINYINT UNSIGNED DEFAULT 0
) ENGINE=InnoDB;

INSERT INTO packages (name, description, price_display, sort_order) VALUES
('Two-Night Explorer', 'Furnished tent, two nights, one nature walk and one fishing session included.', 'From KES 15,000', 1),
('Family Weekend', 'Riverside Family Site, two nights, one nature walk per adult, kids under 12 stay free.', 'From KES 9,500', 2),
('Angler''s Overnight', 'BYO tent, one night, two fishing sessions (dawn and evening) with a guide.', 'From KES 4,200', 3);

-- ------------------------------------------------------------
-- A single row tracking weekend availability, shown as a
-- <progress> bar on stay.php. In a real system this would be
-- updated automatically as bookings come in; here it's a value
-- staff (or you, for testing) can edit directly in phpMyAdmin.
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS availability (
  id                 INT PRIMARY KEY,
  percent_remaining  TINYINT UNSIGNED NOT NULL
) ENGINE=InnoDB;

INSERT INTO availability (id, percent_remaining) VALUES (1, 30);
