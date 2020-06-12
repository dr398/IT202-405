CREATE TABLE Account (
	AccountID int NOT NULL,
	Users int,
	Student,
	DateOfBirth int,
	Deposit int,
	PRIMARY KEY (AccountID),
	FOREGIN KEY (Users) REFERENCES Users (Users)
);



