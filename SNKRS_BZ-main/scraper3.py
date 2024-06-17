import requests
from bs4 import BeautifulSoup
import re
from pprint import pprint
import numpy as np
from PIL import Image
from io import BytesIO

# Constants
LINK = "https://nakedcph.com/collections/apparel?page="
BASE_URL = "https://nakedcph.com"
IMG_PRE = "https:"
EXCHANGE_RATE_DKK_TO_EUR = 0.134  
ID_SITO=3
TIPOLOGIA=2 #vestiario


def get_dominant_color(image_url, excluded_color=(243, 243, 243)):
    # Scarica l'immagine dall'URL
    response = requests.get(image_url)
    if response.status_code != 200:
        raise Exception("Errore nel scaricare l'immagine")

    # Crea un file in memoria dall'immagine scaricata
    image_data = BytesIO(response.content)
    image = Image.open(image_data)

    # Converte l'immagine in RGB e ridimensiona per velocizzare il calcolo
    image = image.convert("RGB")
    image = image.resize((100, 100))  # Ridimensionamento per efficienza

    # Converti l'immagine in un array numpy
    pixels = np.array(image)

    # Appiattisci l'array 2D in 1D
    pixels = pixels.reshape(-1, 3)

    # Filtra i pixel con il colore specificato
    mask = (pixels[:, 0] != excluded_color[0]) | \
           (pixels[:, 1] != excluded_color[1]) | \
           (pixels[:, 2] != excluded_color[2])
    filtered_pixels = pixels[mask]

    if len(filtered_pixels) == 0:
        return None  # Se tutti i pixel sono il colore escluso

    # Conta le occorrenze di ogni colore
    unique, counts = np.unique(filtered_pixels, axis=0, return_counts=True)

    # Trova il colore con il conteggio massimo
    dominant_color = unique[counts.argmax()]
    #print(dominant_color)
    return dominant_color



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
            color_prodotti = []

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

                #Estrai il colore 
                dominant_color = get_dominant_color(img_url)
                #print (dominant_color)
                color_prodotti.append(dominant_color)

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
                file.write(f"{link_prodotti[i]}, {nomi[i]}, {prezzi_eur[i]}, {img_prodotti[i]}, {color_prodotti[i]}, {TIPOLOGIA}, {ID_SITO}\n")

