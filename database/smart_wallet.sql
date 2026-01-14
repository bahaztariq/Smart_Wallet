CREATE DATABASE IF NOT EXISTS SmartWallet;

USE SmartWallet

CREATE TABLE if not exists Users(
    Id int serial PRIMARY key,
    UserName VARCHAR(256) not null,
    Email VARCHAR(256) not null,
    Password varchar(256) not null,
    Avatar VARCHAR(256) DEFAULT "avatar_1"
);

CREATE Table If not exists Incomes(
    id int serial PRIMARY KEY,
    UserId int not null,
    Amount DECIMAL(8,2) NOT NULL,
    description VARCHAR(256) NOT null,
    ExpenceDate DATETIME DEFAULT current_TIMESTAMP,
    Foreign Key (UserId) REFERENCES Users(id)
);


CREATE Table If not exists Expences(
    id int serial PRIMARY KEY,
    UserId int not null,
    Amount DECIMAL(8,2) NOT NULL,
    description VARCHAR(256) NOT null,
    ExpenceDate DATETIME DEFAULT current_TIMESTAMP,
    Foreign Key (UserId) REFERENCES Users(id)
);

CREATE TABLE IF NOT EXISTS Category(
    id int serial PRIMARY KEY,
    CategoryName VARCHAR(256) NOT NULL,
    CategoryLimit DECIMAL(8,2) NOT null
);