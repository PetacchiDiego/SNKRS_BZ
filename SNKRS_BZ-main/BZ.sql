use bz;

insert into siti(idSito, domain)
values(1, "https:///stockx.com/it-it"),
(2, "https://www.klekt.com/");


insert into item(idItem, nome, styleCode, colore)
values(1, "Jordan 4 retro bread remaigined","FV5029-006", "BLACK/CEMENT GREY/VARSITY RED/SUMMIT WHITE"),
(2, "Jordan 4 Retro Metallic Gold (Women's)","AQ9129-170", "SAIL/METALLIC GOLD/BLACK"),
(3, "Nike x Nocta Hot Step 2 'Orange' (2024)","DZ7293-800", "TOTAL ORANGE/UNIVERSITY GOLD/CHROME"),
(4, "Air Jordan x Travis Scott 1 Low Golf 'Neutral Olive' (2023)","FZ3124-200", "SAIL/UNIVERSITY RED/BLACK/MEDIUM OLIVE"),
(5, "Nike SB x The Powerpuff Girls Dunk Low 'Bubbles' (2023)","FZ8320-400", "BLUE CHILL/DEEP ROYAL BLUE/ACTIVE PINK");

insert into scarpe(FK_idItem)
values (1),
(2),
(3),
(4),
(5);


insert into immagini(idImmagine, imgPath, FK_idItem)
values (1, "\images\Scarpe\Jordan_4_retro_bread_remagined.png", 1),
(2, "\images\Scarpe\Jordan_4_Retro_Metallic_Gold.png", 2),
(3, "images\Scarpe\Nike_x_Nocta_Hot_Step_2_Orange.png", 3),
(4, "\images\Scarpe\Air_Jordan_x_Travis_Scott_1_Low_Golf_Neutral_Olive_(2023).png", 4),
(5, "\images\Scarpe\Nike_SB_x_The_Powerpuff_Girls_Dunk_Low_Bubbles_(2023).png", 5);


insert into inserita(FK_idSito, FK_idItem, prezzoMedio, linkScarpa)
values(1, 1, 279, "https://stockx.com/it-it/air-jordan-4-retro-bred-reimagined"),
(1, 2, 375, "https://stockx.com/it-it/air-jordan-4-retro-metallic-gold-womens"),
(2, 3, 275, "https://www.klekt.com/product/x-nocta-hot-step-2-orange-2024"),
(2, 4, 824, "https://www.klekt.com/product/x-travis-scott-1-low-neutral-olive-2023"),
(2, 5, 286, "https://www.klekt.com/product/x-the-powerpuff-girls-dunk-low-bubbles-2023"),
(2, 1, 193, "https://www.klekt.com/product/4-og-reimagined-bred-2023");






insert into item(idItem, nome, styleCode, colore)
values (6, "Supreme Box Logo Hooded Sweatshirt Red (FW23)", "TBC", "RED"),
(7, "Fear Of God ESSENTIALS 3D Silicon Applique Crewneck Gray Flannel/Charcoal (SS20)", "SS20", "GRAY FLANNEL/CHARCOAL"),
(8, "Nike x Off White Mon Amour Football T-Shirt Tee White (2018)", "AJ3374-100", "WHITE"),
(9, "Palace Messier Jacket Ultra (SS24)", "SS24","ULTRA");

insert into vestiario(FK_idItem)
values (6),
(7),
(8),
(9);

insert into immagini(idImmagine, imgPath, FK_idItem)
values (6, "\images\Vestiario\Supreme_Box_Logo_Hooded_Sweatshirt_Red_(FW23).png", 6),
(7, "images\Vestiario\FEAR_OF_GOD_ESSENTIALS_3D_Silicon_Applique_Crewneck_Gray_Flannel_Charcoal.png", 7),
(8, "images\Vestiario\Nike_x_Off_White_Football_Tee_White.png", 8),
(9, "images\Vestiario\Palace_Messier_Jacket_Ultra_(SS24).png", 9);

insert into inserita(FK_idSito, FK_idItem, prezzoMedio, linkScarpa)
values (2, 6, 303, "https://www.klekt.com/product/box-logo-hooded-sweatshirt-red-fw23"),
(2, 7, 239, "https://www.klekt.com/product/essentials-3d-silicon-applique-crewneck-gray-flannel-charcoal-ss20"),
(1, 8, 256, "https://stockx.com/it-it/nikelab-x-off-white-mercurial-nrg-x-tee-white"),
(2, 8, 415, "https://www.klekt.com/product/x-off-white-mon-amour-football-t-shirt-tee-white-2018"),
(1, 9, 283, "https://stockx.com/it-it/palace-mesher-jacket-ultra"),
(2, 9, 380, "https://www.klekt.com/product/messier-jacket-ultra-ss24");





insert into item(idItem, nome, styleCode, colore)
values (10, "Air Jordan 4 'Military Blue/Industrial Blue' (2024)", "FV5029-141", "OFF-WHITE/MILITARY BLUE/NEUTRAL GREY"),
(11, "Air Jordan 3 Craft 'Ivory' (2024)", "FJ9479-100", "IVORY/GREY MIST/CREAM"),
(12, "Nike x Parra SB Dunk Low 'Abstract Art' (2021)", "DH7695-600", "FIRE PINK/GYM RED-MOCHA-WHITE-ROYAL BLUE-BLACK"),
(13,"Yeezy Slide 'Pure'", "GW1934", "PURE/PURE/PURE"),
(14, "Yeezy Boost 700 'Wave Runner'", "B75571", "SOLID GREY/CHALK WHITE/CORE BLACK");

insert into scarpe(FK_idItem)
values (10),
(11),
(12),
(13),
(14);


insert into immagini(idImmagine, imgPath, FK_idItem)
values (10, "images\Scarpe\Air_Jordan_4_Military_Blue_Industrial_Blue_(2024).png", 10),
(11, "images\Scarpe\Air_Jordan_3_Craft_Ivory_(2024).png", 11),
(12, "images\Scarpe\Nike_x_Parra_SB_Dunk_Low_Abstract_Art_(2021).png", 12),
(13, "images\Scarpe\Yeezy_Slide_Pure.png", 13),
(14, "images\Scarpe\Yeezy_Boost_700_Wave_Runner.png", 14);

insert into inserita(FK_idSito, FK_idItem, prezzoMedio, linkScarpa)
values(2, 10, 232, "https://www.klekt.com/product/4-military-blue-2024"),
(1, 10, 211, "https://stockx.com/it-it/air-jordan-4-retro-military-blue-2024"),
(2, 11, 239, "https://www.klekt.com/product/3-ivory-2023"),
(1, 11, 213, "https://stockx.com/it-it/air-jordan-3-retro-craft-ivory"),
(2, 12, 304, "https://www.klekt.com/product/x-parra-sb-dunk-low-pro-abstract-art-2021"),
(1, 12, 306, "https://stockx.com/it-it/nike-sb-dunk-low-parra-2021"),
(2, 13, 138, "https://www.klekt.com/product/slide-pure-2"),
(1, 13, 148, "https://stockx.com/it-it/adidas-yeezy-slide-pure-restock-pair"),
(1, 14, 361, "https://stockx.com/it-it/adidas-yeezy-wave-runner-700-solid-grey"),
(2, 14, 390, "https://www.klekt.com/product/boost-700-wave-runner");









