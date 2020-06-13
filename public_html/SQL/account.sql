CREATE TABLE Account (
	AccountID int NOT NULL,
	Users int,
	Student,
	DateOfBirth int,
	Deposit int,
	PRIMARY KEY (AccountID),
	FOREIGN KEY (Users) REFERENCES Users (Users)
);



