

CREATE TABLE if not exists Users(
    Id serial PRIMARY key,
    UserName VARCHAR(256) not null,
    Email VARCHAR(256) not null,
    Password varchar(256) not null,
    Avatar VARCHAR(256) DEFAULT "avatar_1"
);

CREATE Table If not exists Incomes(
    id  serial PRIMARY KEY,
    UserId int not null,
    Amount DECIMAL(8,2) NOT NULL,
    description VARCHAR(256) NOT null,
    IncomeDate DATETIME DEFAULT current_TIMESTAMP,
    Foreign Key (UserId) REFERENCES Users(id)
);


CREATE Table If not exists Expences(
    id  serial PRIMARY KEY,
    UserId int not null,
    Amount DECIMAL(8,2) NOT NULL,
    description VARCHAR(256) NOT null,
    ExpenceDate DATETIME DEFAULT current_TIMESTAMP,
    Foreign Key (UserId) REFERENCES Users(id)
);

CREATE TABLE IF NOT EXISTS Category(
    id  serial PRIMARY KEY,
    CategoryName VARCHAR(256) NOT NULL,
    CategoryLimit DECIMAL(8,2) NOT null
);