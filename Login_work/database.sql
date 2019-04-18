DROP DATABASE IF EXISTS RAILWAY_MANAGEMENT;
CREATE DATABASE RAILWAY_MANAGEMENT;
USE RAILWAY_MANAGEMENT;

/* Using 6 different Coach Layouts 3X2,2X2,6X2,4X2,individual_rooms,other(for pantry/sleeper)*/
CREATE TABLE STATIONS(
Station_no int PRIMARY KEY,
Station_name varchar(30),
City varchar(30),
Station_master varchar(30),
no_of_platforms int
);

CREATE TABLE COACH_DETAILS(
Coach_Type varchar(10) PRIMARY KEY,
AC BOOLEAN,
Nature_of_coach varchar(10) CHECK(Nature_of_coach IN ("Seater","Sleeper","Goods","Pantry")),
Layout_no int,
Total_available_seats int
);

INSERT INTO COACH_DETAILS values("CC",true,"Seater",1,80);
INSERT INTO COACH_DETAILS values("EC",true,"Seater",2,80);
INSERT INTO COACH_DETAILS values("3AC",true,"Sleeper",3,40);
INSERT INTO COACH_DETAILS values("2AC",true,"Sleeper",4,30);
INSERT INTO COACH_DETAILS values("1AC",true,"Sleeper",5,20);
INSERT INTO COACH_DETAILS values("SL",false,"Sleeper",3,40);
INSERT INTO COACH_DETAILS values("GN",false,"Sleeper",3,40);
INSERT INTO COACH_DETAILS values("2S",false,"Seater",1,80);
INSERT INTO COACH_DETAILS values("Pantry",false,"Pantry",6,0);
INSERT INTO COACH_DETAILS values("Goods",false,"Goods",6,0);

CREATE TABLE TRAIN_INFO(
Train_no int PRIMARY KEY,
Train_name varchar(30),
Source_station_no int,
Destination_station_no int,
Distance int,
Track_type varchar(30) CHECK(Track_type IN('Broad_gauge','Narrow_gauge')),
FOREIGN key(Source_station_no) REFERENCES STATIONS(Station_no) ON UPDATE CASCADE ON DELETE CASCADE,
FOREIGN key(Destination_station_no) REFERENCES STATIONS(Station_no) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE TRAIN_SCHEDULE(
Train_no int PRIMARY KEY,
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

CREATE TABLE RAILWAY_PATH(
Train_no int,
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

CREATE TABLE ALL_POSSIBLE_PATHS(
Station_no_1 int,
Station_no_2 int,
PRIMARY KEY(Station_no_2,Station_no_1),
FOREIGN key(Station_no_1) REFERENCES STATIONS(Station_no) ON UPDATE CASCADE ON DELETE CASCADE,
FOREIGN key(station_no_2) REFERENCES STATIONS(Station_no) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE TICKET_AVAILABLITY(
Train_no int,
Dates DATE,
Coach_Type varchar(10),
Station_no int,
Total_available_seats int,
PRIMARY KEY(Train_no,Dates,Coach_Type,Station_no),
FOREIGN key(Train_no) REFERENCES TRAIN_INFO(Train_no) ON UPDATE CASCADE ON DELETE CASCADE,
FOREIGN key(Station_no) REFERENCES STATIONS(Station_no) ON UPDATE CASCADE ON DELETE CASCADE,
FOREIGN key(Coach_Type) REFERENCES COACH_DETAILS(Coach_Type) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE BOOKING(
PNR_no int PRIMARY KEY,
Username varchar(30),
Name varchar(30),
Age int,
DOB DATE,
Gender varchar(10) CHECK(Gender in ('M','F','Other')),
Insurance_AV int,
Train_no int,
Coach_Type varchar(10),
Coach_no int,
Seat_no int,
Source_station_no int,
Destination_station_no int,
Boarding_Date DATE,
Booking_Status varchar(10),
FOREIGN key(Coach_Type) REFERENCES COACH_DETAILS(Coach_Type) ON UPDATE CASCADE ON DELETE CASCADE,
FOREIGN key(Train_no) REFERENCES TRAIN_INFO(Train_no) ON UPDATE CASCADE ON DELETE CASCADE,
FOREIGN key(Source_station_no) REFERENCES STATIONS(Station_no) ON UPDATE CASCADE ON DELETE CASCADE,
FOREIGN key(Destination_station_no) REFERENCES STATIONS(Station_no) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE OVERALL_WAITING(
PNR_no int,
Train_no int,
Dates DATE,
Coach_Type varchar(10),
WL_no int,
PRIMARY KEY(Train_no,Dates,Coach_Type,WL_no),
FOREIGN key(Coach_Type) REFERENCES COACH_DETAILS(Coach_Type) ON UPDATE CASCADE ON DELETE CASCADE,
FOREIGN key(Train_no) REFERENCES TRAIN_INFO(Train_no) ON UPDATE CASCADE ON DELETE CASCADE,
FOREIGN key(PNR_no) REFERENCES BOOKING(PNR_no) ON UPDATE CASCADE ON DELETE CASCADE
);

DELIMITER //
CREATE TRIGGER railway_graph_check BEFORE INSERT ON RAILWAY_PATH
FOR EACH ROW BEGIN
IF (SELECT A.Station_no_1 from ALL_POSSIBLE_PATHS as A  where A.Station_no_1=NEW.Station_no and A.Station_no_2 = NEW.previous_station_no) IS NULL THEN
CALL raise_error;
END IF;
END;//
DELIMITER ;
