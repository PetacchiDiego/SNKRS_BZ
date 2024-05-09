use bz;

insert into siti(idSito, domain)
values(1, "https:///stockx.com/it-it"),
(2, "https://www.klekt.com/");


insert into item(idItem, nome, styleCode)
values(1, "Jordan 4 retro bread remaigined","FV5029-006"),
(2, "Jordan 4 Retro Metallic Gold (Women's)","AQ9129-170"),
(3, "Nike x Nocta Hot Step 2 'Orange' (2024)","DZ7293-800"),
(4, "Air Jordan x Travis Scott 1 Low Golf 'Neutral Olive' (2023)","FZ3124-200"),
(5, "Nike SB x The Powerpuff Girls Dunk Low 'Bubbles' (2023)","FZ8320-400");

insert into scarpe(FK_idScarpa)
values (1),
(2),
(3),
(4),
(5);

insert into immagini(idImmagine, imgPath, FK_idItem)
values (1, "\images\Scarpe\Jordan_4_retro_bread_remagined.png", 1),
(2, "\images\Scarpe\Jordan_4_Retro_Metallic_Gold.png", 1),
(3, "images\Scarpe\Nike_x_Nocta_Hot_Step_2_Orange.png", 2),
(4, "\images\Scarpe\Air_Jordan_x_Travis_Scott_1_Low_Golf_Neutral_Olive_(2023).png", 2),
(5, "\images\Scarpe\Nike_SB_x_The_Powerpuff_Girls_Dunk_Low_Bubbles_(2023).png", 2);


insert into inserita(FK_idSito, FK_idItem, prezzoMedio, linkScarpa)
values(1, 1, 279, "https://stockx.com/it-it/air-jordan-4-retro-bred-reimagined"),
(1, 2, 375, "https://stockx.com/it-it/air-jordan-4-retro-metallic-gold-womens"),
(2, 3, 275, "https://www.klekt.com/product/x-nocta-hot-step-2-orange-2024"),
(2, 4, 824, "https://www.klekt.com/product/x-travis-scott-1-low-neutral-olive-2023"),
(2, 5, 286, "https://www.klekt.com/product/x-the-powerpuff-girls-dunk-low-bubbles-2023");
