-- Catalog database schema and sample products.
-- Import with phpMyAdmin or: mysql -u root -p < database/schema.sql

CREATE DATABASE IF NOT EXISTS catalog;
USE catalog;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    image VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    description TEXT
);

INSERT INTO products (name, image, price, description) VALUES
    ('Anvil', 'anvil.jpg', 89.99, 'Heavy-duty cast iron anvil. Drops reliably from any height.'),
    ('Atom Re-Arranger', 'atom-re-arranger.jpg', 499.99, 'Rearranges the atomic structure of any object.'),
    ('Axle Grease', 'axle-grease.jpg', 7.49, 'Guaranteed slippery. Apply to roads, ramps and cliff edges.'),
    ('Bed Springs', 'bed-springs.jpg', 24.99, 'Strap them to your feet for extra bounce.'),
    ('Bird Seed', 'bird-seed.jpg', 4.99, 'Irresistible to fast-moving birds.'),
    ('Blasting Powder', 'blasting-powder.jpg', 34.99, 'Industrial-strength powder. Handle with care.'),
    ('Cork', 'cork.jpg', 1.99, 'Fits most barrels and pipes.'),
    ('Disintegration Pistol', 'disintegration-pistol.jpg', 249.99, 'Point, pull the trigger, and watch it vanish.'),
    ('Earthquake Pills', 'earthquake-pills.jpg', 19.99, 'One pill creates a localized earthquake.'),
    ('Female Roadrunner Costume', 'female-roadrunner-costume.jpg', 59.99, 'A convincing disguise for the patient hunter.'),
    ('Giant Rubber Band', 'giant-rubber-band.jpg', 14.99, 'Launch yourself across canyons.'),
    ('Instant Girl', 'instant-girl.jpg', 9.99, 'Just add water.'),
    ('Iron Carrot', 'iron-carrot.jpg', 12.99, 'Looks like a carrot. Tastes like iron.'),
    ('Jet-Propelled Unicycle', 'jet-propelled-unicycle.jpg', 299.99, 'One wheel, one rocket, top speeds.'),
    ('Out-Board Motor', 'out-board-motor.jpg', 179.99, 'Bolts onto boats, skates and anything else.'),
    ('Railroad Track', 'railroad-track.jpg', 39.99, 'Portable track sections. Lay them anywhere.'),
    ('Rocket Sled', 'rocket-sled.jpg', 349.99, 'Rocket-powered sled for high-speed pursuits.'),
    ('Super Outfit', 'super-outfit.jpg', 49.99, 'Grants the wearer the power of flight (results may vary).'),
    ('Time-Space Gun', 'time-space-gun.jpg', 599.99, 'Freeze time or move through space.'),
    ('X-Ray', 'x-ray.jpg', 129.99, 'See through walls, boxes and disguises.');
