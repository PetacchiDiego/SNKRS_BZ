import requests
from bs4 import BeautifulSoup
import re
from pprint import pprint

# Constants
LINK = "https://nakedcph.com/collections/apparel?page="
BASE_URL = "https://nakedcph.com"
IMG_PRE = "https:"
EXCHANGE_RATE_DKK_TO_EUR = 0.134  
ID_SITO=3
TIPOLOGIA=2 #vestiario

page_num=27
with open("datiNaked.csv", "w") as file:
    for page_num in range(1, page_num + 1):
        # Construct the full URL for the current page
        print(page_num)
        url = f"{LINK}{page_num}"
        print(url)


        # Request the page
        response = requests.get(url)
        response.raise_for_status()
        soup = BeautifulSoup(response.text, 'html.parser')

        # Trova il contenitore principale dei prodotti
        data = soup.find("div", id="products")

        # Verifica se il contenitore è trovato
        if not data:
            print("Contenitore dei prodotti non trovato.")
        else:
            # Trova tutti i prodotti
            products = data.find_all("div", class_="product relative")

            # Liste per memorizzare i dati
            link_prodotti = []
            nomi = []
            prezzi = []
            prezzi_eur = []
            img_prodotti = []

            # Itera su ogni prodotto e estrai i dati
            for product in products:
                # Estrai il link
                a_tag = product.find("a", href=re.compile("products"))
                link = BASE_URL + a_tag['href'] if a_tag else "N/A"
                link_prodotti.append(link)
                
                # Estrai il nome
                name_tag = product.find("h4", class_="flex flex-col gap-1 truncate product-grid-is-active:self-end lg:self-end")
                name = name_tag.text.strip() if name_tag else "N/A"
                name=re.sub(r'\n', ' ', name)
                nomi.append(name)
                
                # Estrai il prezzo in DKK
                price_tag = product.find("span", class_="lg:flex lg:justify-end")
                price_dkk = price_tag.text.strip() if price_tag else "N/A"
                prezzi.append(price_dkk)
                
                # Converti il prezzo in EUR
                if price_dkk != "N/A":
                    price_dkk_numeric = float(re.sub("[^\d.]", "", price_dkk))  # Rimuove i caratteri non numerici
                    price_eur = price_dkk_numeric * EXCHANGE_RATE_DKK_TO_EUR
                    prezzi_eur.append(f"{price_eur:.2f}")
                else:
                    prezzi_eur.append("N/A")
                
                # Estrai l'immagine
                img_tag = product.find("img", class_="w-full")
                img_url = IMG_PRE + img_tag['src'] if img_tag else "N/A"
                img_prodotti.append(img_url)

            # Stampa i dati estratti
            print("Link dei prodotti:")
            pprint(link_prodotti)
            print("\nNomi dei prodotti:")
            pprint(nomi)
            print("\nPrezzi dei prodotti (in EUR):")
            pprint(prezzi_eur)
            print("\nImmagini dei prodotti:")
            pprint(img_prodotti)
        
            # Scrivi i dati estratti su un file CSV
            for i in range(len(link_prodotti)):
                file.write(f"{link_prodotti[i]}, {nomi[i]}, {prezzi_eur[i]}, {img_prodotti[i]}, {TIPOLOGIA}, {ID_SITO}\n")
