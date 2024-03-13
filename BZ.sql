create database bz;

use bz;

insert value into immagini(imgPath)
values ("D:\Users\petacchid\Desktop\progect work SNKRS BZ\images\Scarpe\Jordan_4_retro_bread_remagined.webp"),
("D:\Users\petacchid\Desktop\progect work SNKRS BZ\images\Scarpe\Jordan_4_Retro_Metallic_Gold .webp");



insert value into scarpe(nome, styleCode, FK_imgPath)
values("Jordan 4 retro bread remaigined","FV5029-006", 1),
("Jordan 4 Retro Metallic Gold (Women's)","AQ9129-170", 2);


insert value into siti(domain, linkScarpa, prezzoMedio)
values("https://stockx.com/it-it", "https://stockx.com/it-it/air-jordan-4-retro-bred-reimagined", 233),
("https://stockx.com/it-it", "https://stockx.com/it-it/air-jordan-4-retro-metallic-gold-womens", 257);


insert value into inserito(FK_idSito, FK_idScarpa)
values(1, 1),
(2, 2);

insert value into prezzo(prezzo, taglia, FK_idSito)
values(263, 43, 1),
(264, 44, 1),
(270, 43, 2);
