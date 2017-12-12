DROP DATABASE IF EXISTS `cs6400_sfa17_team008`; 
/* 
Optional: MySQL centric items 
MySQL: DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
MySQL Storage Engines: SET default_storage_engine=InnoDB;
Note: "IF EXISTS" is not universal, and the "IF NOT EXISTS" is uncommonly supported, so this functionaly may not work if outside MySQL RDBMS.

Resources:
https://dev.mysql.com/doc/refman/5.7/en/storage-engines.html
https://bitnami.com/stacks/infrastructure
https://www.jetbrains.com/phpstorm/
http://www.w3schools.com/
*/

SET default_storage_engine=InnoDB;

CREATE DATABASE IF NOT EXISTS cs6400_sfa17_team008 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE cs6400_sfa17_team008;

CREATE TABLE `User`(
	username varchar(80) NOT NULL,
	email varchar(80) NOT NULL,
	first_name varchar(80) NOT NULL,
	middle_name varchar(80) NOT NULL,
	last_name varchar(80) NOT NULL,
	`password` varchar(80) NOT NULL,
	PRIMARY KEY (username)
);

CREATE TABLE Customer (
	username varchar(80) NOT NULL,
	phone_number varchar(80) NOT NULL,
	credit_card_number varchar(80) NOT NULL,
	name_on_card varchar(80) NOT NULL,
	expiration_date date NOT NULL,
	CVC_number varchar(80) NOT NULL,
	customer_id int(16) unsigned NOT NULL AUTO_INCREMENT,
	address varchar(80) NOT NULL,
	PRIMARY KEY(customer_id)
);

 CREATE TABLE Reservation (
 	reservation_id int(16) unsigned NOT NULL AUTO_INCREMENT,
 	customer_username varchar(80) NOT NULL,
 	tool_id int(16) unsigned NOT NULL,
 	reservation_start_date date NULL,
 	reservation_end_date date NULL,
 	PRIMARY KEY (reservation_id,tool_id)
 );
  CREATE TABLE `Order` (
    tool_id int(16) unsigned NOT NULL,
	reservation_id int(16) unsigned NOT NULL,
 	customer_username varchar(80) NOT NULL,
 	PRIMARY KEY (reservation_id,tool_id, customer_username)
 );

 CREATE TABLE Clerk (
	username varchar(80) NOT NULL,
 	clerk_id int(16) unsigned NOT NULL,
 	date_of_hire date NOT NULL,
 	PRIMARY KEY (username)
 );
 
CREATE TABLE Phone (
	phone_type varchar(80) NOT NULL,
	phone_number varchar(80) NOT NULL,
    area_code varchar(80) NOT NULL,
    extension varchar(80) NOT NULL,
	username varchar(80) NOT NULL,
	PRIMARY KEY(phone_number)
); 
 
 CREATE TABLE PickUp (
 	clerk_username varchar(80) NOT NULL,
 	reservation_id int(16) unsigned NOT NULL,
	tool_id int(16) unsigned NOT NULL,
	
 	UNIQUE (tool_id,reservation_id)
 );

CREATE TABLE DropOff (
 	clerk_username varchar(80) NOT NULL,
 	reservation_id int(16) unsigned NOT NULL,
	tool_id int(16) unsigned NOT NULL,
 	UNIQUE (clerk_username,reservation_id)
 );

CREATE TABLE `Add` (
  	clerk_username varchar(80) NOT NULL,
  	tool_id int(16) unsigned NOT NULL,
  	PRIMARY KEY (clerk_username,tool_id)
);

CREATE TABLE `With` (
  	rented_reservation_id int(16) unsigned NOT NULL AUTO_INCREMENT,
  	customer_username varchar(80) NOT NULL,
  	tool_id int(16) unsigned NOT NULL,
  	PRIMARY KEY (rented_reservation_id,tool_id,customer_username)
);

