CREATE TABLE Persons (Id int(11) NOT NULL AUTO_INCREMENT, Name varchar(255) NOT NULL, Birthdate date NOT NULL, PhoneNumber varchar(255), EmergencyContact text, Email varchar(255) NOT NULL, FoodAllergiesOther text, TypeOfLarperComment text, OtherInformation text, ExperiencesId int(11) NOT NULL, TypesOfFoodId int(11) NOT NULL, LarperTypesId int(11) NOT NULL, PRIMARY KEY (Id));
CREATE TABLE Characters (Id int(11) NOT NULL AUTO_INCREMENT, Name varchar(255) NOT NULL, IsNPC tinyint(1) NOT NULL, Profession varchar(255) NOT NULL, Descrption mediumtext, PreviousLarps mediumtext, ReasonForBeingInSlowRiver text, Religion varchar(255), DarkSecret text, IntrigueSuggestions text, OtherInformation text, PersonsId int(11) NOT NULL, GroupsId int(11) NOT NULL, WealthsId int(11) NOT NULL, OriginsId int(11) NOT NULL, PRIMARY KEY (Id));
CREATE TABLE Groups (Id int(11) NOT NULL AUTO_INCREMENT, Name varchar(255) NOT NULL, Email varchar(255) NOT NULL, GroupLeaderName varchar(255) NOT NULL, `Approximate NumberOfMemebers` int(10) NOT NULL, NeedFireplace tinyint(1) NOT NULL, Friends text, Enemies text, WantIntrigue tinyint(1) NOT NULL, Descrption text NOT NULL, IntrigueIdeas text, OtherInformation text, WealthsId int(11) NOT NULL, OriginsId int(11) NOT NULL, PRIMARY KEY (Id));
CREATE TABLE LARPs (id int(11) NOT NULL AUTO_INCREMENT, Name varchar(255) NOT NULL, Abbreviation varchar(10) NOT NULL, TagLine varchar(255), Startdate date NOT NULL, EndDate date NOT NULL, MaxParticipants int(11) NOT NULL, LatestRegistrationDate date, StartTimeLARPTime datetime NULL, EndTimeLARPTime datetime NULL, PRIMARY KEY (id));
CREATE TABLE Houses (Id int(11) NOT NULL AUTO_INCREMENT, Name varchar(255) NOT NULL, NumberOfBeds int(10) NOT NULL, Information text NOT NULL, PRIMARY KEY (Id));
CREATE TABLE Interests (Id int(11) NOT NULL AUTO_INCREMENT, Name varchar(255) NOT NULL, Description text NOT NULL, Active tinyint(1) DEFAULT 1 NOT NULL, SortOrder int(11), PRIMARY KEY (Id));
CREATE TABLE Groups_Interests (InterestsId int(11) NOT NULL, GroupsId int(11) NOT NULL, PRIMARY KEY (InterestsId, GroupsId));
CREATE TABLE Characters_Interests (CharactersId int(11) NOT NULL, InterestsId int(11) NOT NULL, PRIMARY KEY (CharactersId, InterestsId));
CREATE TABLE LARPs_Characters (LARPsid int(11) NOT NULL, CharactersId int(11) NOT NULL, RegisteredDate datetime NULL, Approved date, Intrigue text, WhatHappened text, WhatHeppendToOthers text, StartingMoney int(11), EndingMoney int(11), Result text, PRIMARY KEY (LARPsid, CharactersId));
CREATE TABLE LarperTypes (Id int(11) NOT NULL AUTO_INCREMENT, Name varchar(255) NOT NULL, Description text NOT NULL, Active tinyint(1) DEFAULT 1 NOT NULL, SortOrder int(11), PRIMARY KEY (Id));
CREATE TABLE IntrigueTypes (Id int(11) NOT NULL AUTO_INCREMENT, Name varchar(255) NOT NULL, Description text NOT NULL, Active tinyint(111) DEFAULT 1 NOT NULL, SortOrder int(11), PRIMARY KEY (Id));
CREATE TABLE HouseCaretakers (AdditionalPlayers int(10) NOT NULL, LARPid int(11) NOT NULL, HouseId int(11) NOT NULL, PersonId int(11) NOT NULL);
CREATE TABLE Experiences (Id int(11) NOT NULL AUTO_INCREMENT, Name varchar(255) NOT NULL, Description text NOT NULL, Active tinyint(1) DEFAULT 1 NOT NULL, SortOrder int(11), PRIMARY KEY (Id));
CREATE TABLE HousingRequests (Id int(11) NOT NULL AUTO_INCREMENT, Name varchar(255) NOT NULL, Description text NOT NULL, Active tinyint(1) DEFAULT 1 NOT NULL, SortOrder int(11), PRIMARY KEY (Id));
CREATE TABLE TypesOfFood (Id int(11) NOT NULL AUTO_INCREMENT, Name varchar(255) NOT NULL, Description text, Active tinyint(1) DEFAULT 1 NOT NULL, SortOrder int(11), PRIMARY KEY (Id));
CREATE TABLE Wealths (Id int(11) NOT NULL AUTO_INCREMENT, Name varchar(255) NOT NULL, Description text NOT NULL, Active tinyint(1) DEFAULT 1 NOT NULL, SortOrder int(11), PRIMARY KEY (Id));
CREATE TABLE Telegrams (Id int(11) NOT NULL AUTO_INCREMENT, Deliverytime datetime NOT NULL, Sender varchar(255) NOT NULL, SenderCity varchar(255) NOT NULL, Reciever varchar(255) NOT NULL, RecieverCity varchar(255) NOT NULL, Message text NOT NULL, OrganizerNotes text, LARPsid int(11) NOT NULL, PRIMARY KEY (Id));
CREATE TABLE Origins (Id int(11) NOT NULL AUTO_INCREMENT, Name varchar(255) NOT NULL, Description text NOT NULL, Active tinyint(1) DEFAULT 1 NOT NULL, SortOrder int(11), PRIMARY KEY (Id));
CREATE TABLE TitleDeeds (Id int(11) NOT NULL AUTO_INCREMENT, Name varchar(255) NOT NULL, Location varchar(255) NOT NULL, Tradeable tinyint(1), PRIMARY KEY (Id));
CREATE TABLE TitleDeeds_Characters (TitleDeedsId int(11) NOT NULL, CharactersId int(11) NOT NULL, PRIMARY KEY (TitleDeedsId, CharactersId));
CREATE TABLE Resources (Id int(11) NOT NULL AUTO_INCREMENT, Name varchar(255), UnitSingular varchar(255), UnitPlural varchar(255), PriceSlowRiver int(11), PriceJunkCity int(11), PRIMARY KEY (Id));
CREATE TABLE Resources_TitleDeeds (ResourcesId int(11) NOT NULL, TitleDeedsId int(11) NOT NULL, Quantity int(11), PRIMARY KEY (ResourcesId, TitleDeedsId));
CREATE TABLE Housing (LARPid int(11) NOT NULL, PersonId int(11) NOT NULL, HouseId int(11) NOT NULL);
CREATE TABLE OfficialTypes (Id int(11) NOT NULL AUTO_INCREMENT, Name varchar(255) NOT NULL, Description text NOT NULL, Active tinyint(1) DEFAULT 1 NOT NULL, SortOrder int(11), PRIMARY KEY (Id));
CREATE TABLE OfficialTypes_Persons (OfficialTypesId int(11) NOT NULL, PersonsId int(11) NOT NULL, PRIMARY KEY (OfficialTypesId, PersonsId));
CREATE TABLE LARPDesires (Id int(11) NOT NULL AUTO_INCREMENT, NPCDesire varchar(255), PersonsId int(11) NOT NULL, LARPsid int(11) NOT NULL, PRIMARY KEY (Id));
CREATE TABLE Registrations (Id int(11) NOT NULL AUTO_INCREMENT, LARPsid int(11) NOT NULL, PersonsId int(11) NOT NULL, Payed date, Amount int(11), NotComing tinyint(1), ToBeRefunded tinyint(1), IsOfficial tinyint(1) NOT NULL, HousingRequestsId int(11) NOT NULL, PRIMARY KEY (Id));
CREATE TABLE IntrigueTypes_LARPDesires (IntrigueTypesId int(11) NOT NULL, LARPDesiresId int(11) NOT NULL, PRIMARY KEY (IntrigueTypesId, LARPDesiresId));
CREATE TABLE TitleDeedResults (TitleDeedsId int(11) NOT NULL, LARPsid int(11) NOT NULL, Result text);
CREATE TABLE LARPs_Groups (GroupsId int(11) NOT NULL, LARPsid int(11) NOT NULL, Intrigue text, HousingRequestsId int(11) NOT NULL, PRIMARY KEY (GroupsId, LARPsid));
CREATE TABLE NormalAllergyTypes (Id int(11) NOT NULL AUTO_INCREMENT, Name varchar(255) NOT NULL, Description text, Active tinyint(1) DEFAULT 1 NOT NULL, SortOrder int(11), PRIMARY KEY (Id));
CREATE TABLE NormalAllergyTypes_Persons (NormalAllergyTypesId int(11) NOT NULL, PersonsId int(11) NOT NULL, PRIMARY KEY (NormalAllergyTypesId, PersonsId));
ALTER TABLE Characters ADD CONSTRAINT IsPlayedBy FOREIGN KEY (PersonsId) REFERENCES Persons (Id);
ALTER TABLE Characters ADD CONSTRAINT `Ingår i` FOREIGN KEY (GroupsId) REFERENCES Groups (Id);
ALTER TABLE Groups_Interests ADD CONSTRAINT FKGroups_Int336092 FOREIGN KEY (GroupsId) REFERENCES Groups (Id);
ALTER TABLE Groups_Interests ADD CONSTRAINT FKGroups_Int123769 FOREIGN KEY (InterestsId) REFERENCES Interests (Id);
ALTER TABLE Characters_Interests ADD CONSTRAINT FKCharacters218465 FOREIGN KEY (CharactersId) REFERENCES Characters (Id);
ALTER TABLE Characters_Interests ADD CONSTRAINT FKCharacters80308 FOREIGN KEY (InterestsId) REFERENCES Interests (Id);
ALTER TABLE LARPs_Characters ADD CONSTRAINT FKLARPs_Char168714 FOREIGN KEY (LARPsid) REFERENCES LARPs (id);
ALTER TABLE LARPs_Characters ADD CONSTRAINT FKLARPs_Char906726 FOREIGN KEY (CharactersId) REFERENCES Characters (Id);
ALTER TABLE HouseCaretakers ADD CONSTRAINT FKHouseCaret105877 FOREIGN KEY (HouseId) REFERENCES Houses (Id);
ALTER TABLE HouseCaretakers ADD CONSTRAINT FKHouseCaret140780 FOREIGN KEY (LARPid) REFERENCES LARPs (id);
ALTER TABLE HouseCaretakers ADD CONSTRAINT FKHouseCaret695580 FOREIGN KEY (PersonId) REFERENCES Persons (Id);
ALTER TABLE Persons ADD CONSTRAINT FKPersons68576 FOREIGN KEY (ExperiencesId) REFERENCES Experiences (Id);
ALTER TABLE Persons ADD CONSTRAINT FKPersons636407 FOREIGN KEY (TypesOfFoodId) REFERENCES TypesOfFood (Id);
ALTER TABLE Characters ADD CONSTRAINT FKCharacters909855 FOREIGN KEY (WealthsId) REFERENCES Wealths (Id);
ALTER TABLE Groups ADD CONSTRAINT FKGroups545479 FOREIGN KEY (WealthsId) REFERENCES Wealths (Id);
ALTER TABLE Characters ADD CONSTRAINT FKCharacters806868 FOREIGN KEY (OriginsId) REFERENCES Origins (Id);
ALTER TABLE Groups ADD CONSTRAINT FKGroups290613 FOREIGN KEY (OriginsId) REFERENCES Origins (Id);
ALTER TABLE TitleDeeds_Characters ADD CONSTRAINT FKTitleDeeds278652 FOREIGN KEY (TitleDeedsId) REFERENCES TitleDeeds (Id);
ALTER TABLE TitleDeeds_Characters ADD CONSTRAINT FKTitleDeeds173055 FOREIGN KEY (CharactersId) REFERENCES Characters (Id);
ALTER TABLE Resources_TitleDeeds ADD CONSTRAINT FKResources_155504 FOREIGN KEY (ResourcesId) REFERENCES Resources (Id);
ALTER TABLE Resources_TitleDeeds ADD CONSTRAINT FKResources_558374 FOREIGN KEY (TitleDeedsId) REFERENCES TitleDeeds (Id);
ALTER TABLE Housing ADD CONSTRAINT FKHousing783378 FOREIGN KEY (LARPid) REFERENCES LARPs (id);
ALTER TABLE Housing ADD CONSTRAINT FKHousing771421 FOREIGN KEY (PersonId) REFERENCES Persons (Id);
ALTER TABLE Housing ADD CONSTRAINT FKHousing181718 FOREIGN KEY (HouseId) REFERENCES Houses (Id);
ALTER TABLE OfficialTypes_Persons ADD CONSTRAINT FKOfficialTy951218 FOREIGN KEY (OfficialTypesId) REFERENCES OfficialTypes (Id);
ALTER TABLE OfficialTypes_Persons ADD CONSTRAINT FKOfficialTy362365 FOREIGN KEY (PersonsId) REFERENCES Persons (Id);
ALTER TABLE LARPDesires ADD CONSTRAINT FKLARPDesire179515 FOREIGN KEY (PersonsId) REFERENCES Persons (Id);
ALTER TABLE LARPDesires ADD CONSTRAINT FKLARPDesire533490 FOREIGN KEY (LARPsid) REFERENCES LARPs (id);
ALTER TABLE Registrations ADD CONSTRAINT FKRegistrati802575 FOREIGN KEY (LARPsid) REFERENCES LARPs (id);
ALTER TABLE Registrations ADD CONSTRAINT FKRegistrati456009 FOREIGN KEY (PersonsId) REFERENCES Persons (Id);
ALTER TABLE Persons ADD CONSTRAINT FKPersons801176 FOREIGN KEY (LarperTypesId) REFERENCES LarperTypes (Id);
ALTER TABLE IntrigueTypes_LARPDesires ADD CONSTRAINT FKIntrigueTy526140 FOREIGN KEY (IntrigueTypesId) REFERENCES IntrigueTypes (Id);
ALTER TABLE IntrigueTypes_LARPDesires ADD CONSTRAINT FKIntrigueTy151027 FOREIGN KEY (LARPDesiresId) REFERENCES LARPDesires (Id);
ALTER TABLE TitleDeedResults ADD CONSTRAINT FKTitleDeedR978883 FOREIGN KEY (TitleDeedsId) REFERENCES TitleDeeds (Id);
ALTER TABLE TitleDeedResults ADD CONSTRAINT FKTitleDeedR811668 FOREIGN KEY (LARPsid) REFERENCES LARPs (id);
ALTER TABLE LARPs_Groups ADD CONSTRAINT FKLARPs_Grou960173 FOREIGN KEY (GroupsId) REFERENCES Groups (Id);
ALTER TABLE LARPs_Groups ADD CONSTRAINT FKLARPs_Grou309548 FOREIGN KEY (LARPsid) REFERENCES LARPs (id);
ALTER TABLE NormalAllergyTypes_Persons ADD CONSTRAINT FKNormalAlle729354 FOREIGN KEY (NormalAllergyTypesId) REFERENCES NormalAllergyTypes (Id);
ALTER TABLE NormalAllergyTypes_Persons ADD CONSTRAINT FKNormalAlle94824 FOREIGN KEY (PersonsId) REFERENCES Persons (Id);
ALTER TABLE LARPs_Groups ADD CONSTRAINT FKLARPs_Grou449905 FOREIGN KEY (HousingRequestsId) REFERENCES HousingRequests (Id);
ALTER TABLE Registrations ADD CONSTRAINT FKRegistrati956877 FOREIGN KEY (HousingRequestsId) REFERENCES HousingRequests (Id);
ALTER TABLE Telegrams ADD CONSTRAINT FKTelegrams693597 FOREIGN KEY (LARPsid) REFERENCES LARPs (id);
