## Create Database
DROP DATABASE if exists clinicRecord;
CREATE DATABASE clinicRecord;
USE clinicRecord;

## Create Student PersonalMedical Record table
CREATE TABLE PersonalMedicalRecord (
  id_num int(20) unsigned ZEROFILL auto_increment,
  StudentIDNumber int(20) NOT NULL,
  DocumentCode varchar(255) NOT NULL,
  RevisionNumber varchar(255) NOT NULL,
  Effectivity varchar(255) NOT NULL,
  NoLabel varchar(255) NOT NULL,
  StudentImage longblob default NULL,
  Status enum('new','old') NOT NULL,
  StudentCategory enum('elementary','highschool','senior highschool','college') NOT NULL,
  Course varchar(255) NOT NULL,
  Year varchar(10) NOT NULL,
  Section varchar(255) NOT NULL,
  Lastname varchar(50) NOT NULL,
  Firstname varchar(50) NOT NULL,
  Middlename varchar(50) NOT NULL,
  Extension varchar(5) NOT NULL,
  Age int(3) NOT NULL,
  Birthdate varchar(255) NOT NULL,
  Sex enum('male','female') NOT NULL,
  Address varchar(100) NOT NULL,
  StudentContactNumber varchar(13),
  GuardianParent enum('guardian','parent','none'),
  GPCategory varchar(20),
  ContactPerson varchar(255),
  PGContactNumber varchar(13),
  GuardianParent1 enum('guardian','parent','none'),
  GPCategory1 varchar(20),
  ContactPerson1 varchar(255),
  PGContactNumber1 varchar(13),
  Date varchar(255) NOT NULL,
  StaffIDNumber int(20) NOT NULL,
  StaffLastname varchar(50) NOT NULL,
  StaffFirstname varchar(50) NOT NULL,
  StaffMiddlename varchar(50) NOT NULL,
  StaffExtension varchar(5) NOT NULL,
  LMP varchar(255),
  Pregnancy varchar(255),
  Allergies varchar(255),
  Surgeries varchar(255),
  Injuries varchar(255),
  Illness varchar(255),
  SchoolYear varchar(10),
  Height decimal,
  Weight decimal,
  BMI varchar(255),
  BloodPressure varchar(10) NOT NULL,
  Temperature decimal NOT NULL,
  PulseRate int(3) NOT NULL,
  VisionWithoutGlassesOD varchar(255),
  VisionWithoutGlassesOS varchar(255),
  VisionWithGlassesOD varchar(255),
  VisionWithGlassesOS varchar(255),
  HearingDistanceOpt enum('unremarkable','with findings'),
  TAHearingDistance text ,
  SpeechOpt enum('unremarkable','with findings'),
  TASpeech text,
  EyesOpt enum('unremarkable','with findings'),
  TAEyes text,
  EarsOpt enum('unremarkable','with findings'),
  TAEars text,
  NoseOpt enum('unremarkable','with findings'),
  TANose text,
  HeadOpt enum('unremarkable','with findings'),
  TAHead text,
  AbdomenOpt enum('unremarkable','with findings'),
  TAAbdomen text,
  GenitoUrinaryOpt enum('unremarkable','with findings'),
  TAGenitoUrinary text,
  LymphGlandsOpt enum('unremarkable','with findings'),
  TALymphGlands text,
  SkinOpt enum('unremarkable','with findings'),
  TASkin text,
  ExtremitiesOpt enum('unremarkable','with findings'),
  TAExtremities text,
  DeformitiesOpt enum('unremarkable','with findings'),
  TADeformities text,
  CavityAndThroatOpt enum('unremarkable','with findings'),
  TACavityAndThroat text,
  LungsOpt enum('unremarkable','with findings'),
  TALungs text,
  HeartOpt enum('unremarkable','with findings'),
  TAHeart text,
  BreastOpt enum('unremarkable','with findings'),
  TABreast text,
  RadiologicExamsOpt enum('unremarkable','with findings'),
  TARadiologicExams text,
  BloodAnalysisOpt enum('unremarkable','with findings'),
  TABloodAnalysis text,
  UrinalysisOpt enum('unremarkable','with findings'),
  TAUrinalysis text,
  FecalysisOpt enum('unremarkable','with findings'),
  TAFecalysis text,
  PregnancyTestOpt enum('unremarkable','with findings'),
  TAPregnancyTest text,
  HBSAgOpt enum('unremarkable','with findings'),
  TAHBSAg text,
  TAOthers text,
  TARemarks text,
  TARecommendation text,
  created_at varchar(255),
  updated_at varchar(255),
  archived_at varchar(255),
  
  PRIMARY KEY  (id_num)
);