CREATE TABLE ServiceOrder (
  	service_id int(16) unsigned NOT NULL,
  	clerk_username varchar(80) NOT NULL,
  	tool_id int(16) unsigned NOT NULL,
  	service_start_date date NOT NULL,
  	service_end_date date NOT NULL,
  	repair_cost float(32) unsigned NOT NULL DEFAULT '0.0',
  	PRIMARY KEY (tool_id,service_id)
);


CREATE TABLE SaleOrder (
  	sale_id int(16) unsigned NOT NULL,
  	clerk_username varchar(80) NOT NULL,
    customer_username varchar(80) NOT NULL,
  	tool_id int(16) unsigned NOT NULL,
  	for_sale_date date NOT NULL,
  	sold_date date,
  	PRIMARY KEY (tool_id,sale_id)
);


CREATE TABLE Rented (
  	rented_reservation_id int(16) unsigned NOT NULL,
  	customer_username varchar(80) NOT NULL,
  	tool_id int(16) unsigned NOT NULL,
  	rented_start_date date NOT NULL,
  	rented_end_date date NOT NULL,
    times_rented int(16) NOT NULL,
  	PRIMARY KEY (customer_username,rented_reservation_id)
);

CREATE TABLE Tools (
	tool_id int(16) unsigned NOT NULL AUTO_INCREMENT,
	manufacturer varchar(80) NOT NULL,
	material varchar(80),
	weight float(32) NOT NULL,
	width_or_diameter float(32) NOT NULL,
	`length` float(32) NOT NULL,
	purchase_price float(32) NOT NULL,
	power_source varchar(80) NOT NULL,
	PRIMARY KEY (tool_id)
);

CREATE TABLE Toolinfo (
	tool_id int(16) unsigned NOT NULL,
	tool_type varchar(80) NOT NULL,
	tool_subtype varchar(80) NOT NULL,
	tool_suboption varchar(80) NOT NULL,
	PRIMARY KEY (tool_id, tool_type)
);

CREATE TABLE HandTools (
	tool_id int(16) unsigned NOT NULL,
    PRIMARY KEY (tool_id)
);

