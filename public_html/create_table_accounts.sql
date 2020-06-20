CREATE TABLE Accounts (
    id int auto_increment,
    name varchar(20) unique,
    balance int default 0,
    date_of_birth int default 0,
    created datetime default current_timestamp,
    modified datetime default current_timestamp onupdate current_timestamp,
    primary key (id)
)
