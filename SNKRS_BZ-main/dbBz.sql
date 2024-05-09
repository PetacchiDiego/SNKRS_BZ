create database BZ;

use BZ;

create table siti(
    idSito int primary key auto_increment,
    domain varchar(255) NOT NULL
);

create table item(
    idItem int primary key auto_increment,
    nome varchar(255) not null,
    styleCode varchar(255),  
    unique(styleCode)
);

create table immagini(
    idImmagine int primary key auto_increment,
    imgPath varchar(255) NOT NULL,
    FK_idItem int, 
    foreign key(FK_idItem) references item(idItem)
        on delete set null
        on update cascade, 
    unique(imgPath)
);

create table inserita(
    idInserit int primary key auto_increment,
    FK_idItem int,
    foreign key (FK_idItem) references item(idItem)
        on delete set null
        on update cascade,
    FK_idSito int,
    foreign key (FK_idSito) references siti(idSito)
        on delete set null
        on update cascade,
    prezzoMedio int NOT NULL,
    linkScarpa varchar(255) NOT NULL
);

create table scarpe(
    idScarpa int primary key auto_increment,
    FK_idItem int,
    foreign key(FK_idItem) references item(idItem)
        on delete set null
        on update cascade
);

create table vestiario(
    idVestiario int primary key auto_increment,
    FK_idItem int,
    foreign key(FK_idItem) references item(idItem)
        on delete set null
        on update cascade
);

create table pantaloni(
    idPantalone int primary key auto_increment,
    FK_idItem int,
    foreign key(FK_idItem) references item(idItem)
        on delete set null
        on update cascade
);



