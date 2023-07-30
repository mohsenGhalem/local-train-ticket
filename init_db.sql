-- Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS local_train_ticket_db;
USE local_train_ticket_db;

-- Create the Stations table
CREATE TABLE stations (
    station_id INT PRIMARY KEY AUTO_INCREMENT,
    station_name VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL
);

-- Create the Trains table
CREATE TABLE trains (
    train_id INT PRIMARY KEY AUTO_INCREMENT,
    train_name VARCHAR(255) NOT NULL,
    capacity INT NOT NULL,
    departure_station_id INT,
    arrival_station_id INT,
    departure_time DATETIME NOT NULL,
    arrival_time DATETIME NOT NULL,
    FOREIGN KEY (departure_station_id) REFERENCES Stations(station_id),
    FOREIGN KEY (arrival_station_id) REFERENCES Stations(station_id)
);

-- Create the Users table
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Create the Journey table
CREATE TABLE journey (
    journey_id INT PRIMARY KEY AUTO_INCREMENT,
    train_id INT,
    source_station_id INT,
    destination_station_id INT,
    departure_time DATETIME NOT NULL,
    arrival_time DATETIME NOT NULL,
    FOREIGN KEY (train_id) REFERENCES Trains(train_id),
    FOREIGN KEY (source_station_id) REFERENCES Stations(station_id),
    FOREIGN KEY (destination_station_id) REFERENCES Stations(station_id)
);

-- Create the Tickets table
CREATE TABLE Tickets (
    ticket_id INT PRIMARY KEY AUTO_INCREMENT,
    passenger_name VARCHAR(255) NOT NULL,
    train_id INT,
    source_station_id INT,
    destination_station_id INT,
    departure_time DATETIME NOT NULL,
    arrival_time DATETIME NOT NULL,
    ticket_price DECIMAL(10, 2) NOT NULL,
    ticket_type VARCHAR(50) NOT NULL,
    purchase_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    admin_id INT,
    FOREIGN KEY (train_id) REFERENCES Trains(train_id),
    FOREIGN KEY (source_station_id) REFERENCES Stations(station_id),
    FOREIGN KEY (destination_station_id) REFERENCES Stations(station_id),
    FOREIGN KEY (admin_id) REFERENCES Users(user_id)
);

-- Insert an admin user into the Users table (change username and password as needed)
INSERT INTO Users (username, password, is_admin) VALUES ('admin', '12345678');