## Create ConsultationInfo table
CREATE TABLE ConsultationInfo (
  Num bigint(20) unsigned ZEROFILL auto_increment,
  IdNumb int (20) NOT NULL,
  Dates varchar(255) NOT NULL,
  LastN varchar(255) NOT NULL,
  FirstN varchar(255) NOT NULL,
  MiddleN varchar(255) NOT NULL,
  Extens varchar(255) NOT NULL,
  Ages varchar(255) NOT NULL,
  Sexs varchar(255) NOT NULL,
  CourseStrand varchar(255) NOT NULL,
  Years varchar(255) NOT NULL,
  Physician varchar(255) NOT NULL,
  PhysicianID int (20) NOT NULL,
  Temperature varchar(255) NOT NULL,
  BloodPressure varchar(255) NOT NULL,
  PulseRate varchar(255) NOT NULL,
  Smoker varchar(255) NOT NULL,
  NumOfStick varchar(255) NOT NULL,
  NumOfYearAsSmoker varchar(255) NOT NULL,
  AlcoholDrinker varchar(255) NOT NULL,
  AgeStartedAsDrinker varchar(255) NOT NULL,
  Others varchar(255) NOT NULL,
  Moma varchar(255) NOT NULL,
  HowLongAsChewer varchar(255) NOT NULL,
  Vaccination varchar(255) NOT NULL,
  Vaccine varchar(255) NOT NULL,
  Booster varchar(255) NOT NULL,
  Complaints text NULL,
  Diagnosis text NULL,
  DiagnosticTestNeeded text NULL,
  MedicineGiven text NULL,
  PhysicalFindings text NULL,
  Remarks text NULL,
  created_at varchar(255),
  updated_at varchar(255),
  archived_at varchar(255),

  PRIMARY KEY  (Num)
);


## Create Useraccounts table
CREATE TABLE USERACCOUNTS (
  user_id int (20) unsigned ZEROFILL auto_increment,
  IdNum int (20) NOT NULL,
  Status varchar(255) NOT NULL,
  Email varchar(255) NOT NULL,
  Username varchar(255) NOT NULL,
  Password varchar(255) NOT NULL,
  LastName varchar(255) NOT NULL,
  FirstName varchar(255) NOT NULL,
  MiddleName varchar(255) NOT NULL,
  Extension varchar(255) NOT NULL,
  Position varchar(255) NOT NULL,
  Rank varchar(255) NOT NULL,
  AccessLevel varchar(255) NOT NULL default "standard",
  ContactNum varchar(255) NOT NULL,
  AccStatus varchar(255) NOT NULL default "Active",
  LoginChance int NOT NULL default 3,
  code mediumint(50),
  created_at varchar(255),
  updated_at varchar(255),
  archived_at varchar(255),

  PRIMARY KEY  (user_id)
);

## Create System Logs Table
CREATE TABLE SYSTEMLOGS (
  IdNum int unsigned ZEROFILL auto_increment,
  userID int(20) NOT NULL,
  username varchar(255) NOT NULL,
  action varchar(255) NOT NULL,
  isSuccess tinyint(2) NOT NULL,
  date varchar(255) NOT NULL,
  position varchar(255) NOT NULL,

  PRIMARY KEY  (IdNum)
);

## Create DEFAULT account for admin
INSERT INTO useraccounts (IdNum,Email,Username,Password,Status,LastName,FirstName,MiddleName,Extension,Position,Rank,ContactNum,AccStatus,AccessLevel) VALUES (
                        '1','mejia.roejosept10@gmail.com','superadmin','$1$kDQ5/C9w$Ku862njf1IZ5BvO3vUUFf/','old','glen','glen','glen','jr.','superadmin','1','+639458149996','Active','superadmin');

## Create DEFAULT account for admin
INSERT INTO useraccounts (IdNum,Email,Username,Password,Status,LastName,FirstName,MiddleName,Extension,Position,Rank,ContactNum,AccStatus,AccessLevel) VALUES (
                        '2','edriancadungo65@gmail.com','admin','$1$kDQ5/C9w$Ku862njf1IZ5BvO3vUUFf/','old','doe','john','alpha','jr.','doctor','1','+639457148887','Active','admin');

