
SELECT * FROM Accounts where name like CONCAT('%', :account, '%')
SELECT *
FROM Accounts
ORDER BY name DESC;

