ALTER SESSION SET NLS_TIMESTAMP_TZ_FORMAT='DD-MM-RR HH24:MI:SS';
ALTER SESSION SET TIME_ZONE='+08:00';

SET SERVEROUTPUT ON
 
--BEGIN
--  Dbms_Output.Put_Line(Systimestamp);
--END;

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
  CONSTRAINT validPrice CHECK (pricePerSeat >= 0),
  CONSTRAINT validDestAndDepartLoc CHECK (departLocation <> destination),
  
  PRIMARY KEY (departDateTime, driverEmail),
  
  FOREIGN KEY (driverEmail) 
    REFERENCES Person(email) 
    ON DELETE CASCADE
);
/
CREATE OR REPLACE TRIGGER isValidDriverAndRideCapacity
  BEFORE
    INSERT OR
    UPDATE 
  ON Driver_Ride FOR EACH ROW
BEGIN
  DECLARE 
    X INT := 0;
  BEGIN
    SELECT COUNT(*) INTO X
    FROM Owns_Car c
    WHERE c.ownerEmail = :NEW.driverEmail;
    
    IF X = 0 THEN
      RAISE_APPLICATION_ERROR(-20001, 'Not a driver');
    END IF;
    
    X := 0;
    
    SELECT c.numSeats INTO X
    FROM Owns_Car c
    WHERE c.ownerEmail = :NEW.driverEmail;
        
    IF :NEW.numSeats > X THEN
      RAISE_APPLICATION_ERROR(-20001, 'constraint (invalid ride capacity) violated');
    END IF;
  END;
END;
/
ALTER TRIGGER isValidDriverAndRideCapacity ENABLE;

CREATE OR REPLACE TRIGGER isValidRideTiming
  BEFORE
    INSERT 
  ON Driver_Ride FOR EACH ROW
BEGIN
  DECLARE 
    numberOfOffendedRides INT := 0;
    currentTimeStamp TIMESTAMP WITH LOCAL TIME ZONE := Systimestamp + (1/24);
  BEGIN
    Dbms_Output.Put_Line(currentTimeStamp);
    Dbms_Output.Put_Line(:NEW.departDateTime);
  
    IF :NEW.departDateTime < currentTimeStamp THEN
      RAISE_APPLICATION_ERROR(-20001, 'constraint (ride timing not after 1 hour of current time) violated');
    END IF;
  
    SELECT COUNT(*) INTO numberOfOffendedRides
    FROM Driver_Ride r
    WHERE r.driverEmail = :NEW.driverEmail
    AND r.departDateTime <= :NEW.departDateTime+(1/24)
    AND r.departDateTime >= :NEW.departDateTime-(1/24);
        
    IF numberOfOffendedRides > 0 THEN
      RAISE_APPLICATION_ERROR(-20001, 'constraint (ride too close to others) violated');
    END IF;
  END;
END;
/
ALTER TRIGGER isValidRideTiming ENABLE;

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
    REFERENCES Driver_Ride(departDateTime, driverEmail) 
    ON DELETE CASCADE
);
/
CREATE OR REPLACE TRIGGER hasEnoughCredit
  BEFORE
    INSERT OR
    UPDATE 
  ON Passenger FOR EACH ROW
BEGIN
  DECLARE 
    passengerBalance INT := 0;
    ridePricePerSeat INT := 0;
  BEGIN
    SELECT p.balance INTO passengerBalance
    FROM Person p
    WHERE p.email = :NEW.passengerEmail;
    
    SELECT r.pricePerSeat INTO ridePricePerSeat
    FROM Driver_Ride r
    WHERE r.driverEmail = :NEW.rideDriverEmail
    AND r.departDateTime = :NEW.rideDepartDateTime;
        
    IF passengerBalance < ridePricePerSeat THEN
        RAISE_APPLICATION_ERROR(-20001, 'constraint (not enough credit) violated');
    END IF;
  END;
END;
/
ALTER TRIGGER hasEnoughCredit ENABLE;

CREATE OR REPLACE TRIGGER isRideTooCloseToOthers
  BEFORE
    INSERT OR
    UPDATE 
  ON Passenger FOR EACH ROW
BEGIN
  DECLARE 
    numberOfTooCloseRides INT := 0;
  BEGIN
    SELECT COUNT(*) INTO numberOfTooCloseRides
    FROM Passenger p
    WHERE p.rideDepartDateTime <= :NEW.rideDepartDateTime+(1/24)
    AND p.rideDepartDateTime >= :NEW.rideDepartDateTime-(1/24)
    AND p.passengerEmail = :NEW.passengerEmail;
        
    IF numberOfTooCloseRides > 0 THEN
      RAISE_APPLICATION_ERROR(-20001, 'constraint (ride too close to others) violated');
    END IF;
  END;
END;
/
ALTER TRIGGER isRideTooCloseToOthers ENABLE;