INSERT INTO useraccounts (IdNum,Email,Username,Password,Status,LastName,FirstName,MiddleName,Extension,Position,Rank,ContactNum,AccStatus) VALUES (
                        '3','kurumitaku555@gmail.com','staff','$2y$10$QDiyEIdPoP.VMyiBuAVZnOsJ1q5rBvkSxyeeG/bbqmwohohI65.hi','old','sebastian','mark','beta','jr.','nurse','1','+639457148887','Active');

CREATE TABLE ARCHIVEDSTUDENT (
  id_num int(20) unsigned ZEROFILL auto_increment,
  StudentIDNumber int(20) NOT NULL,
  DocumentCode varchar(255) NOT NULL,
  RevisionNumber varchar(255) NOT NULL,
  Effectivity varchar(255) NOT NULL,
  NoLabel varchar(255) NOT NULL,
  StudentImage longblob default NULL,
  Status enum('new','old') NOT NULL,
  StudentCategory enum('elementary','highschool','senior highschool','college') NOT NULL,
  Course varchar(255) NOT NULL,
  Year varchar(10) NOT NULL,
  Section varchar(255) NOT NULL,
  Lastname varchar(50) NOT NULL,
  Firstname varchar(50) NOT NULL,
  Middlename varchar(50) NOT NULL,
  Extension varchar(5) NOT NULL,
  Age int(3) NOT NULL,
  Birthdate varchar(255) NOT NULL,
  Sex enum('male','female') NOT NULL,
  Address varchar(100) NOT NULL,
  StudentContactNumber varchar(13) NOT NULL,
  GuardianParent enum('guardian','parent','none') NOT NULL,
  GPCategory varchar(20) NOT NULL,
  ContactPerson varchar(255) NOT NULL,
  PGContactNumber varchar(13) NOT NULL,
  GuardianParent1 enum('guardian','parent','none'),
  GPCategory1 varchar(20),
  ContactPerson1 varchar(255),
  PGContactNumber1 varchar(13),
  Date varchar(255) NOT NULL,
  StaffIDNumber int(20) NOT NULL,
  StaffLastname varchar(50) NOT NULL,
  StaffFirstname varchar(50) NOT NULL,
  StaffMiddlename varchar(50) NOT NULL,
  StaffExtension varchar(5) NOT NULL,
  LMP varchar(255),
  Pregnancy varchar(255),
  Allergies varchar(255),
  Surgeries varchar(255),
  Injuries varchar(255),
  Illness varchar(255),
  SchoolYear varchar(10) NOT NULL,
  Height decimal NOT NULL,
  Weight decimal NOT NULL,
  BMI varchar(255) NOT NULL,
  BloodPressure varchar(10) NOT NULL,
  Temperature decimal NOT NULL,
  PulseRate int(3) NOT NULL,
  VisionWithoutGlassesOD varchar(255),
  VisionWithoutGlassesOS varchar(255),
  VisionWithGlassesOD varchar(255),
  VisionWithGlassesOS varchar(255),
  HearingDistanceOpt enum('unremarkable','with findings'),
  TAHearingDistance text ,
  SpeechOpt enum('unremarkable','with findings'),
  TASpeech text,
  EyesOpt enum('unremarkable','with findings'),
  TAEyes text,
  EarsOpt enum('unremarkable','with findings'),
  TAEars text,
  NoseOpt enum('unremarkable','with findings'),
  TANose text,
  HeadOpt enum('unremarkable','with findings'),
  TAHead text,
  AbdomenOpt enum('unremarkable','with findings'),
  TAAbdomen text,
  GenitoUrinaryOpt enum('unremarkable','with findings'),
  TAGenitoUrinary text,
  LymphGlandsOpt enum('unremarkable','with findings'),
  TALymphGlands text,
  SkinOpt enum('unremarkable','with findings'),
  TASkin text,
  ExtremitiesOpt enum('unremarkable','with findings'),
  TAExtremities text,
  DeformitiesOpt enum('unremarkable','with findings'),
  TADeformities text,
  CavityAndThroatOpt enum('unremarkable','with findings'),
  TACavityAndThroat text,
  LungsOpt enum('unremarkable','with findings'),
  TALungs text,
  HeartOpt enum('unremarkable','with findings'),
  TAHeart text,
  BreastOpt enum('unremarkable','with findings'),
  TABreast text,
  RadiologicExamsOpt enum('unremarkable','with findings'),
  TARadiologicExams text,
  BloodAnalysisOpt enum('unremarkable','with findings'),
  TABloodAnalysis text,
  UrinalysisOpt enum('unremarkable','with findings'),
  TAUrinalysis text,
  FecalysisOpt enum('unremarkable','with findings'),
  TAFecalysis text,
  PregnancyTestOpt enum('unremarkable','with findings'),
  TAPregnancyTest text,
  HBSAgOpt enum('unremarkable','with findings'),
  TAHBSAg text,
  TAOthers text,
  TARemarks text,
  TARecommendation text,
  created_at varchar(255),
  updated_at varchar(255),
  archived_at varchar(255),
  
  PRIMARY KEY  (id_num)
);

