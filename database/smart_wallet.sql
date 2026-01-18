CREATE TABLE if not exists Users (
    Id serial PRIMARY key,
    Name VARCHAR(256) not null,
    UserName VARCHAR(256) not null,
    Email VARCHAR(256) not null,
    Password varchar(256) not null
);

CREATE TABLE IF NOT EXISTS Category (
    id serial PRIMARY KEY,
    CategoryName VARCHAR(256) NOT NULL,
    CategoryLimit DECIMAL(8, 2) NOT null
);

CREATE Table If not exists Incomes (
    id serial PRIMARY KEY,
    UserId int not null,
    Amount DECIMAL(8, 2) NOT NULL,
    description VARCHAR(256) NOT null,
    ExpenceDate DATE DEFAULT current_TIMESTAMP,
    Foreign Key (UserId) REFERENCES Users (id)
);

CREATE Table If not exists Expences (
    id serial PRIMARY KEY,
    UserId int not null,
    Amount DECIMAL(8, 2) NOT NULL,
    description VARCHAR(256) NOT null,
    ExpenceDate DATE DEFAULT current_TIMESTAMP,
    CategoryId INT REFERENCES Category (id),
    Foreign Key (UserId) REFERENCES Users (id)
);

-- Seed Categories
INSERT INTO
    Category (CategoryName, CategoryLimit)
VALUES ('Food & Dining', 2000),
    ('Transportation', 1000),
    ('Shopping', 1500),
    ('Entertainment', 500),
    ('Bills & Utilities', 3000),
    ('Health & Fitness', 500),
    ('Travel', 2000),
    ('Education', 1000),
    ('Personal Care', 300),
    ('Rent', 4500),
    ('Groceries', 1500),
    ('Gifts & Donations', 200)
ON CONFLICT DO NOTHING;