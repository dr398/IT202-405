SELECT * FROM Accounts where name like CONCAT('%', :account, '%') ORDER BY name ASC
