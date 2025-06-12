DROP TABLE IF EXISTS creators_games;
DROP TABLE IF EXISTS scores;
DROP TABLE IF EXISTS comments;
DROP TABLE IF EXISTS games_tags;
DROP TABLE IF EXISTS screenshots;
DROP TABLE IF EXISTS tags;
DROP TABLE IF EXISTS stats;
DROP TABLE IF EXISTS games;
DROP TABLE IF EXISTS creators;

CREATE TABLE creators (
    id_creator INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(48) NOT NULL,
    username VARCHAR(16) NOT NULL,
    password CHAR(32) NOT NULL,
    email VARCHAR(32) NOT NULL,
    image VARCHAR(16) NULL,
    description TEXT NULL
);

CREATE TABLE games (
    id_game INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(32),
    `link` VARCHAR(128),
    header CHAR(16),
    price DECIMAL(5,2),
    trailer VARCHAR(128),
    id_screenshot INT
);

CREATE TABLE stats (
    id_stat INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    views INT,
    downloads INT,
    likes INT,
    id_game INT UNSIGNED NOT NULL,
    FOREIGN KEY (id_game) REFERENCES games(id_game)
);

CREATE TABLE screenshots (
    id_screenshot INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `image` VARCHAR(16),
    description VARCHAR(128),
    id_game INT UNSIGNED NOT NULL,
    FOREIGN KEY (id_game) REFERENCES games(id_game)
);

CREATE TABLE tags (
    id_tag INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    tag VARCHAR(16),
    color CHAR(6)
);

CREATE TABLE games_tags (
    id_game_tag INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_game INT UNSIGNED NOT NULL,
    id_tag INT UNSIGNED NOT NULL,
    FOREIGN KEY (id_game) REFERENCES games(id_game),
    FOREIGN KEY (id_tag) REFERENCES tags(id_tag)
);

CREATE TABLE comments (
    id_comment INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `comment` TEXT,
    id_creator INT UNSIGNED NOT NULL,
    id_game INT UNSIGNED NOT NULL,
    FOREIGN KEY (id_creator) REFERENCES creators(id_creator),
    FOREIGN KEY (id_game) REFERENCES games(id_game)
);

CREATE TABLE scores (
    id_score INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    score INT,
    `datetime` DATETIME,
    id_creator INT UNSIGNED NOT NULL,
    id_game INT UNSIGNED NOT NULL,
    FOREIGN KEY (id_creator) REFERENCES creators(id_creator),
    FOREIGN KEY (id_game) REFERENCES games(id_game)
);

CREATE TABLE creators_games (
    id_creator_game INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_creator INT UNSIGNED NOT NULL,
    id_game INT UNSIGNED NOT NULL,
    FOREIGN KEY (id_creator) REFERENCES creators(id_creator),
    FOREIGN KEY (id_game) REFERENCES games(id_game)
);