CREATE TABLE ScrewDriver (
	tool_id int(16) unsigned NOT NULL,
    screw_size int(16) NOT NULL,
    PRIMARY KEY (tool_id)
);
CREATE TABLE Socket (
	tool_id int(16) unsigned NOT NULL,
	drive_size float(32) NOT NULL,
	sae_size float(32) NOT NULL,
	deep_socket tinyint,
	PRIMARY KEY (tool_id)
);
CREATE TABLE Ratchet (
	tool_id int(16) unsigned NOT NULL,
    drive_size float(32) NOT NULL,
    PRIMARY KEY (tool_id)
);
CREATE TABLE Wrench (
	tool_id int(16) unsigned NOT NULL,
    PRIMARY KEY (tool_id)
);
CREATE TABLE Pillers (
	tool_id int(16) unsigned NOT NULL,
    adjustable tinyint,
    PRIMARY KEY (tool_id)
);
CREATE TABLE Gun (
	tool_id int(16) unsigned NOT NULL,
	gauge_rating int(16),
	capacity int(16) NOT NULL,
	PRIMARY KEY (tool_id)
);
CREATE TABLE Hammer (
	tool_id int(16) unsigned NOT NULL,
	anti_vibration tinyint,
	PRIMARY KEY (tool_id)
);
CREATE TABLE GardenTools (
	tool_id int(16) unsigned NOT NULL,
	handle_material varchar(80) NOT NULL,
	PRIMARY KEY (tool_id)
);
CREATE TABLE Digger (
	tool_id int(16) unsigned NOT NULL,
	blade_weight float(32),
	blade_length float(32) NOT NULL,
	PRIMARY KEY (tool_id)
);
CREATE TABLE Pruner (
	tool_id int(16) unsigned NOT NULL,
	blade_material varchar(80),
	blade_length float(32) NOT NULL,
	PRIMARY KEY (tool_id)
);
CREATE TABLE Rakes (
	tool_id int(16) unsigned NOT NULL,
	tine_count int(16) NOT NULL,
	PRIMARY KEY (tool_id)
);
CREATE TABLE Wheelbarrows (
	tool_id int(16) unsigned NOT NULL,
	bin_material varchar(80) NOT NULL,
	bin_volume float(32),
	wheel_count int(16) NOT NULL,
	PRIMARY KEY (tool_id)
);
CREATE TABLE Striking (
	tool_id int(16) unsigned NOT NULL,
	head_weight float(32) NOT NULL,
	PRIMARY KEY (tool_id)
);
CREATE TABLE Ladders (
	tool_id int(16) unsigned NOT NULL,
	step_count int(16),
	weight_capacity int(16),
	PRIMARY KEY (tool_id)
);
CREATE TABLE Straight (
    tool_id int(16) unsigned NOT NULL,
    rubber_feet tinyint,
    PRIMARY KEY (tool_id)
);
CREATE TABLE Step (
	tool_id int(16) unsigned NOT NULL,
	pail_shelf tinyint,
	PRIMARY KEY (tool_id)
);
CREATE TABLE PowerTools (
	tool_id int(16) unsigned NOT NULL,
	volt_rating int(16) NOT NULL,
	amp_rating float(32) NOT NULL,
	min_rpm_rating int(16) NOT NULL,
	max_rpm_rating int(16),
	PRIMARY KEY (tool_id)
);
CREATE TABLE Drill (
	tool_id int(16) unsigned NOT NULL,
	adjustable_clutch tinyint NOT NULL,
	min_torque_rating float(32) NOT NULL,
	max_torque_rating float(32),
	PRIMARY KEY (tool_id)
);
CREATE TABLE Saw (
	tool_id int(16) unsigned NOT NULL,
	blade_size float(32) NOT NULL,
	PRIMARY KEY (tool_id)
);
CREATE TABLE Sander (
	tool_id int(16) unsigned NOT NULL,
	dust_bag tinyint NOT NULL,
	PRIMARY KEY (tool_id)
);
CREATE TABLE Air_Compressor (
	tool_id int(16) unsigned NOT NULL,
	tank_size float(32) NOT NULL,
	pressure_rating float(32),
	PRIMARY KEY (tool_id)
);
CREATE TABLE Mixer (
	tool_id int(16) unsigned NOT NULL,
    motor_rating float(32) NOT NULL,
    drum_size float(32) NOT NULL,
    PRIMARY KEY (tool_id)
);
CREATE TABLE Generator (
	tool_id int(16) unsigned NOT NULL,
    power_rating float(32) NOT NULL,
    PRIMARY KEY (tool_id)
);
CREATE TABLE Power_Accessories (
	tool_id int(16) unsigned NOT NULL,
	battery_type varchar(80) NOT NULL,    
    quantity int(16),
    accerssory_description varchar(80) NOT NULL,
    PRIMARY KEY (tool_id, battery_type, quantity, accerssory_description)
);


--  Table Constraints 
ALTER TABLE Customer
	ADD CONSTRAINT FK_Customer_username_User_username 
    FOREIGN KEY (username) REFERENCES `User` (username),
	ADD CONSTRAINT FK_Customer_phone_number_Phone_phone_number
	FOREIGN KEY (phone_number) REFERENCES Phone (phone_number);
ALTER TABLE Phone
	ADD CONSTRAINT FK_Phone_username_Customer_username
	FOREIGN KEY (username) REFERENCES Customer (username);
    		
    
ALTER TABLE Clerk
	ADD CONSTRAINT FK_Clerk_username_User_username
    FOREIGN KEY (username) REFERENCES `User` (username);  
  
ALTER TABLE `Add`
  ADD CONSTRAINT FK_Add_clerk_username_Clerk_username 
  FOREIGN KEY (clerk_username) REFERENCES Clerk (username),
  ADD CONSTRAINT FK_Add_tool_id_Tools_tool_id
  FOREIGN KEY (tool_id) REFERENCES Tools (tool_id);
  
