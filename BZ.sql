create database bz;

use bz;

insert into immagini(imgPath)
values ("D:\Users\petacchid\Desktop\progect work SNKRS BZ\images\Scarpe\Jordan_4_retro_bread_remagined.webp"),
("D:\Users\petacchid\Desktop\progect work SNKRS BZ\images\Scarpe\Jordan_4_Retro_Metallic_Gold .webp");



insert into scarpe(nome, styleCode)
values("Jordan 4 retro bread remaigined","FV5029-006"),
("Jordan 4 Retro Metallic Gold (Women's)","AQ9129-170");


insert into siti(domain, linkScarpa,  FK_img, prezzoMedio)
values("https://stockx.com/it-it", "https://stockx.com/it-it/air-jordan-4-retro-bred-reimagined",1, 233),
("https://stockx.com/it-it", "https://stockx.com/it-it/air-jordan-4-retro-metallic-gold-womens", 2, 257);


insert into inserita(FK_idSito, FK_idScarpa)
values(1, 1),
(2, 2);

--insert into prezzo(prezzo, taglia, FK_idSito)
--values(263, 43, 1),
--(264, 44, 1),
--(270, 43, 2);
