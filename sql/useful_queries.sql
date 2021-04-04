

--Make a client an admin user in Maria BD
UPDATE `clients` SET `client_level` = '3' WHERE `clients`.`client_id` = 13;

--Make a client an admin user in Postgres DB
UPDATE clients SET client_level = '3' WHERE clients.client_id = 13;

