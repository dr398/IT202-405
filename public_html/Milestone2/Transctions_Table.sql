CREATE TABLE Transactions (
id int auto_increment,
AccountSource int not null, 
AccountDest int (30) not null,
Amount varchar(60) default 0,
Type int not null default 0,
Total int not null default 0,
created datetime default current_timestamp,
modified datetime default current_timestamp on update current_timestamp,
primary key (id),
Foreign key (accountsource) references Accounts (id),
Foreign key (accountdest) references Accounts (id)
)
