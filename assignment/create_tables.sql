drop table occasies purge;
drop table offerte_optie purge;
drop table offerte purge;
drop table model_optie purge;
drop table model_brandstof purge;
drop table optie purge;
drop table model purge;
drop table brandstof purge;

create table model (
  modelnr    integer primary key,
  merk  varchar2(20),
  model  varchar2(20)
  );
  
create table brandstof (
    soort varchar2(20) primary key
  );
  
create table model_brandstof (
    modelnr integer references model,
    soort   varchar2(20) references brandstof,
    prijs   float,
    primary key(modelnr, soort)
);

create table optie (
  optienr integer primary key,
  optie   varchar2(30),
  prijs   float
  );
  
create table model_optie (
  modelnr  integer references model,
  optienr integer references optie,
  primary key(modelnr, optienr)
);

create table offerte (
  offertenr    integer primary key,
  klant varchar2(20),
  datum date,
  modelnr	integer references model,
  brandstof varchar2(20) references brandstof
);

create table offerte_optie (
  offertenr integer references offerte,
  optienr   integer references optie,
  primary key(offertenr, optienr)
);


 
  create table occasies (
  nr    integer,
  merk  varchar2(20),
  model  varchar2(20),
  jaartal integer,
  km   integer,
  prijs  float
  );
  
  insert into model values (1,'VW','golf');
  insert into model values (2,'VW','passat' );
  insert into model values (3,'VW','tiguan');
  insert into model values (4,'VW','touran');
  insert into model values (5,'audi','A3');
  insert into model values (6,'audi','A4');
  insert into model values (7,'audi','A6');
  insert into model values (8,'audi','A8');
  
  insert into brandstof values ('benzine');
  insert into brandstof values ('diesel');
  insert into brandstof values ('LPG');
  
  insert into model_brandstof values (1, 'diesel', 20000);
  insert into model_brandstof values (1, 'benzine', 19000);
  insert into model_brandstof values (2, 'benzine', 25000);
  insert into model_brandstof values (2, 'diesel', 26000);
  insert into model_brandstof values (3, 'diesel', 31000);
  insert into model_brandstof values (4, 'benzine', 25500);
  insert into model_brandstof values (4, 'diesel', 26000); 
  insert into model_brandstof values (5, 'LPG',   24000);
  insert into model_brandstof values (5, 'diesel', 22000);
  insert into model_brandstof values (6, 'LPG',   30000);
  insert into model_brandstof values (6, 'diesel', 29000);
  insert into model_brandstof values (7, 'diesel', 40000);
  insert into model_brandstof values (8, 'diesel', 2000);

  
  insert into optie values (1, 'Getinte ruiten', 360 );
  insert into optie values (2, 'Metaalkleur', 300);
  insert into optie values (3, 'Sportvelgen', 1500);
  insert into optie values (4, 'Airco', 600);
  insert into optie values (5, 'Lederen zetels', 1000);
  
  insert into model_optie values (1, 1);
  insert into model_optie values (1, 2);
  insert into model_optie values (1, 4);
  insert into model_optie values (2, 1);
  insert into model_optie values (2, 2);
  insert into model_optie values (2, 3);
  insert into model_optie values (3, 1);
  insert into model_optie values (3, 2);
  insert into model_optie values (4, 2); 
  insert into model_optie values (5, 1);
  insert into model_optie values (5, 2);
  insert into model_optie values (5, 4);
  insert into model_optie values (6, 1);
  insert into model_optie values (6, 2);
  insert into model_optie values (6, 3);
  insert into model_optie values (6, 4);
  insert into model_optie values (7, 1);
  insert into model_optie values (7, 3);
  insert into model_optie values (7, 5);
  insert into model_optie values (8, 1);
  insert into model_optie values (8, 2);
  insert into model_optie values (8, 3);
  insert into model_optie values (8, 5);
  
  insert into occasies values (1, 'VW', 'golf', 2000, 50000, 11000);
  insert into occasies values (2, 'VW', 'golf', 2005, 50000, 15000);
  insert into occasies values (3, 'VW', 'passat', 1998, 80000, 12000);
  insert into occasies values (4, 'VW', 'touran', 2005, 100000, 17000);
  insert into occasies values (5, 'Audi', 'A3', 2009, 20000, 19000);
  insert into occasies values (6, 'Audi', 'A3', 2006, 120000, 9000);
  insert into occasies values (7, 'Audi', 'A4', 2001, 150000, 15500);
  insert into occasies values (8, 'Audi', 'A4', 2008, 110000, 21500);
  insert into occasies values (9, 'Audi', 'A6', 2007, 75000, 25000);


  commit;