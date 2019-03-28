PRAGMA foreign_keys = ON;

CREATE TABLE STATIONS(Station_no int PRIMARY KEY,
Station_name varchar(30),
City varchar(30),
Station_master varchar(30),
no_of_platforms int);

CREATE TABLE TRAIN_INFO(Train_no int PRIMARY KEY,
Train_name varchar(30),
Source_station_no int,
Destination_station_no int,
Distance int,
Track_type CHECK(Track_type IN('Broad_gauge','Narrow_gauge')),
FOREIGN key(Source_station_no) REFERENCES STATIONS(Station_no) ON UPDATE CASCADE ON DELETE CASCADE,
FOREIGN key(Destination_station_no) REFERENCES STATIONS(Station_no) ON UPDATE CASCADE ON DELETE CASCADE,
);

CREATE TABLE COACH_DETAILS(Coach_Type int PRIMARY KEY,
)

CREATE TABLE TRAIN_SCHEDULE(Train_no int PRIMARY KEY,
Coach_A_quantity int,Coach_A_price int,
Coach_B_quantity int,Coach_B_price int
Coach_C_quantity int,Coach_C_price int
Coach_D_quantity int,Coach_D_price int
Coach_E_quantity int,Coach_E_price int);