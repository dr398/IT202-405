CREATE TABLE Accounts (
    id int auto_increment,
    name varchar(20) unique,
    DateOfBirth int default 0,
    opened_account datetime default current_timestamp,
    closed_accoount datetime default current_timestamp on update current_timestamp,
    primary key (id)
)
