CREATE TABLE IF NOT EXISTS accounts (
    account_id INTEGER AUTO_INCREMENT PRIMARY KEY,
    email_id VARCHAR(255) UNIQUE,
    username VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    organizer BOOLEAN DEFAULT FALSE,
    admin BOOLEAN DEFAULT FALSE
);

INSERT INTO accounts(account_id, email_id, username, password, organizer, admin) VALUES(1, 'mguhan439@gmail.com', 'guhan', '$2y$10$aetLd09Z4Cmu/9KiI8UjXuDBvzMN.RL1yQffhHE5i.2OgQnj1QBii', true, true);