create table customer ( phone char(10) primary key,
						building_num int,
						street varchar(20),
						apartment varchar(20)
 );
create table sandwich ( sname varchar(20) primary key,
 						description varchar (100)
 );
create table menu ( sname varchar(20),
					size varchar (20),
					price decimal(4,2),
					primary key (sname, size),
					foreign key (sname) references sandwich(sname)
 );
create table orders (   phone char(10),
						sname varchar(20),
						size varchar(20),
						o_time datetime,
						quantity int,
						status varchar(10),
						primary key (phone, sname, size, o_time),
						foreign key (phone) references customer(phone),
						foreign key (sname, size) references menu(sname, size)
);

INSERT INTO customer VALUES ('1234567890', 1, 'Jay St', '2B');
INSERT INTO customer VALUES ('0987654321', 2, 'Jay St', '2B');

INSERT INTO sandwich VALUES ('Hamburguer', 'Delicious meet');
INSERT INTO sandwich VALUES ('Cheeseburguer', 'Delicious meet with cheese');
INSERT INTO sandwich VALUES ('Cheesesalad', 'Delicious meet with cheese and salad');

INSERT INTO menu VALUES ('Hamburguer', 'Small', 5);
INSERT INTO menu VALUES ('Cheeseburguer', 'Small', 6);
INSERT INTO menu VALUES ('Cheesesalad', 'Small', 7);
INSERT INTO menu VALUES ('Hamburguer', 'Medium', 6);
INSERT INTO menu VALUES ('Cheeseburguer', 'Medium', 7);
INSERT INTO menu VALUES ('Cheesesalad', 'Medium', 8);
INSERT INTO menu VALUES ('Hamburguer', 'Large', 7);
INSERT INTO menu VALUES ('Cheeseburguer', 'Large', 8);
INSERT INTO menu VALUES ('Cheesesalad', 'Large', 9);

INSERT INTO orders VALUES ('1234567890', 'Hamburguer', 'Small', NOW(), 1, 'pending');
INSERT INTO orders VALUES ('1234567890', 'Cheeseburguer', 'Medium', NOW(), 2, 'pending');
INSERT INTO orders VALUES ('1234567890', 'Cheesesalad', 'Large', NOW(), 3, 'pending');
INSERT INTO orders VALUES ('0987654321', 'Hamburguer', 'Large', NOW(), 3, 'pending');
INSERT INTO orders VALUES ('0987654321', 'Cheeseburguer', 'Medium', NOW(), 2, 'pending');
INSERT INTO orders VALUES ('0987654321', 'Cheesesalad', 'Small', NOW(), 1, 'pending');
