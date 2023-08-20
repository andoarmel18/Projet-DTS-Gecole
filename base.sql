/*
SQLyog Enterprise - MySQL GUI v8.1 
MySQL - 5.7.36 : Database - gestionecl
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`gestionecl` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `gestionecl`;

/*Table structure for table `absence` */

DROP TABLE IF EXISTS `absence`;

CREATE TABLE `absence` (
  `idEleve` int(20) NOT NULL,
  `idMatiere` int(20) NOT NULL,
  `dateAbs` date DEFAULT NULL,
  `heureAbs` time DEFAULT NULL,
  PRIMARY KEY (`idEleve`,`idMatiere`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `absence` */

/*Table structure for table `admin` */

DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `idAdmin` int(20) NOT NULL AUTO_INCREMENT,
  `photo` varchar(100) DEFAULT NULL,
  `nomAdmin` varchar(255) NOT NULL,
  `prenomAdmin` varchar(255) NOT NULL,
  `dateNaiss` date NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `CIN` varchar(255) NOT NULL,
  PRIMARY KEY (`idAdmin`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `admin` */

insert  into `admin`(idAdmin,photo,nomAdmin,prenomAdmin,dateNaiss,mdp,CIN) values (4,'gallery-img1.png','Millenium','Ando Armel','2022-08-19','andoniaina','0322281136');

/*Table structure for table `annee` */

DROP TABLE IF EXISTS `annee`;

CREATE TABLE `annee` (
  `idAnnee` int(10) NOT NULL AUTO_INCREMENT,
  `annee` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`idAnnee`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `annee` */

insert  into `annee`(idAnnee,annee) values (1,'1er Année'),(2,'2eme Année'),(3,'3eme Année'),(4,'4eme Année'),(5,'5eme Année');

/*Table structure for table `anneesemestre` */

DROP TABLE IF EXISTS `anneesemestre`;

CREATE TABLE `anneesemestre` (
  `id_a_s` int(20) NOT NULL AUTO_INCREMENT,
  `idAnnee` int(20) NOT NULL,
  `idSemestre` int(20) NOT NULL,
  PRIMARY KEY (`id_a_s`,`idAnnee`,`idSemestre`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `anneesemestre` */

/*Table structure for table `classe` */

DROP TABLE IF EXISTS `classe`;

CREATE TABLE `classe` (
  `idClasse` int(20) NOT NULL AUTO_INCREMENT,
  `nomClasse` varchar(100) NOT NULL,
  `idFiliere` int(20) NOT NULL,
  `idAnnee` int(20) DEFAULT NULL,
  `idProf` int(20) DEFAULT NULL,
  PRIMARY KEY (`idClasse`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

/*Data for the table `classe` */

insert  into `classe`(idClasse,nomClasse,idFiliere,idAnnee,idProf) values (11,'L1L2A',1,1,14),(8,'L1L2A',3,1,1),(7,'L2L3A',1,2,5),(15,'L1L2A',2,1,1),(13,'L1L3A',3,1,1),(17,'L1L3A',2,1,5);

/*Table structure for table `conmdp` */

DROP TABLE IF EXISTS `conmdp`;

CREATE TABLE `conmdp` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `mdpconfirm` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=152 DEFAULT CHARSET=latin1;

/*Data for the table `conmdp` */

insert  into `conmdp`(id,mdpconfirm) values (145,'andoniaina'),(146,'andoniaina'),(147,'andoniaina'),(148,'andoniana'),(149,'andoniaina*'),(150,'andoniaina'),(151,'andoniaina');

/*Table structure for table `ecolage` */

DROP TABLE IF EXISTS `ecolage`;

CREATE TABLE `ecolage` (
  `idEcolage` int(20) NOT NULL AUTO_INCREMENT,
  `montant` int(20) DEFAULT NULL,
  `dateP` varchar(100) DEFAULT NULL,
  `idMois` int(3) DEFAULT NULL,
  `idAnnee` int(3) DEFAULT NULL,
  `matricule` int(20) NOT NULL,
  PRIMARY KEY (`idEcolage`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

/*Data for the table `ecolage` */

insert  into `ecolage`(idEcolage,montant,dateP,idMois,idAnnee,matricule) values (34,90000,'18-August-2022',12,1,4005);

/*Table structure for table `emploi_du_temp` */

DROP TABLE IF EXISTS `emploi_du_temp`;

CREATE TABLE `emploi_du_temp` (
  `idEdt` int(100) NOT NULL AUTO_INCREMENT,
  `idProfMat` int(100) DEFAULT NULL,
  `idClasse` int(100) NOT NULL,
  `idHeure` int(250) DEFAULT NULL,
  `idJour` int(250) DEFAULT NULL,
  PRIMARY KEY (`idEdt`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

/*Data for the table `emploi_du_temp` */

/*Table structure for table `etudiant` */

DROP TABLE IF EXISTS `etudiant`;

CREATE TABLE `etudiant` (
  `photo` varchar(500) DEFAULT NULL,
  `matricule` int(10) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `sexe` varchar(255) DEFAULT NULL,
  `dateNaiss` date NOT NULL,
  `lieuNaiss` varchar(255) DEFAULT NULL,
  `numero` varchar(20) NOT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `pere` varchar(255) DEFAULT NULL,
  `mere` varchar(255) DEFAULT NULL,
  `idClasse` int(20) DEFAULT '27',
  PRIMARY KEY (`matricule`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `etudiant` */

insert  into `etudiant`(photo,matricule,nom,prenom,sexe,dateNaiss,lieuNaiss,numero,mail,adresse,pere,mere,idClasse) values ('page1-img5.jpg',2,'Camera','DGRDDD','feminin','2022-06-22','fdsdh','23545656','aeffer@fdfg.dfsr','gergd','FGSGFHS','dfqfrg',7),('a2.jpg',4005,'RAHERIHARIJAONA','Andoniaina Armel','masculin','2001-04-18','Mahitsy','0322281136','andoarmel18@gmail.com','Lot B 107 Mahitsy','Haja Alain','Harisoa Volahanta',8),('4.jpg',60,'andryrer','QWERTY','feminin','2022-06-29','HTHDYH','1223','adzrf@gdr.sdgf','FGDRGSRGQRG','ergerg','RASOA',11),('1s.jpg',12,'DFS','Nikon','feminin','2022-06-13','HTHDYH','23545656','adzrf@gdr.sdgf','dferfzerg','DGDFGRG','EGQREGTRYR',13),('1.jpg',234,'RAH','FGFHSFJ','autre','2022-06-22','fdsdh','12204958','adzrf@gdr.sdgf','RGDGS','DGDFGRG','EGQREGTRYR',15),('5.jpg',657,'FGDFG','AZERTY','masculin','2022-06-21','DGTR','23545656','TOKYO@GMAIL.COM','RGDGS','ergerg','RASOAZANANY',13),('3s.jpg',9999,'Paris','Ville','autre','2022-07-18','Paris','34242335','adzrf@gdr.sdgf','FGESRG','FGSGFHS','dfqfrg',13),('a1.jpg',9991,'FGDFG','Canon','masculin','2022-07-25','dzef','1232343','andoarmel18@gmail.com','gergd','FGSGFHS','efzer',13),('a1.jpg',1323,'YGUYG','YUGOUYGO','masculin','2022-07-19','YGUYGyu','yugiuyg','uiyguiygy','uygiuygiuy','yuiygiyguiyg','yugyuguiyg',7),('banner.jpg',11212,'FTFY','YTFTFYT','masculin','2022-07-19','UHIU','32445234','IOGUOGYU','UYGOUYGO','YUGIFUY','YFTYTFUT',7),('slide2.jpg',13245,'BUZZ','Robot','autre','2022-07-12','New York','10101010','robot@gmail.com','jupitÃ¨re','developpeur','hackeur',17),('gallery-img2.png',2334242,'EOZEUH','HIUEHIU','masculin','2022-08-03','DFEIO','IOJOIJ','OIJOIJ','IOIJOIJ','OIJOJ','IOJOIJ',8),('bg.png',475475,'Mainty','BE','masculin','2022-08-01','Boulangerie','1223','adzrf@gdr.sdgf','YUGUY','ertert','RASOAZANANY',27);

/*Table structure for table `filiere` */

DROP TABLE IF EXISTS `filiere`;

CREATE TABLE `filiere` (
  `idFiliere` int(255) NOT NULL AUTO_INCREMENT,
  `nomFiliere` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idFiliere`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `filiere` */

insert  into `filiere`(idFiliere,nomFiliere) values (1,'Informatique'),(2,'Gestion'),(3,'Tronc Commun');

/*Table structure for table `heure` */

DROP TABLE IF EXISTS `heure`;

CREATE TABLE `heure` (
  `idHeure` int(100) NOT NULL AUTO_INCREMENT,
  `heure` varchar(200) NOT NULL,
  PRIMARY KEY (`idHeure`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `heure` */

insert  into `heure`(idHeure,heure) values (1,'7-8'),(2,'8-9'),(3,'9-10'),(4,'10-11'),(5,'11-12'),(6,'12-13'),(7,'13-14'),(8,'14-15'),(9,'15-16'),(10,'16-17'),(11,'17-18');

/*Table structure for table `jour` */

DROP TABLE IF EXISTS `jour`;

CREATE TABLE `jour` (
  `idJour` int(100) NOT NULL AUTO_INCREMENT,
  `jour` varchar(100) NOT NULL,
  PRIMARY KEY (`idJour`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `jour` */

insert  into `jour`(idJour,jour) values (1,'Lundi'),(2,'mardi'),(3,'mercredi'),(4,'jeudi'),(5,'vendredi'),(6,'samedi');

/*Table structure for table `matiere` */

DROP TABLE IF EXISTS `matiere`;

CREATE TABLE `matiere` (
  `idMatiere` int(20) NOT NULL AUTO_INCREMENT,
  `nomMatiere` varchar(255) NOT NULL,
  `coeuf` int(10) DEFAULT NULL,
  `idFiliere` int(20) DEFAULT NULL,
  `idAnnee` int(20) DEFAULT NULL,
  PRIMARY KEY (`idMatiere`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

/*Data for the table `matiere` */

insert  into `matiere`(idMatiere,nomMatiere,coeuf,idFiliere,idAnnee) values (1,'Java',2,1,1),(2,'PHP',2,1,1),(3,'Anglais',1,3,1),(4,'TCE',2,3,1),(5,'UML',2,3,1),(8,'Linux',2,1,2),(9,'POO',2,1,2),(10,'Tech Web',2,1,2),(14,'Marketing',2,2,3),(15,'MATH',3,1,3),(27,'Mandarin',2,2,5),(26,'Access',2,2,4),(25,'Python',3,1,4),(18,'VB.net',2,1,3),(19,'Reseaux',2,1,3),(30,'Access',2,2,1),(28,'POO',4,1,5),(22,'Bureautique',2,2,2);

/*Table structure for table `mois` */

DROP TABLE IF EXISTS `mois`;

CREATE TABLE `mois` (
  `idMois` int(10) NOT NULL AUTO_INCREMENT,
  `mois` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`idMois`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `mois` */

insert  into `mois`(idMois,mois) values (1,'Janvier'),(2,'Fevrier'),(3,'Mars'),(4,'Avril'),(5,'Mai'),(6,'Juin'),(7,'Juillet'),(8,'Aout'),(9,'Septembre'),(10,'Octobre'),(11,'Novembre'),(12,'Decembre');

/*Table structure for table `note` */

DROP TABLE IF EXISTS `note`;

CREATE TABLE `note` (
  `matricule` int(20) NOT NULL,
  `idMatiere` int(20) NOT NULL,
  `note` varchar(10) DEFAULT NULL,
  `idNote` int(11) NOT NULL AUTO_INCREMENT,
  `semestre` int(2) NOT NULL,
  `idClasse` int(10) DEFAULT NULL,
  PRIMARY KEY (`idNote`)
) ENGINE=MyISAM AUTO_INCREMENT=692 DEFAULT CHARSET=latin1;

/*Data for the table `note` */

insert  into `note`(matricule,idMatiere,note,idNote,semestre,idClasse) values (4005,3,'12',660,1,8),(4005,4,'11',661,1,8),(4005,5,'13',662,1,8),(12,4,'11',669,2,13),(4005,3,'11',664,2,8),(4005,4,'12',665,2,8),(4005,5,'14',666,2,8),(12,3,'12',668,2,13),(12,5,'10',670,2,13),(657,3,'11',671,2,13),(657,4,'14',672,2,13),(657,5,'1111',673,2,13),(9999,3,'15',674,2,13),(9999,4,'13',675,2,13),(9999,5,'9999',676,2,13),(9991,3,'18',677,2,13),(9991,4,'12',678,2,13),(9991,5,'11',679,2,13),(12,3,'12',680,1,13),(12,4,'45',681,1,13),(12,5,'5',682,1,13),(657,4,'4',683,1,13),(657,5,'4',684,1,13),(9999,3,'12',685,1,13),(9999,4,'5',686,1,13),(9999,5,'5',687,1,13),(9991,3,'45',688,1,13),(9991,4,'4',689,1,13),(9991,5,'4',690,1,13),(60,1,'11',691,1,11);

/*Table structure for table `prof` */

DROP TABLE IF EXISTS `prof`;

CREATE TABLE `prof` (
  `idProf` int(20) NOT NULL AUTO_INCREMENT,
  `nomProf` varchar(255) NOT NULL,
  `prenomProf` varchar(255) NOT NULL,
  `sexe` varchar(22) NOT NULL,
  `numero` varchar(200) NOT NULL,
  `mail` varchar(200) NOT NULL,
  PRIMARY KEY (`idProf`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Data for the table `prof` */

insert  into `prof`(idProf,nomProf,prenomProf,sexe,numero,mail) values (1,'ANDRIA','Jean','Masculin','34234','zded'),(2,'ANDRIA','Mamonjy','Masculin','34234','zded'),(3,'RAKOTO','Jean','Masculin','34234','zded'),(4,'RABE','Safary','Masculin','34234','zded'),(5,'RASOA','Zanany','Feminin','34234','zded'),(9,'KEMBA','Liza','Feminin','34234','zded'),(11,'RALALA','Noro','Feminin','34234','zded'),(12,'RAZAKA','Lava','Masculin','34234','zded'),(13,'TITEUF','Koto','Masculin','34234','zded'),(14,'ANDO','Armel','Masculin','34234','zded');

/*Table structure for table `profmat` */

DROP TABLE IF EXISTS `profmat`;

CREATE TABLE `profmat` (
  `idProfMat` int(50) NOT NULL AUTO_INCREMENT,
  `idProf` int(50) NOT NULL,
  `idMatiere` int(50) NOT NULL,
  PRIMARY KEY (`idProfMat`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `profmat` */

insert  into `profmat`(idProfMat,idProf,idMatiere) values (1,1,9),(2,2,4),(3,1,11),(4,3,3),(7,5,6),(6,4,7),(8,9,8),(9,12,1),(10,14,8),(11,11,2);

/*Table structure for table `semestriel` */

DROP TABLE IF EXISTS `semestriel`;

CREATE TABLE `semestriel` (
  `idSemestre` int(250) NOT NULL AUTO_INCREMENT,
  `nomSemestre` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idSemestre`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `semestriel` */

insert  into `semestriel`(idSemestre,nomSemestre) values (1,'1er semestre'),(2,'2eme semestre');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
