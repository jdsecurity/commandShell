INSERT [INTO] TABLE [(`column1`, `column2`,...)] VALUES ('value1', 'value2', ...);
INSERT INTO TABLE SET `column1`='value1', `column2`='value2', ...;

mysql -h host -u * -p < file.sql;

SELECT [options] items
	[INTO file_details]
	FROM tables
	[ WHERE conditions ]
	[ GROUP BY group_type ]
	[ HAVING where_definition ]
	[ ORDER BY order_type ]
	[ LIMIT limit_criteria ]
	[ PROCEDURE proc_name(arguments) ]
	[ lock_options ]
	;
SELECT name, city FROM customers;
SELECT * FROM order_items;
SELECT * FROM orders WHERE customerid = 5;
	(=, <, >, >=, <=, !=, <>, IS NOT NULL, IS NULL, BETWEEN, IN, NOT IN, LIKE, NOT LIKE, REGEXP)
	(customerid = 3, amount > 60.00, amount < 60.00, amount >= 60.00, amount <= 60.00, quantity != 0, city in ("carlton", "Moe"), city NOT IN ("carlton", "Moe"), name LIKE ("Fred %_"), name NOT LIKE ("Fred %_"), name REGEXP)

SELECT * FROM orders WHERE customerid = 3 OR (AND) customerid = 4;


SELECT orders.orderid, orders.amount, orders.date FROM customers, orders
	WHERE customers.name = 'Julie Smith' AND customers.customerid  = orders.customerid;
SELECT customers.name, FROM customers, orders, order_items, books
	WHERE customers.customerid = orders.customerid 
		AND orders.orderid = order_items.orderid
		AND order_items.isbn = books.isbn
		AND books.title like "%Java%";

SELECT customers. customerid, customers.name, orders.orderid FROM
	customers LEFT JOIN orders ON customers.customerid = orders.customerid;
SELECT customers.customerid, customers.name, orders.orderid FROM 
	customers LEFT JOIN orders USING (customerid) WHERE orders.orderid IS NULL;

SELECT c.name FROM customers as c, orders as o, order_items as oi, books as b
	WHERE c.customerid = o.customerid
		AND o.orderid = oi.orderid
		AND oi.isbn = b.isbn
		AND b.title like '%Java%';

SELECT c1.name, c2.name, c1.city FROM customers as c1, customers as c2
	WHERE c1.city = c2.city AND c1.name != c2.name;


SELECT name, address FROM customers ORDER BY name (ASC | DESC);

	AVG(), COUNT(), MIN(), MAX(), STD(), STDDEV(), SUN()
SELECT AVG(amount) FROM orders;
SELECT customerid, AVG(amount) FROM orders GROUP BY customerid;
SELECT customerid, AVG(amount) FROM orders GROUP BY customerid HAVING AVG(amount) > 50;
SELECT name FROM customers LIMIT 2, 3;

SELECT customerid, amount FROM orders WHERE amount = (SELECT MAX(amount) FROM orders);
SELECT customerid, amount FROM orders ORDER BY amount DESC LIMIT 1;

SELECT c1 FROM t1 WHERE c1 > ANY (SELECT c1 FROM t2);
SELECT c1 FROM t1 WHERE c1 IN (SELECT c1 FROM t2);
SELECT c1 FROM t1 WHERE c1 > SOME (SELECT c1 FROM t2);
SELECT c1 FROM t1 WHERE c1 > ALL (SELECT c1 FROM t2);

SELECT isbn, title FROM books WHERE NOT EXISTS (SELECT * FROM order_items WHERE order_items.isbn = books.isbn);

SELECT c1, c2, c3 FROM t1 WHERE (c1, c2, c3) IN (SELECT c1, c2, c3 FROM t2);

SELECT * FROM (SELECT customerid, name FROM customers WHERE city = 'Box Hill') AS box_hill_customers;

UPDATE [LOW_PRIORITY] [IGNORE] tablename
	SET column1 = expression1, column2 = expression2
	[WHERE condition]
	[ORDER BY order_criteria]
	LIMIT number]

DELETE [LOW_PRIORITY] [QUICK] [IGNORE] FROM table [WHERE condition] [ORDER BY order_cols] [LIMIT number]
DELETE FROM table;

DROP TABLE table;

DROP DATABASE database;
