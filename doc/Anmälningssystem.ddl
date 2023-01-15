CREATE TABLE Person (Id int(11) NOT NULL AUTO_INCREMENT, Name varchar(255) NOT NULL, SocialSecurityNumber varchar(255) NOT NULL, PhoneNumber varchar(255), EmergencyContact text, Email varchar(255) NOT NULL, FoodAllergiesOther text, TypeOfLarperComment text, OtherInformation text, ExperienceId int(11) NOT NULL, TypeOfFoodId int(11) NOT NULL, LarperTypeId int(11) NOT NULL, UserId int(11) NOT NULL, NotAcceptableIntrigues varchar(255), PRIMARY KEY (Id));
CREATE TABLE Role (Id int(11) NOT NULL AUTO_INCREMENT, Name varchar(255) NOT NULL, IsNPC tinyint(1) NOT NULL, Profession varchar(255) NOT NULL, Description mediumtext NOT NULL, PreviousLarps mediumtext, ReasonForBeingInSlowRiver text NOT NULL, Religion varchar(255), DarkSecret text NOT NULL, DarkSecretIntrigueIdeas varchar(255) NOT NULL, IntrigueSuggestions text, NotAcceptableIntrigues varchar(255), OtherInformation text, PersonId int(11) NOT NULL, GroupId int(11) NOT NULL, WealthId int(11) NOT NULL, PlaceOfResidenceId int(11) NOT NULL, Photo longblob, Birthplace varchar(255) NOT NULL, CharactersWithRelations text, PRIMARY KEY (Id));
CREATE TABLE `Group` (Id int(11) NOT NULL AUTO_INCREMENT, Name varchar(255) NOT NULL, ApproximateNumberOfMembers int(10) NOT NULL, NeedFireplace tinyint(1) NOT NULL, Friends text, Description text NOT NULL, Enemies text, IntrigueIdeas text, OtherInformation text, WealthId int(11) NOT NULL, PlaceOfResidenceId int(11) NOT NULL, PersonId int(11) NOT NULL, PRIMARY KEY (Id));
CREATE TABLE LARP (Id int(11) NOT NULL AUTO_INCREMENT, Name varchar(255) NOT NULL, Abbreviation varchar(10) NOT NULL, TagLine varchar(255), StartDate datetime NOT NULL, EndDate datetime NOT NULL, MaxParticipants int(11) NOT NULL, LatestRegistrationDate date, StartTimeLARPTime datetime NULL, EndTimeLARPTime datetime NULL, PRIMARY KEY (Id));
CREATE TABLE House (Id int(11) NOT NULL AUTO_INCREMENT, Name varchar(255) NOT NULL, NumberOfBeds int(10) NOT NULL, Information text NOT NULL, PRIMARY KEY (Id));
CREATE TABLE LARP_Role (LARPId int(11) NOT NULL, RoleId int(11) NOT NULL, Approved date, Intrigue text, WhatHappened text, WhatHappendToOthers text, StartingMoney int(11), EndingMoney int(11), Result text, PRIMARY KEY (LARPId, RoleId));
CREATE TABLE LarperType (Id int(11) NOT NULL AUTO_INCREMENT, Name varchar(255) NOT NULL, Description text NOT NULL, Active tinyint(1) DEFAULT 1 NOT NULL, SortOrder int(11), PRIMARY KEY (Id));
CREATE TABLE IntrigueType (Id int(11) NOT NULL AUTO_INCREMENT, Name varchar(255) NOT NULL, Description text NOT NULL, Active tinyint(111) DEFAULT 1 NOT NULL, SortOrder int(11), PRIMARY KEY (Id));
CREATE TABLE HouseCaretaker (AdditionalPlayers int(10) NOT NULL, LARPId int(11) NOT NULL, HouseId int(11) NOT NULL, PersonId int(11) NOT NULL);
CREATE TABLE Experience (Id int(11) NOT NULL AUTO_INCREMENT, Name varchar(255) NOT NULL, Description text NOT NULL, Active tinyint(1) DEFAULT 1 NOT NULL, SortOrder int(11), PRIMARY KEY (Id));
CREATE TABLE HousingRequest (Id int(11) NOT NULL AUTO_INCREMENT, Name varchar(255) NOT NULL, Description text NOT NULL, Active tinyint(1) DEFAULT 1 NOT NULL, SortOrder int(11), PRIMARY KEY (Id));
CREATE TABLE TypeOfFood (Id int(11) NOT NULL AUTO_INCREMENT, Name varchar(255) NOT NULL, Description text, Active tinyint(1) DEFAULT 1 NOT NULL, SortOrder int(11), PRIMARY KEY (Id));
CREATE TABLE Wealth (Id int(11) NOT NULL AUTO_INCREMENT, Name varchar(255) NOT NULL, Description text NOT NULL, Active tinyint(1) DEFAULT 1 NOT NULL, SortOrder int(11), PRIMARY KEY (Id));
CREATE TABLE Telegram (Id int(11) NOT NULL AUTO_INCREMENT, Deliverytime datetime NOT NULL, Sender varchar(255) NOT NULL, SenderCity varchar(255) NOT NULL, Reciever varchar(255) NOT NULL, RecieverCity varchar(255) NOT NULL, Message text NOT NULL, OrganizerNotes text, LARPId int(11) NOT NULL, PRIMARY KEY (Id));
CREATE TABLE PlaceOfResidence (Id int(11) NOT NULL AUTO_INCREMENT, Name varchar(255) NOT NULL, Description text NOT NULL, Active tinyint(1) DEFAULT 1 NOT NULL, SortOrder int(11), PRIMARY KEY (Id));
CREATE TABLE TitleDeed (Id int(11) NOT NULL AUTO_INCREMENT, Name varchar(255) NOT NULL, Location varchar(255) NOT NULL, Tradeable tinyint(1), IsTradingPost tinyint(1) NOT NULL, PRIMARY KEY (Id));
CREATE TABLE TitleDeed_Role (TitleDeedId int(11) NOT NULL, RoleId int(11) NOT NULL, PRIMARY KEY (TitleDeedId, RoleId));
CREATE TABLE Resource (Id int(11) NOT NULL AUTO_INCREMENT, Name varchar(255), UnitSingular varchar(255), UnitPlural varchar(255), PriceSlowRiver int(11), PriceJunkCity int(11), IsRare tinyint(1) NOT NULL, PRIMARY KEY (Id));
CREATE TABLE Resource_TitleDeed (ResourceId int(11) NOT NULL, TitleDeedId int(11) NOT NULL, Quantity int(11), QuantityForUpgrade int(11), PRIMARY KEY (ResourceId, TitleDeedId));
CREATE TABLE Housing (LARPId int(11) NOT NULL, PersonId int(11) NOT NULL, HouseId int(11) NOT NULL);
CREATE TABLE OfficialType (Id int(11) NOT NULL AUTO_INCREMENT, Name varchar(255) NOT NULL, Description text NOT NULL, Active tinyint(1) DEFAULT 1 NOT NULL, SortOrder int(11), PRIMARY KEY (Id));
CREATE TABLE OfficialType_Person (OfficialTypeId int(11) NOT NULL, RegistrationId int(11) NOT NULL, PRIMARY KEY (OfficialTypeId, RegistrationId));
CREATE TABLE Registration (Id int(11) NOT NULL AUTO_INCREMENT, LARPId int(11) NOT NULL, PersonId int(11) NOT NULL, RegisteredAt datetime NULL, PaymentReference varchar(255), AmountToPay int(11), AmountPayed int(11), Payed date, IsMember tinyint(1), MembershipCheckedAt datetime NULL, NotComing tinyint(1), ToBeRefunded tinyint(1), RefundDate date, IsOfficial tinyint(1) NOT NULL, NPCDesire varchar(255), HousingRequestId int(11) NOT NULL, PRIMARY KEY (Id));
CREATE TABLE TitleDeedResult (TitleDeedId int(11) NOT NULL, LARPId int(11) NOT NULL, Result text);
CREATE TABLE LARP_Group (GroupId int(11) NOT NULL, LARPId int(11) NOT NULL, WantIntrigue tinyint(1) NOT NULL, Intrigue text, HousingRequestId int(11) NOT NULL, PRIMARY KEY (GroupId, LARPId));
CREATE TABLE NormalAllergyType (Id int(11) NOT NULL AUTO_INCREMENT, Name varchar(255) NOT NULL, Description text, Active tinyint(1) DEFAULT 1 NOT NULL, SortOrder int(11), PRIMARY KEY (Id));
CREATE TABLE NormalAllergyType_Person (NormalAllergyTypeId int(11) NOT NULL, PersonId int(11) NOT NULL, PRIMARY KEY (NormalAllergyTypeId, PersonId));
CREATE TABLE `User` (Id int(11) NOT NULL AUTO_INCREMENT, Email varchar(255) NOT NULL, Password varchar(255) NOT NULL, IsAdmin tinyint(1) DEFAULT 0 NOT NULL, ActivationCode varchar(255), EmailChangeCode varchar(255), PRIMARY KEY (Id));
CREATE TABLE IntrigueType_LARP_Group (LARP_GroupGroupId int(11) NOT NULL, LARP_GroupLARPId int(11) NOT NULL, IntrigueTypeId int(11) NOT NULL, PRIMARY KEY (LARP_GroupGroupId, LARP_GroupLARPId, IntrigueTypeId));
CREATE TABLE IntrigueType_LARP_Role (IntrigueTypeId int(11) NOT NULL, LARP_RoleLARPid int(11) NOT NULL, LARP_RoleRoleId int(11) NOT NULL, PRIMARY KEY (IntrigueTypeId, LARP_RoleLARPid, LARP_RoleRoleId));
CREATE TABLE Prop (Id int(11) NOT NULL AUTO_INCREMENT, Name varchar(255) NOT NULL, Description text, StorageLocation varchar(255), Image longblob, GroupId int(11), RoleId int(11), PRIMARY KEY (Id));
ALTER TABLE Role ADD CONSTRAINT IsPlayedBy FOREIGN KEY (PersonId) REFERENCES Person (Id);
ALTER TABLE Role ADD CONSTRAINT `Ingår i` FOREIGN KEY (GroupId) REFERENCES `Group` (Id);
ALTER TABLE LARP_Role ADD CONSTRAINT FKLARP_Role146219 FOREIGN KEY (LARPId) REFERENCES LARP (Id);
ALTER TABLE LARP_Role ADD CONSTRAINT FKLARP_Role421832 FOREIGN KEY (RoleId) REFERENCES Role (Id);
ALTER TABLE HouseCaretaker ADD CONSTRAINT FKHouseCaret167131 FOREIGN KEY (HouseId) REFERENCES House (Id);
ALTER TABLE HouseCaretaker ADD CONSTRAINT FKHouseCaret557191 FOREIGN KEY (LARPId) REFERENCES LARP (Id);
ALTER TABLE HouseCaretaker ADD CONSTRAINT FKHouseCaret326645 FOREIGN KEY (PersonId) REFERENCES Person (Id);
ALTER TABLE Person ADD CONSTRAINT FKPerson256526 FOREIGN KEY (ExperienceId) REFERENCES Experience (Id);
ALTER TABLE Person ADD CONSTRAINT FKPerson458285 FOREIGN KEY (TypeOfFoodId) REFERENCES TypeOfFood (Id);
ALTER TABLE Role ADD CONSTRAINT FKRole127269 FOREIGN KEY (WealthId) REFERENCES Wealth (Id);
ALTER TABLE `Group` ADD CONSTRAINT FKGroup650928 FOREIGN KEY (WealthId) REFERENCES Wealth (Id);
ALTER TABLE Role ADD CONSTRAINT FKRole409701 FOREIGN KEY (PlaceOfResidenceId) REFERENCES PlaceOfResidence (Id);
ALTER TABLE `Group` ADD CONSTRAINT FKGroup886041 FOREIGN KEY (PlaceOfResidenceId) REFERENCES PlaceOfResidence (Id);
ALTER TABLE TitleDeed_Role ADD CONSTRAINT FKTitleDeed_235065 FOREIGN KEY (TitleDeedId) REFERENCES TitleDeed (Id);
ALTER TABLE TitleDeed_Role ADD CONSTRAINT FKTitleDeed_784593 FOREIGN KEY (RoleId) REFERENCES Role (Id);
ALTER TABLE Resource_TitleDeed ADD CONSTRAINT FKResource_T569064 FOREIGN KEY (ResourceId) REFERENCES Resource (Id);
ALTER TABLE Resource_TitleDeed ADD CONSTRAINT FKResource_T990336 FOREIGN KEY (TitleDeedId) REFERENCES TitleDeed (Id);
ALTER TABLE Housing ADD CONSTRAINT FKHousing905119 FOREIGN KEY (LARPId) REFERENCES LARP (Id);
ALTER TABLE Housing ADD CONSTRAINT FKHousing135666 FOREIGN KEY (PersonId) REFERENCES Person (Id);
ALTER TABLE Housing ADD CONSTRAINT FKHousing295180 FOREIGN KEY (HouseId) REFERENCES House (Id);
ALTER TABLE OfficialType_Person ADD CONSTRAINT FKOfficialTy968435 FOREIGN KEY (OfficialTypeId) REFERENCES OfficialType (Id);
ALTER TABLE Registration ADD CONSTRAINT FKRegistrati709651 FOREIGN KEY (LARPId) REFERENCES LARP (Id);
ALTER TABLE Registration ADD CONSTRAINT FKRegistrati940197 FOREIGN KEY (PersonId) REFERENCES Person (Id);
ALTER TABLE Person ADD CONSTRAINT FKPerson858970 FOREIGN KEY (LarperTypeId) REFERENCES LarperType (Id);
ALTER TABLE TitleDeedResult ADD CONSTRAINT FKTitleDeedR124770 FOREIGN KEY (TitleDeedId) REFERENCES TitleDeed (Id);
ALTER TABLE TitleDeedResult ADD CONSTRAINT FKTitleDeedR868815 FOREIGN KEY (LARPId) REFERENCES LARP (Id);
ALTER TABLE LARP_Group ADD CONSTRAINT FKLARP_Group836318 FOREIGN KEY (GroupId) REFERENCES `Group` (Id);
ALTER TABLE LARP_Group ADD CONSTRAINT FKLARP_Group374108 FOREIGN KEY (LARPId) REFERENCES LARP (Id);
ALTER TABLE NormalAllergyType_Person ADD CONSTRAINT FKNormalAlle861454 FOREIGN KEY (NormalAllergyTypeId) REFERENCES NormalAllergyType (Id);
ALTER TABLE NormalAllergyType_Person ADD CONSTRAINT FKNormalAlle960015 FOREIGN KEY (PersonId) REFERENCES Person (Id);
ALTER TABLE LARP_Group ADD CONSTRAINT FKLARP_Group496361 FOREIGN KEY (HousingRequestId) REFERENCES HousingRequest (Id);
ALTER TABLE Registration ADD CONSTRAINT FKRegistrati831904 FOREIGN KEY (HousingRequestId) REFERENCES HousingRequest (Id);
ALTER TABLE Telegram ADD CONSTRAINT FKTelegram875373 FOREIGN KEY (LARPId) REFERENCES LARP (Id);
ALTER TABLE Person ADD CONSTRAINT FKPerson603198 FOREIGN KEY (UserId) REFERENCES `User` (Id);
ALTER TABLE `Group` ADD CONSTRAINT FKGroup964147 FOREIGN KEY (PersonId) REFERENCES Person (Id);
ALTER TABLE OfficialType_Person ADD CONSTRAINT FKOfficialTy127443 FOREIGN KEY (RegistrationId) REFERENCES Registration (Id);
ALTER TABLE IntrigueType_LARP_Group ADD CONSTRAINT FKIntrigueTy460353 FOREIGN KEY (LARP_GroupGroupId, LARP_GroupLARPId) REFERENCES LARP_Group (GroupId, LARPId);
ALTER TABLE IntrigueType_LARP_Group ADD CONSTRAINT FKIntrigueTy716976 FOREIGN KEY (IntrigueTypeId) REFERENCES IntrigueType (Id);
ALTER TABLE IntrigueType_LARP_Role ADD CONSTRAINT FKIntrigueTy819563 FOREIGN KEY (IntrigueTypeId) REFERENCES IntrigueType (Id);
ALTER TABLE IntrigueType_LARP_Role ADD CONSTRAINT FKIntrigueTy437959 FOREIGN KEY (LARP_RoleLARPid, LARP_RoleRoleId) REFERENCES LARP_Role (LARPId, RoleId);
ALTER TABLE Prop ADD CONSTRAINT FKProp658852 FOREIGN KEY (GroupId) REFERENCES `Group` (Id);
ALTER TABLE Prop ADD CONSTRAINT FKProp499335 FOREIGN KEY (RoleId) REFERENCES Role (Id);
