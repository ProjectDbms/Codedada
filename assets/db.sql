CREATE TABLE IF NOT EXISTS accounts (
    account_id INTEGER AUTO_INCREMENT PRIMARY KEY,
    email_id VARCHAR(255) UNIQUE,
    username VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    organizer BOOLEAN DEFAULT FALSE,
    admin BOOLEAN DEFAULT FALSE
);

INSERT INTO accounts(account_id, email_id, username, password, organizer, admin) VALUES(1, 'mguhan439@gmail.com', 'guhan', '$2y$10$aetLd09Z4Cmu/9KiI8UjXuDBvzMN.RL1yQffhHE5i.2OgQnj1QBii', true, true);

CREATE TABLE IF NOT EXISTS contest (
    contest_id INTEGER PRIMARY KEY AUTO_INCREMENT,
    account_id INTEGER,
    contest_name VARCHAR(255),
    description TEXT,
    start_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    end_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    difficulty VARCHAR(255),
    CONSTRAINT FK_CONTEST_ACCOUNT FOREIGN KEY(account_id) REFERENCES accounts(account_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS question (
    question_id INTEGER PRIMARY KEY AUTO_INCREMENT,
    contest_id INTEGER,
    question_description TEXT,
    level VARCHAR(255),
    CONSTRAINT FK_QUESTION_CONTEST FOREIGN KEY(contest_id) REFERENCES contest(contest_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS testcase (
	question_id INTEGER,
	testcase_input TEXT,
	testcase_output TEXT,
	points INTEGER,
	CONSTRAINT FK_TESTCASE_QUESTION FOREIGN KEY(question_id) REFERENCES question(question_id) ON DELETE CASCADE ON UPDATE CASCADE
);