DROP DATABASE IF EXISTS RAILWAY_MANAGEMENT;
CREATE DATABASE RAILWAY_MANAGEMENT;
USE RAILWAY_MANAGEMENT;

/* Using 6 different Coach Layouts 3X2,2X2,6X2,4X2,individual_rooms,other(for pantry/sleeper)*/
CREATE TABLE STATIONS(Station_no int PRIMARY KEY,
Station_name varchar(30),
City varchar(30),
Station_master varchar(30),
no_of_platforms int);

CREATE TABLE COACH_DETAILS(Coach_Type int PRIMARY KEY,
AC BOOLEAN,
Nature_of_coach varchar(10) CHECK(Nature_of_coach IN ("Seater","Sleeper","Goods","Pantry")),
Layout_no int,
Total_available_seats int
);

INSERT INTO COACH_DETAILS values(1,true,"Seater",1,80);
INSERT INTO COACH_DETAILS values(2,true,"Seater",2,80);
INSERT INTO COACH_DETAILS values(3,true,"Sleeper",3,40);
INSERT INTO COACH_DETAILS values(4,true,"Sleeper",4,30);
INSERT INTO COACH_DETAILS values(5,true,"Sleeper",5,20);

INSERT INTO COACH_DETAILS values(6,false,"Seater",1,80);
INSERT INTO COACH_DETAILS values(7,false,"Pantry",6,0);
INSERT INTO COACH_DETAILS values(8,false,"Goods",6,0);

CREATE TABLE TRAIN_INFO(Train_no int PRIMARY KEY,
Train_name varchar(30),
Source_station_no int,
Destination_station_no int,
Distance int,
Track_type varchar(30) CHECK(Track_type IN('Broad_gauge','Narrow_gauge')),
FOREIGN key(Source_station_no) REFERENCES STATIONS(Station_no) ON UPDATE CASCADE ON DELETE CASCADE,
FOREIGN key(Destination_station_no) REFERENCES STATIONS(Station_no) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE TRAIN_SCHEDULE(Train_no int PRIMARY KEY,
Coach_1_quantity int,Coach_1_price int,
Coach_2_quantity int,Coach_2_price int,
Coach_3_quantity int,Coach_3_price int,
Coach_4_quantity int,Coach_4_price int,
Coach_5_quantity int,Coach_5_price int,
Coach_6_quantity int,Coach_6_price int,
Coach_7_quantity int,Coach_7_price int,
Coach_8_quantity int,Coach_8_price int,
FOREIGN key(Train_no) REFERENCES TRAIN_INFO(Train_no) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE RAILWAY_PATH(Train_no int ,
Station_no int, 
previous_station_no int,
Distance int,
Sequence_number int,
Arrival_time time,
Departure_time time,
Monday_avail boolean,
Tuesday_avail boolean,
Wednesday_avail boolean,
Thursday_avail boolean,
Friday_avail boolean,
Saturday_avail boolean,
Sunday_avail boolean,
Day_offset int,
PRIMARY KEY(Train_no,Station_no),
FOREIGN key(Station_no) REFERENCES STATIONS(Station_no) ON UPDATE CASCADE ON DELETE CASCADE,
FOREIGN key(previous_station_no) REFERENCES STATIONS(Station_no) ON UPDATE CASCADE ON DELETE CASCADE,
FOREIGN key(Train_no) REFERENCES TRAIN_INFO(Train_no) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE ALL_POSSIBLE_PATHS(Station_no_1 int,
Station_no_2 int,
PRIMARY KEY(Station_no_2,Station_no_1),
FOREIGN key(Station_no_1) REFERENCES STATIONS(Station_no) ON UPDATE CASCADE ON DELETE CASCADE,
FOREIGN key(station_no_2) REFERENCES STATIONS(Station_no) ON UPDATE CASCADE ON DELETE CASCADE
);