## Create Archive for Consultation info
CREATE TABLE ARCHIVEDCONSULTATION (
  Num bigint(20) unsigned ZEROFILL auto_increment,
  IdNumb int (20) NOT NULL,
  Dates varchar(255) NOT NULL,
  LastN varchar(255) NOT NULL,
  FirstN varchar(255) NOT NULL,
  MiddleN varchar(255) NOT NULL,
  Extens varchar(255) NOT NULL,
  Ages varchar(255) NOT NULL,
  Sexs varchar(255) NOT NULL,
  CourseStrand varchar(255) NOT NULL,
  Years varchar(255) NOT NULL,
  Physician varchar(255) NOT NULL,
  PhysicianID int (20) NOT NULL,
  Temperature varchar(255) NOT NULL,
  BloodPressure varchar(255) NOT NULL,
  PulseRate varchar(255) NOT NULL,
  Smoker varchar(255) NOT NULL,
  NumOfStick varchar(255) NOT NULL,
  NumOfYearAsSmoker varchar(255) NOT NULL,
  AlcoholDrinker varchar(255) NOT NULL,
  AgeStartedAsDrinker varchar(255) NOT NULL,
  Others varchar(255) NOT NULL,
  Moma varchar(255) NOT NULL,
  HowLongAsChewer varchar(255) NOT NULL,
  Vaccination varchar(255) NOT NULL,
  Vaccine varchar(255) NOT NULL,
  Booster varchar(255) NOT NULL,
  Complaints text NULL,
  Diagnosis text NULL,
  DiagnosticTestNeeded text NULL,
  PhysicalFindings text NULL,
  Remarks text NULL,
  MedicineGiven text NULL,
  created_at varchar(255),
  updated_at varchar(255),
  archived_at varchar(255),

  PRIMARY KEY  (Num)
);


## Create Archive for useraccounts info
CREATE TABLE ARCHIVEDSTAFF (
  user_id int (20) unsigned ZEROFILL auto_increment,
  IdNum int (20) NOT NULL,
  Status varchar(255) NOT NULL,
  Email varchar(255) NOT NULL,
  Username varchar(255) NOT NULL,
  Password varchar(255) NOT NULL,
  LastName varchar(255) NOT NULL,
  FirstName varchar(255) NOT NULL,
  MiddleName varchar(255) NOT NULL,
  Extension varchar(255) NOT NULL,
  Position varchar(255) NOT NULL,
  Rank varchar(255) NOT NULL,
  AccessLevel varchar(255) NOT NULL default "standard",
  ContactNum varchar(255) NOT NULL,
  AccStatus varchar(255) NOT NULL default "Active",
  LoginChance int NOT NULL default 3,
  code mediumint(50),
  created_at varchar(255),
  updated_at varchar(255),
  archived_at varchar(255),

  PRIMARY KEY  (user_id)
);

## Create Archive for system logs info
CREATE TABLE ARCHIVEDLOG (
  IdNum int unsigned ZEROFILL auto_increment,
  userID int(20) NOT NULL,
  username varchar(255) NOT NULL,
  action varchar(255) NOT NULL,
  isSuccess tinyint(2) NOT NULL,
  date varchar(255) NOT NULL,
  position varchar(255) NOT NULL,

  PRIMARY KEY  (IdNum)
);