ALTER TABLE ServiceOrder
  ADD CONSTRAINT FK_ServiceOrder_clerk_username_Clerk_username 
  FOREIGN KEY (clerk_username) REFERENCES Clerk (username),
  ADD CONSTRAINT FK_ServiceOrder_tool_id_Tools_tool_id
  FOREIGN KEY (tool_id) REFERENCES Tools (tool_id);
  
ALTER TABLE SaleOrder
  ADD CONSTRAINT FK_SaleOrder_clerk_username_Clerk_username 
  FOREIGN KEY (clerk_username) REFERENCES Clerk (username),
    ADD CONSTRAINT FK_SaleOrder_tool_id_Tools_tool_id
  FOREIGN KEY (tool_id) REFERENCES Tools (tool_id);

ALTER TABLE Toolinfo
  ADD CONSTRAINT FK_Toolinfo_tool_id_Tools_tool_id
  FOREIGN KEY (tool_id) REFERENCES Tools (tool_id);

ALTER TABLE Rented
  ADD CONSTRAINT FK_Rented_customer_username_Customer_username 
  FOREIGN KEY (customer_username) REFERENCES Customer (username);
  

ALTER TABLE `With`
  ADD CONSTRAINT FK_With_customer_username_Customer_username 
  FOREIGN KEY (customer_username) REFERENCES Customer (username),
  ADD CONSTRAINT FK_With_tool_id_Tools_tool_id
  FOREIGN KEY (tool_id) REFERENCES Tools (tool_id);


  
ALTER TABLE Reservation
  ADD CONSTRAINT FK_Reservation_customer_username_Customer_username 
  FOREIGN KEY (customer_username) REFERENCES Customer (username),

  ADD CONSTRAINT FK_Reservation_tool_id_Tools_tool_id
  FOREIGN KEY (tool_id) REFERENCES Tools (tool_id);

ALTER TABLE PickUp
	ADD CONSTRAINT FK_PickUp_clerk_username_Clerk_username
    FOREIGN KEY (clerk_username) REFERENCES Clerk(username),
    ADD CONSTRAINT FK_PickUp_reservation_id_Reservation_reservation_id
    FOREIGN KEY (reservation_id) REFERENCES Reservation (reservation_id),
	ADD CONSTRAINT FK_PickUp_tool_id_Tools_tool_id
    FOREIGN KEY (tool_id) REFERENCES Tools (tool_id);
    
ALTER TABLE DropOff
	ADD CONSTRAINT FK_DropOff_clerk_username_Clerk_username
    FOREIGN KEY (clerk_username) REFERENCES Clerk(username),
    ADD CONSTRAINT FK_DropOff_reservation_id_Reservation_reservation_id
    FOREIGN KEY (reservation_id) REFERENCES Reservation (reservation_id),
	ADD CONSTRAINT FK_DropOff_tool_id_Tools_tool_id
    FOREIGN KEY (tool_id) REFERENCES Tools (tool_id);
    
ALTER TABLE HandTools
	ADD CONSTRAINT FK_HandTools_tool_id_Tools_tool_id
    FOREIGN KEY (tool_id) REFERENCES Tools (tool_id);
    
ALTER TABLE ScrewDriver
	ADD CONSTRAINT FK_ScrewDriver_tool_id_Tools_tool_id
    FOREIGN KEY (tool_id) REFERENCES Tools (tool_id);
    
ALTER TABLE Socket
	ADD CONSTRAINT FK_Socket_tool_id_Tools_tool_id
    FOREIGN KEY (tool_id) REFERENCES Tools (tool_id);
    
ALTER TABLE Ratchet
	ADD CONSTRAINT FK_Ratchet_tool_id_Tools_tool_id
    FOREIGN KEY (tool_id) REFERENCES Tools (tool_id);
    
ALTER TABLE Wrench
	ADD CONSTRAINT FK_Wrench_tool_id_Tools_tool_id
    FOREIGN KEY (tool_id) REFERENCES Tools (tool_id);
    
ALTER TABLE Pillers
	ADD CONSTRAINT FK_Pillers_tool_id_Tools_tool_id
    FOREIGN KEY (tool_id) REFERENCES Tools (tool_id);
    
