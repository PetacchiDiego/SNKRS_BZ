import bs4
import requests
import re
from pprint import pprint

# Constants
LINK = "https://hypeboost.com/it/categoria/sneakers?p="
PRE_LINK_ANNUNCIO = "https://hypeboost.com/it/prodotto/"
IMG_PRE="https://img.hypeboost.com/products/"
ID_SITO=1
TIPOLOGIA=1 #scarpe

page_num=136
with open("dati.csv", "w") as file:
    for page_num in range(1, page_num + 1):
        # Construct the full URL for the current page
        print(page_num)
        url = f"{LINK}{page_num}"
        print(url)


        # Request the page
        response = requests.get(url)
        response.raise_for_status()
        soup = bs4.BeautifulSoup(response.text, 'html.parser')

        # Find all relevant divs 
        link_data = soup.find_all("div", class_="row small-gutters")
        name_data = soup.find_all("div", class_="product-info no-background")
        price_data = soup.find_all("span", class_="new_price")



        link_products = []
        name_products = []
        price_products = []
        img_products = []

        for div in link_data:
            a_tags = div.find_all("a", href=re.compile("prod"))
            link_products.extend(a_tags)
            
        for div in name_data:
            h3_tags = div.find_all('h3')
            name_products.extend(h3_tags)

        for span in price_data:
            span_tags = span.get_text().strip()
            price_products.append(span_tags)

        for img in link_data:
            img_tags=img.findAll("img")  
            img_products.extend(img_tags)    

        # Print extracted links
        links=[]
        print("Extracted Links:")
        for link in link_products:
            #print(link['href'])
            links.append(link['href'])

        # Print extracted h3 tags
        names=[]
        print("Extracted Product Names:")
        for h3 in name_products:
            #print(h3.get_text())
            names.append(h3.get_text())

        #print extracted price tags
        prices=[]
        print("Extracted Prices Names:")
        for span in price_products:
            #print(span[0:len(span)-1])
            spa=span[0:len(span)-1]
            spa=spa.replace(".", "")
            prices.append(spa)

        #print extracted 
        images=[]
        print("Extracted images links:")
        for img in img_products:
            if IMG_PRE in img['src']:
                #print(img['src'])
                images.append(img['src'])

        # Write extracted links to file
        for n in range(0,len(name_products),1):
            file.write(links[n]+ ", " + names[n] + ", " + prices[n] + ", " + images[n] + ", " + str(TIPOLOGIA) + ", " + str(ID_SITO) + "\n")
                

            

    
