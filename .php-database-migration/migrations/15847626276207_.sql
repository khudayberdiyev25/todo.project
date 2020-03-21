-- // 
-- Migration SQL that makes the change goes here.
create table users (
    id int (11) NOT NULL AUTO_INCREMENT,
    email varchar (255) NOT NULL,
    password varchar (255) NOT NULL,
    created_at int(10) unsigned NOT NULL,
    updated_at int(10) unsigned NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `email_unq` (`email`)
);

create table todos (
	id int (11) NOT NULL AUTO_INCREMENT,
	name varchar(255) NOT NULL,
	email varchar(255) NOT NULL,
	status tinyint(1) DEFAULT 0,
	text varchar (255) NOT NULL ,
	PRIMARY KEY (id)
);
-- @UNDO
-- SQL to undo the change goes here.
drop table users;
drop table todos;