ALTER TABLE Gun
	ADD CONSTRAINT FK_Gun_tool_id_Tools_tool_id
    FOREIGN KEY (tool_id) REFERENCES Tools (tool_id);
    
ALTER TABLE Hammer
	ADD CONSTRAINT FK_Hammer_tool_id_Tools_tool_id
    FOREIGN KEY (tool_id) REFERENCES Tools (tool_id);    
    
ALTER TABLE GardenTools
	ADD CONSTRAINT FK_GardenTools_tool_id_Tools_tool_id
    FOREIGN KEY (tool_id) REFERENCES Tools (tool_id);
    
ALTER TABLE Digger
	ADD CONSTRAINT FK_Digger_tool_id_Tools_tool_id
    FOREIGN KEY (tool_id) REFERENCES Tools (tool_id);  
    
ALTER TABLE Pruner
	ADD CONSTRAINT FK_Pruner_tool_id_Tools_tool_id
    FOREIGN KEY (tool_id) REFERENCES Tools (tool_id);   
    
ALTER TABLE Rakes
	ADD CONSTRAINT FK_Rakes_tool_id_Tools_tool_id
    FOREIGN KEY (tool_id) REFERENCES Tools (tool_id); 
    
ALTER TABLE Wheelbarrows
	ADD CONSTRAINT FK_Wheelbarrows_tool_id_Tools_tool_id
    FOREIGN KEY (tool_id) REFERENCES Tools (tool_id);   
    
ALTER TABLE Striking
	ADD CONSTRAINT FK_Striking_tool_id_Tools_tool_id
    FOREIGN KEY (tool_id) REFERENCES Tools (tool_id);    
    
ALTER TABLE Ladders
	ADD CONSTRAINT FK_Ladders_tool_id_Tools_tool_id
    FOREIGN KEY (tool_id) REFERENCES Tools (tool_id);
    
ALTER TABLE Straight
	ADD CONSTRAINT FK_Straight_tool_id_Tools_tool_id
    FOREIGN KEY (tool_id) REFERENCES Tools (tool_id);   
    
ALTER TABLE Step
	ADD CONSTRAINT FK_Step_tool_id_Tools_tool_id
    FOREIGN KEY (tool_id) REFERENCES Tools (tool_id);   
    
ALTER TABLE PowerTools
	ADD CONSTRAINT FK_PowerTools_tool_id_Tools_tool_id
    FOREIGN KEY (tool_id) REFERENCES Tools (tool_id);
    
ALTER TABLE Drill
	ADD CONSTRAINT FK_Drill_tool_id_Tools_tool_id
    FOREIGN KEY (tool_id) REFERENCES Tools (tool_id);
    
ALTER TABLE Saw
	ADD CONSTRAINT FK_Saw_tool_id_Tools_tool_id
    FOREIGN KEY (tool_id) REFERENCES Tools (tool_id);  
    
ALTER TABLE Sander
	ADD CONSTRAINT FK_Sander_tool_id_Tools_tool_id
    FOREIGN KEY (tool_id) REFERENCES Tools (tool_id);   
    
ALTER TABLE Air_Compressor
	ADD CONSTRAINT FK_Air_Compressor_tool_id_Tools_tool_id
    FOREIGN KEY (tool_id) REFERENCES Tools (tool_id);    
    
ALTER TABLE Mixer
	ADD CONSTRAINT FK_Mixer_tool_id_Tools_tool_id
    FOREIGN KEY (tool_id) REFERENCES Tools (tool_id);    
    
ALTER TABLE Generator
	ADD CONSTRAINT FK_Generator_tool_id_Tools_tool_id
    FOREIGN KEY (tool_id) REFERENCES Tools (tool_id); 
	
ALTER TABLE Power_Accessories
	ADD CONSTRAINT FK_Power_Accessories_tool_id_Tools_tool_id
	FOREIGN KEY (tool_id) REFERENCES Tools (tool_id);

	
	
	

