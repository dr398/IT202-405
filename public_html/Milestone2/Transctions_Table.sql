CREATE TABLE Transactions (
    memo varchar(20) unique,
    transaction decimal(12,2) default 0.00,
    created datetime default current_timestamp,
    modified datetime default current_timestamp on update current_timestamp,
    primary key (id)
)
