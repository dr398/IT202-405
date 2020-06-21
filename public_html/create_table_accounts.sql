CREATE TABLE Accounts(
    id int auto_increment,
    name varchar(20) unique,
    balance int default  0,
    deposit decimal(10,2) default  0.00,
    modified datetime default current_timestamp  on update current_timestamp ,
    created datetime default  current_timestamp,
    primary key (id)
)