/*
id_num int(20) unsigned ZEROFILL auto_increment,
  StudentIDNumber int(20) NOT NULL,
  DocumentCode varchar(255) NOT NULL,
  RevisionNumber varchar(255) NOT NULL,
  Effectivity varchar(255) NOT NULL,
  NoLabel varchar(255) NOT NULL,
  StudentImage longblob default NULL,
  Status enum('new','old') NOT NULL,
  StudentCategory enum('elementary','highschool','senior highschool','college') NOT NULL,
  Course varchar(255) NOT NULL,
  Year varchar(10) NOT NULL,
  Section varchar(255) NOT NULL,
  Lastname varchar(50) NOT NULL,
  Firstname varchar(50) NOT NULL,
  Middlename varchar(50) NOT NULL,
  Extension varchar(5) NOT NULL,
  Age int(3) NOT NULL,
  Birthdate varchar(255) NOT NULL,
  Sex enum('male','female') NOT NULL,
  Address varchar(100) NOT NULL,
  StudentContactNumber varchar(13) NOT NULL,
  GuardianParent enum('guardian','parent') NOT NULL,
  GPCategory varchar(20) NOT NULL,
  ContactPerson varchar(255) NOT NULL,
  PGContactNumber varchar(13) NOT NULL,
  GuardianParent1 enum('guardian','parent') NOT NULL,
  GPCategory1 varchar(20) NOT NULL,
  ContactPerson1 varchar(255) NOT NULL,
  PGContactNumber1 varchar(13) NOT NULL,
  Date varchar(255) NOT NULL,
  StaffIDNumber int(20) NOT NULL,
  StaffLastname varchar(50) NOT NULL,
  StaffFirstname varchar(50) NOT NULL,
  StaffMiddlename varchar(50) NOT NULL,
  StaffExtension varchar(5) NOT NULL,
  LMP varchar(255) NOT NULL,
  Pregnancy varchar(255) NOT NULL,
  Allergies varchar(255) NOT NULL,
  Surgeries varchar(255) NOT NULL,
  Injuries varchar(255) NOT NULL,
  Illness varchar(255) NOT NULL,
  SchoolYear varchar(10) NOT NULL,
  Height decimal NOT NULL,
  Weight decimal NOT NULL,
  BMI varchar(255) NOT NULL,
  BloodPressure varchar(10) NOT NULL,
  Temperature decimal NOT NULL,
  PulseRate int(3) NOT NULL,
  VisionWithoutGlassesOD varchar(255) NOT NULL,
  VisionWithoutGlassesOS varchar(255) NOT NULL,
  VisionWithGlassesOD varchar(255) NOT NULL,
  VisionWithGlassesOS varchar(255) NOT NULL,
  HearingDistanceOpt enum('unremarkable','with findings') NOT NULL,
  TAHearingDistance text NULL,
  SpeechOpt enum('unremarkable','with findings') NOT NULL,
  TASpeech text NULL,
  EyesOpt enum('unremarkable','with findings') NOT NULL,
  TAEyes text NULL,
  EarsOpt enum('unremarkable','with findings') NOT NULL,
  TAEars text NULL,
  NoseOpt enum('unremarkable','with findings') NOT NULL,
  TANose text NULL,
  HeadOpt enum('unremarkable','with findings') NOT NULL,
  TAHead text NULL,
  AbdomenOpt enum('unremarkable','with findings') NOT NULL,
  TAAbdomen text NULL,
  GenitoUrinaryOpt enum('unremarkable','with findings') NOT NULL,
  TAGenitoUrinary text NULL,
  LymphGlandsOpt enum('unremarkable','with findings') NOT NULL,
  TALymphGlands text NULL,
  SkinOpt enum('unremarkable','with findings') NOT NULL,
  TASkin text NULL,
  ExtremitiesOpt enum('unremarkable','with findings') NOT NULL,
  TAExtremities text NULL,
  DeformitiesOpt enum('unremarkable','with findings') NOT NULL,
  TADeformities text NULL,
  CavityAndThroatOpt enum('unremarkable','with findings') NOT NULL,
  TACavityAndThroat text NULL,
  LungsOpt enum('unremarkable','with findings') NOT NULL,
  TALungs text NULL,
  HeartOpt enum('unremarkable','with findings') NOT NULL,
  TAHeart text NULL,
  BreastOpt enum('unremarkable','with findings') NOT NULL,
  TABreast text NULL,
  RadiologicExamsOpt enum('unremarkable','with findings') NOT NULL,
  TARadiologicExams text NULL,
  BloodAnalysisOpt enum('unremarkable','with findings') NOT NULL,
  TABloodAnalysis text NULL,
  UrinalysisOpt enum('unremarkable','with findings') NOT NULL,
  TAUrinalysis text NULL,
  FecalysisOpt enum('unremarkable','with findings') NOT NULL,
  TAFecalysis text NULL,
  PregnancyTestOpt enum('unremarkable','with findings') NOT NULL,
  TAPregnancyTest text NULL,
  HBSAgOpt enum('unremarkable','with findings') NOT NULL,
  TAHBSAg text NULL,
  TAOthers text NULL,
  TARemarks text NULL,
  TARecommendation text NULL,
  created_at varchar(255),
  updated_at varchar(255),
*/