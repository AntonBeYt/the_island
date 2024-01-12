![disco](https://github.com/AntonBeYt/the_island/assets/143318322/d1a28c18-0fd5-4ad6-a0de-848a23d5fa06)

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

What a lovely little hotel!

1. index.php:10-31 - These could be a function in your functions file instead.
2. index.php:147-206 - If you put the images in your db you could fetch the information and build your divs using a foreach loop.
3. insert.php:8-76 - These would be great as functions.
4. script.js:5 - TypeError: Cannot read properties of null (reading 'addEventListener'). Maybe add a check for null before adding the eventlistener?
5. footer.php:6 - Why not source the script with /scripts.js
6. booking.php - Since this file is empty it's not needed.
7. style.css:7 - background-color not in use.
8. style.css:106-113 - this class is not needed since it's not used.
9. validation.php:8-41 - These would make for some nice functions as well.
10. validation.php:9, 35, 49 - Why not delete these old comments.
