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