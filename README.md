A sandwich delivery shop has a database to keep track of which customers have ordered which sandwiches. There 
are several varieties of sandwich on the menu, each with a description. Information about the varieties of sandwich 
are stored in the 'sandwich' table. Each variety comes in several sizes and the price depends both on which kind of 
sandwich it is (sname) and the size; these are stored in the 'menu' table. Each customer has a unique phone number, 
along with an address consisting of a building number, a street, and an apartment number. The orders table keeps 
track of the number of each size of each kind of sandwich ordered by each customer, when the order was placed,
and the status of the order (for example “pending”, “delivering”, “complete”, etc.)
create table customer ( phone char(10) primary key,
 building_num int,
street varchar(20),
apartment varchar(20)
 );
create table sandwich ( sname varchar(20) primary key,
 description varchar (100)
 );
create table menu (sname varchar(20),
 size varchar (20),
price decimal(4,2),
primary key (sname, size),
foreign key (sname) references sandwich(sname)
 );
create table orders (phone char(10),
 sname varchar(20),
size varchar(20),
o_time datetime,
quantity int,
status varchar(10),
primary key (phone, sname, size, o_time),
foreign key (phone) references customer(phone),
foreign key (sname, size) references menu(sname, size)
 );
 
Use PHP to implement a web application that supports the following :
(i) A user enters (via an html form with two text boxes and a “submit” button) a keyword, such as ''delicious'' or 
''turkey'' and a 10 digit phone number.
(ii) The app initiates a session and stores the phone number as a session variable. The app creates an html form 
displaying all sandwiches that have the keyword in the description, along with the description of each, the sizes 
available, and their prices, with some means for the user to select a size of a particular kind of sandwich (e.g radio 
buttons, check boxes, etc). If no keyword is entered, all of the sandwiches (and their sizes and prices) are displayed.
(iii) Using the form produced in part (ii), the user can select a sandwich and size. The order table is updated as 
follows:
If the user has a pending order of the same size of the same kind of sandwich,
the quantity on that order is increased by one and the o_time is changed to the current time.
Otherwise, a new tuple is inserted in the order table, representing this customer’s order of this sandwich, with the 
current time as the o_time and quantity equal to 1. Note that to do this, the app will need to fetch the customer's 
phone number from the session variable.
For full credit, you must use prepared statements.
Test your application, using the data provided on the course page to populate your database. 
Hand the code in via NYU classes.
In addition, you must meet with the graders to give a quick demo. (Details on scheduling demos to be announced.)