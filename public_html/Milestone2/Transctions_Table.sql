CREATE TABLE Transactions (
    id int auto_increment,
    AccountSource int not null,
    AccountDest int (30) not null,
    created datetime default current_timestamp,
    modified datetime default current_timestamp on update current_timestamp,
    primary key (id),
    foreign key (AccountSource) REFERENCES Accounts(AccountSource)
    foreign key (AccountDest) REFERENCES Accounts (AccountDest)
);
