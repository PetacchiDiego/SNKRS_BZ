create database BZ;

use BZ;

create table immagini(
    idImmagine int primary key auto_increment,
    imgPath varchar(255) NOT NULL,
    unique(imgPath)
);

create table scarpe(
    idScarpa int primary key auto_increment,
    nome varchar(255) not null,
    styleCode varchar(50),  
    unique(styleCode)
);

create table siti(
    idSito int primary key auto_increment,
    domain varchar(255) NOT NULL,
    linkScarpa varchar(255) NOT NULL,
    FK_img int,
    foreign key (FK_img) references immagini(idImmagine)
        on delete set null
        on update cascade,
    prezzoMedio int NOT NULL
);

create table inserita(
    idInserit int primary key auto_increment,
    FK_idScarpa int not null,
    foreign key (FK_idScarpa) references scarpe(idScarpa)
        on delete cascade
        on update cascade,
    FK_idSito int not null,
    foreign key (FK_idSito) references siti(idSito)
        on delete cascade
        on update cascade
);

--
--create table prezzi(
--    idPrezzo int primary key auto_increment,
--    prezzo int not null check(prezzo > 0),
--    taglia int not null check(taglia > 30 and taglia < 53),
--    FK_sito int not null,
--    foreign key (FK_sito) references siti(idSito)
--        on delete set null
--        on update cascade
--);

