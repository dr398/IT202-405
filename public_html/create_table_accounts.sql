CREATE TABLE Accounts (
    id int auto_increment,
    name varchar(20) unique,
    deposit int default 0,
    created datetime default current_timestamp,
    modified datetime default current_timestamp on update current_timestamp,
    primary key (id)
)
