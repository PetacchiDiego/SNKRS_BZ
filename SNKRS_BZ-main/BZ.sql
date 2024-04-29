use bz;

insert into immagini(idImmagine, imgPath)
values (1, "\images\Scarpe\Jordan_4_retro_bread_remagined.png"),
(2, "\images\Scarpe\Jordan_4_Retro_Metallic_Gold.png"),
(3, "images\Scarpe\Nike_x_Nocta_Hot_Step_2_Orange.png"),
(4, "\images\Scarpe\Air_Jordan_x_Travis_Scott_1_Low_Golf_Neutral_Olive_(2023).png"),
(5, "\images\Scarpe\Nike_SB_x_The_Powerpuff_Girls_Dunk_Low_Bubbles_(2023).png");



insert into scarpe(idScarpa, nome, styleCode)
values(1, "Jordan 4 retro bread remaigined","FV5029-006"),
(2, "Jordan 4 Retro Metallic Gold (Women's)","AQ9129-170"),
(3, "Nike x Nocta Hot Step 2 'Orange' (2024)","DZ7293-800"),
(4, "Air Jordan x Travis Scott 1 Low Golf 'Neutral Olive' (2023)","FZ3124-200"),
(5, "Nike SB x The Powerpuff Girls Dunk Low 'Bubbles' (2023)","FZ8320-400");


insert into siti(idSito, domain, linkScarpa,  FK_img, prezzoMedio)
values(1, "https://stockx.com/it-it", "https://stockx.com/it-it/air-jordan-4-retro-bred-reimagined",1, 233),
(2, "https://stockx.com/it-it", "https://stockx.com/it-it/air-jordan-4-retro-metallic-gold-womens", 2, 257),
(3, "https://www.klekt.com/", "https://www.klekt.com/product/x-nocta-hot-step-2-orange-2024", 3, 275),
(4, "https://www.klekt.com/", "https://www.klekt.com/product/x-travis-scott-1-low-neutral-olive-2023", 4, 883),
(5, "https://www.klekt.com/", "https://www.klekt.com/product/x-the-powerpuff-girls-dunk-low-bubbles-2023", 5, 263);


insert into inserita(FK_idSito, FK_idScarpa)
values(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5);
