CREATE TABLE Owns_Car(
  carPlateNo VARCHAR(10) NOT NULL UNIQUE,
  carModel VARCHAR(256) NOT NULL,
  ownerLicenseNo VARCHAR(10) NOT NULL UNIQUE,
  ownerEmail VARCHAR(256),
  numSeats INT NOT NULL,
  
  PRIMARY KEY (carPlateNo, ownerEmail),
  
  FOREIGN KEY (ownerEmail) 
    REFERENCES Person(email) 
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

CREATE TABLE Person(
  email VARCHAR(256) PRIMARY KEY,
  name VARCHAR(256) NOT NULL,
  balance INT DEFAULT 0,
  age INT,
  gender VARCHAR(6),
  avatar VARCHAR(256),
  password VARCHAR(256),
  isAdmin VARCHAR(5) DEFAULT 'FALSE',

  CONSTRAINT validBalance CHECK (balance >= 0),
  CONSTRAINT validDrivingAge CHECK (age >= 18),
  CONSTRAINT validGender CHECK (gender IN ('MALE', 'FEMALE')),
  CONSTRAINT validPassword CHECK (length(password) >= 6),
  CONSTRAINT isPersonAdmin CHECK (isAdmin IN ('TRUE', 'FALSE'))
);

CREATE TABLE Has_Profile(
  token CLOB NOT NULL UNIQUE,
  userID VARCHAR(17) NOT NULL UNIQUE,
  email VARCHAR(256),
  
  PRIMARY KEY(userId, email),
  
  FOREIGN KEY (email) 
    REFERENCES Person(email) 
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

CREATE TABLE Driver_Ride(
  departDateTime TIMESTAMP WITH LOCAL TIME ZONE,
  departLocation VARCHAR(256) NOT NULL,
  destination VARCHAR(256) NOT NULL,
  driverEmail VARCHAR(256),
  pricePerSeat INT,
  numSeats INT,
  isCancelled VARCHAR(5) DEFAULT 'FALSE', 
  isEnded VARCHAR(5) DEFAULT 'FALSE', 
  isStarted VARCHAR(5) DEFAULT 'FALSE', 
    
  CONSTRAINT isRideCancelled CHECK (isCancelled IN ('TRUE', 'FALSE')),
  CONSTRAINT isRideEnded CHECK (isEnded IN ('TRUE', 'FALSE')),
  CONSTRAINT isRideStarted CHECK (isStarted IN ('TRUE', 'FALSE')),
  CONSTRAINT validCancel CHECK (NOT(isCancelled = 'TRUE' AND isStarted = 'TRUE')),
  CONSTRAINT validPrice CHECK (price >= 0),
  CONSTRAINT validCapacity CHECK (
    numSeats <= (
      SELECT c.numSeats
      FROM Owns_Car c
      WHERE c.ownerEmail = driverEmail
    )
  ),
  CONSTRAINT validTiming CHECK (
    NOT EXISTS (
      SELECT *
      FROM Driver_Ride r
      WHERE r.driverEmail = driverEmail
      AND r.departDateTime <= departDateTime+1  -- need to figure out proper syntax
      AND r.departDateTime >= departDateTime-1
    )
  ),
  
  PRIMARY KEY (departDateTime, driverEmail),
  
  FOREIGN KEY (driverEmail) 
    REFERENCES Person(email) 
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

CREATE TABLE Passenger(
  passengerEmail VARCHAR(256),
  rideDepartDateTime TIMESTAMP WITH LOCAL TIME ZONE,
  rideDriverEmail VARCHAR(256),

  CONSTRAINT hasEnoughCredit CHECK (
    EXISTS (
      SELECT *
      FROM Driver_Ride r, Person p
      WHERE p.balance >= r.pricePerSeat
      AND p.email = passengerEmail
      AND r.departDateTime = rideDepartDateTime
      AND r.driverEmail = rideDriverEmail
    )
  ),
  CONSTRAINT noOwnRideSignUp CHECK (passengerEmail <> rideDriverEmail),
  CONSTRAINT isRideTooCloseToOthers CHECK (
    NOT EXISTS (
      SELECT *
      FROM Passenger p
      WHERE p.rideDepartDateTime <= rideDepartDateTime+1  -- need to figure out proper syntax
      AND p.rideDepartDateTime >= rideDepartDateTime-1
      AND p.passengerEmail = passengerEmail
    )
  ),
  
  PRIMARY KEY(passengerEmail, rideDepartDateTime, rideDriverEmail),
  
  FOREIGN KEY(passengerEmail) 
    REFERENCES Person(email) 
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  FOREIGN KEY(rideDepartDateTime, rideDriverEmail) 
    REFERENCES Ride_Driver(departDateTime, driverEmail) 
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

-- INSERT INTO Car ('SA33Z','BMWi5');
-- INSERT INTO Car ('SDE1510L','Toyota Corolla');
-- INSERT INTO Car ('SGA6993D','Mercedes C150');
-- INSERT INTO Car ('SBR527C','Volkswagon Golf');
