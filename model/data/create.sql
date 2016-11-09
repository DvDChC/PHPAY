DROP TABLE commentaire IF EXISTS;

CREATE TABLE image (
id int primary key,
path varchar(1024),
category varchar(64),
comment varchar(1024)
);

CREATE TABLE user (
id int primary key,
login varchar(255),
password varchar(255)
);

CREATE TABLE commentaire (
id int primary key,
image_id int(11),
comment varchar(2056),
author_id int(11),
FOREIGN KEY (image_id) REFERENCES image(id),
FOREIGN KEY (author_id) REFERENCES user(id)
);

INSERT INTO user VALUES(1, "Anonyme", "");