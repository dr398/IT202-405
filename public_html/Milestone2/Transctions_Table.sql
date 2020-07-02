CREATE TABLE Transactions (
    id int auto_increment,
    AccountSource int not null,
    AccountDest int (30) not null,
    Type int not null default 0,
    Total int not null default 0,
    created datetime default current_timestamp,
    modified datetime default current_timestamp on update current_timestamp,
    primary key (id),
    foreign key (AccountSource),
    foreign key (AccountDest),
)
