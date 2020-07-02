CREATE TABLE Transactions (
    id int auto_increment,
    AccountSource   not null unique,
    AccountDest varchar(30) not null unique,
    Total int not null default 0,
    created datetime default current_timestamp,
    modified datetime default current_timestamp on update current_timestamp,
    primary key (id)
)
