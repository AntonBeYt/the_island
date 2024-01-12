
# Island name

The lovely Isola Insulinde.
It's got everything from varied climate to friendly locals.

# Hotel name

The Whirling is a small hotel, our main focus is guest satisfaction and supplying a comfortable stay.

# Instructions

This project uses the php calender from benhall14
https://packagist.org/packages/benhall14/php-calendar

And Guzzle
https://docs.guzzlephp.org/en/stable/overview.html#installation

# Database

```sql

CREATE TABLE booking (
	id INTEGER PRIMARY KEY,
	guest_name varchar NOT NULL,
	payment_code varchar,
	standard varchar NOT NULL,
	check_in_date date NOT NULL,
	check_out_date date NOT NULL,
	addons bool NOT NULL,
	subtotal integer,
	booking_time integer
);

CREATE TABLE features (
	id integer PRIMARY KEY,
	feature_name varchar NOT NULL,
	price integer NOT NULL
);

CREATE TABLE booking_features (
	id integer PRIMARY KEY,
	guest_id integer NOT NULL,
	feature_id integer NOT NULL,
	FOREIGN KEY (guest_id) REFERENCES booking(id)
	FOREIGN KEY (feature_id) REFERENCES features(id)
);

CREATE TABLE standards (
	id INTEGER PRIMARY KEY,
	standard VARCHAR NOT NULL,
	price integer NOT NULL
);

INSERT INTO features (feature_name, price)
VALUES ('karaoke', 1), ('petanque', 1), ('safari', 1), ('tour', 1), ('maybells', 1), ('novel', 1), ('pen', 1), ('necktie', 1);

INSERT INTO standards (standard, price)
VALUES ('luxury', 3), ('standard', 2), ('economy', 1);

```

# End Result

https://iiwii.se/whirling/index.php


# Code review

1. example.js:10-15 - Remember to think about X and this could be refactored using the amazing Y function.
2. example.js:10-15 - Remember to think about X and this could be refactored using the amazing Y function.
3. example.js:10-15 - Remember to think about X and this could be refactored using the amazing Y function.
4. example.js:10-15 - Remember to think about X and this could be refactored using the amazing Y function.
5. example.js:10-15 - Remember to think about X and this could be refactored using the amazing Y function.
6. example.js:10-15 - Remember to think about X and this could be refactored using the amazing Y function.
7. example.js:10-15 - Remember to think about X and this could be refactored using the amazing Y function.
8. example.js:10-15 - Remember to think about X and this could be refactored using the amazing Y function.
9. example.js:10-15 - Remember to think about X and this could be refactored using the amazing Y function.
10. example.js:10-15 - Remember to think about X and this could be refactored using the amazing Y function.
