CREATE TABLE Car(
  carPlateNo VARCHAR(10) PRIMARY KEY,
  carModel VARCHAR(100)
);

CREATE TABLE Owns(
  ownerCarPlateNo VARCHAR(10),
  ownerEmail VARCHAR(256),
  ownerLicenseNo VARCHAR(10),
  PRIMARY KEY (ownerCarPlateNo, ownerEmail),
  FOREIGN KEY (ownerCarPlateNo) REFERENCES Car(carPlateNo),
  FOREIGN KEY (ownerEmail) REFERENCES Person(email)
);

CREATE TABLE Person(
  email VARCHAR(256) PRIMARY KEY,
  name VARCHAR(256),
  balance FLOAT,
  gender VARCHAR(6) CHECK (gender = 'male' OR gender = 'female')
);

CREATE TABLE Ride_Driver(
  departDate DATE,
  departTime TIMESTAMP WITH LOCAL TIME ZONE,  
  departLocation VARCHAR(256),
  destination VARCHAR(256),
  driverEmail VARCHAR(256),
  collected VARCHAR(5) CHECK (collected = 'TRUE' OR collected = 'FALSE'),
  price FLOAT,
  numSeats INT,
  PRIMARY KEY (departDate, departTime, driverEmail),
  FOREIGN KEY (driverEmail) REFERENCES Person(email)
);

CREATE TABLE Passenger(
  paid VARCHAR(5) CHECK (paid = 'TRUE' OR paid = 'FALSE'),
  passengerEmail VARCHAR(256),
  rideDepartDate DATE,
  rideDepartTime TIMESTAMP WITH LOCAL TIME ZONE,
  rideDriverEmail VARCHAR(256),
  PRIMARY KEY(passengerEmail, rideDepartDate, rideDepartTime, rideDriverEmail),
  FOREIGN KEY(passengerEmail) REFERENCES Person(email),
  FOREIGN KEY(rideDepartDate, rideDepartTime, rideDriverEmail) REFERENCES Ride_Driver(departDate, departTime, driverEmail)
);

INSERT INTO Car ('SA33Z','BMWi5');
INSERT INTO Car ('SDE1510L','Toyota Corolla');
INSERT INTO Car ('SGA6993D','Mercedes C150');
INSERT INTO Car ('SBR527C','Volkswagon Golf');
