ALTER SESSION SET NLS_TIMESTAMP_TZ_FORMAT='DD-MM-RR HH24:MI:SS';
ALTER SESSION SET TIME_ZONE='+08:00';

CREATE TABLE Person(
  email VARCHAR(256) PRIMARY KEY,
  name VARCHAR(256) NOT NULL,
  balance INT DEFAULT 0,
  age INT,
  gender VARCHAR(6),
  avatar VARCHAR(256),
  password CHAR(60),
  isAdmin VARCHAR(5) DEFAULT 'FALSE',

  CONSTRAINT validBalance CHECK (balance >= 0),
  CONSTRAINT validDrivingAge CHECK (age >= 18),
  CONSTRAINT validGender CHECK (gender IN ('MALE', 'FEMALE')),
  CONSTRAINT isPersonAdmin CHECK (isAdmin IN ('TRUE', 'FALSE')),
  CONSTRAINT validEmail CHECK (email LIKE '%@%')
);

CREATE TABLE Owns_Car(
  carPlateNo VARCHAR(10) NOT NULL UNIQUE,
  carModel VARCHAR(256) NOT NULL,
  ownerLicenseNo CHAR(9) NOT NULL UNIQUE,
  ownerEmail VARCHAR(256),
  numSeats INT NOT NULL,
  
  PRIMARY KEY (carPlateNo, ownerEmail),
  CONSTRAINT validNumSeats CHECK (numSeats > 0),
  FOREIGN KEY (ownerEmail) 
    REFERENCES Person(email) 
    ON DELETE CASCADE
);

CREATE TABLE Has_Profile(
  token CLOB NOT NULL,
  userID VARCHAR(17) NOT NULL UNIQUE,
  email VARCHAR(256),
  
  PRIMARY KEY(userId, email),
  
  FOREIGN KEY (email) 
    REFERENCES Person(email) 
    ON DELETE CASCADE
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
  
  PRIMARY KEY (departDateTime, driverEmail),
  
  FOREIGN KEY (driverEmail) 
    REFERENCES Person(email) 
    ON DELETE CASCADE
);

CREATE OR REPLACE TRIGGER isValidRideCapacity
  BEFORE
    INSERT OR
    UPDATE 
  ON Driver_Ride FOR EACH ROW
BEGIN
  DECLARE 
     X INT := 0;
  BEGIN
    SELECT c.numSeats INTO X
    FROM Owns_Car c
    WHERE c.ownerEmail = :NEW.driverEmail;
        
    IF :NEW.numSeats > X THEN
      RAISE_APPLICATION_ERROR(-20001, 'Invalid Ride Capacity');
    END IF;
  END;
END;

CREATE OR REPLACE TRIGGER isValidRideTiming
  BEFORE
    INSERT OR
    UPDATE 
  ON Driver_Ride FOR EACH ROW
BEGIN
  DECLARE 
     X BOOLEAN := FALSE;
  BEGIN
    X = NOT EXISTS (
      SELECT *
      FROM Driver_Ride r
      WHERE r.driverEmail = :NEW.driverEmail
      AND r.departDateTime <= :NEW.departDateTime+1  -- need to figure out proper syntax
      AND r.departDateTime >= :NEW.departDateTime-1
    )
        
    IF X = FALSE THEN
      RAISE_APPLICATION_ERROR(-20001, 'Invalid Ride Timing');
    END IF;
  END;
END;

ALTER TABLE Driver_Ride ENABLE ALL TRIGGERS;

CREATE TABLE Passenger(
  passengerEmail VARCHAR(256),
  rideDepartDateTime TIMESTAMP WITH LOCAL TIME ZONE,
  rideDriverEmail VARCHAR(256),

  CONSTRAINT noOwnRideSignUp CHECK (passengerEmail <> rideDriverEmail),
  
  PRIMARY KEY(passengerEmail, rideDepartDateTime, rideDriverEmail),
  
  FOREIGN KEY(passengerEmail) 
    REFERENCES Person(email) 
    ON DELETE CASCADE,
  FOREIGN KEY(rideDepartDateTime, rideDriverEmail) 
    REFERENCES Ride_Driver(departDateTime, driverEmail) 
    ON DELETE CASCADE
);

CREATE OR REPLACE TRIGGER hasEnoughCredit
  BEFORE
    INSERT OR
    UPDATE 
  ON Passenger FOR EACH ROW
BEGIN
  DECLARE 
     X BOOLEAN := FALSE;
  BEGIN
    X = EXISTS (
      SELECT *
      FROM Driver_Ride r, Person p
      WHERE p.balance >= r.pricePerSeat
      AND p.email = :NEW.passengerEmail
      AND r.departDateTime = :NEW.rideDepartDateTime
      AND r.driverEmail = :NEW.rideDriverEmail
    )
        
    IF X = FALSE THEN
      RAISE_APPLICATION_ERROR(-20001, 'Not Enough Credit');
    END IF;
  END;
END;

CREATE OR REPLACE TRIGGER isRideTooCloseToOthers
  BEFORE
    INSERT OR
    UPDATE 
  ON Passenger FOR EACH ROW
BEGIN
  DECLARE 
     X BOOLEAN := FALSE;
  BEGIN
    X = NOT EXISTS (
      SELECT *
      FROM Passenger p
      WHERE p.rideDepartDateTime <= :NEW.rideDepartDateTime+1  -- need to figure out proper syntax
      AND p.rideDepartDateTime >= :NEW.rideDepartDateTime-1
      AND p.passengerEmail = :NEW.passengerEmail
    )
        
    IF X = FALSE THEN
      RAISE_APPLICATION_ERROR(-20001, 'Ride too close to others');
    END IF;
  END;
END;

ALTER TABLE Passenger ENABLE ALL TRIGGERS;