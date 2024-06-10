import bs4
import requests
import re
from pprint import pprint

# Constants
LINK = "https://droplist.store/collections/sneakers?page="
PRE_LINK_ANNUNCIO = "https://droplist.store"
IMG_PRE="https:"
ID_SITO=2
TIPOLOGIA=1 #scarpe

page_num=3
with open("datiDropList.csv", "w") as file:
    for page_num in range(1, page_num + 1):
        # Construct the full URL for the current page
        print(page_num)
        url = f"{LINK}{page_num}"
        print(url)

        # Request the page
        response = requests.get(url)
        response.raise_for_status()
        soup = bs4.BeautifulSoup(response.text, 'html.parser')
        data = soup.find_all("ul", class_="grid gap-theme grid-cols-2 lg:grid-cols-4")

        #prezzi delle scarpe
        prezzi=[]
        for span in data:
            span_tags=span.find_all("span", class_="price-item price-item--regular")
            #print(span_tags)
            prezzi.append(span_tags)

        #nomi delle scarpe
        nomi=[]
        for h3 in data:
            h3_tags=h3.find_all("h3", class_="font-body text-base")
            #print(h3_tags)
            nomi.append(h3_tags)

        #link delle scarpe
        link=[]
        for a in data:
            a_tags=a.find_all("a", href=re.compile("prod"))
            #print(a_tags)
            link.append(a_tags)

        #immagini delle scarpe
        img=[]
        for imgC in data:
            img_tags=imgC.findAll("img")
            #print(img_tags)
            img.append(img_tags)


        # Stampa i prezzi delle scarpe
        price = []
        print("Prezzi delle scarpe:")
        for prezzi_prodotto in prezzi:
            for prezzo in prezzi_prodotto:
                p=prezzo.text.strip()
                p=p[1:len(p)-1]
                pf=p.replace('.', '')
                pf=pf[0:len(pf)-2]
                print(pf)
                price.append(pf)


        # Stampa i nomi delle scarpe
        names = []
        print("\nNomi delle scarpe:")
        for nomi_prodotto in nomi:
            for nome in nomi_prodotto:
                print(nome.text.strip())
                names.append(nome.text.strip())

        # Stampa i link delle scarpe
        links=[]
        print("\nLink delle scarpe:")
        for link_prodotto in link:
            for link_tag in link_prodotto:
                print(link_tag['href'])
                links.append(PRE_LINK_ANNUNCIO + link_tag['href'])

        # Stampa le immagini delle scarpe
        images=[]
        print("\nImmagini delle scarpe:")
        for img_prodotto in img:
            for img_tag in img_prodotto:
                print(img_tag['src'])
                images.append(IMG_PRE + img_tag['src'])


        # Write extracted links to file
        for n in range(0,len(names),1):
            file.write(links[n]+ ", " + names[n] + ", " + price[n] + ", " + images[n] + ", " + str(TIPOLOGIA) + ", " + str(ID_SITO) + "\n")
