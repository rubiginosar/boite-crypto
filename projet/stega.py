import numpy as np
from PIL import Image

def hide(message, image_name):
    finalmessage = ""
    image = Image.open(image_name)
    data = np.asarray(image).copy()
    for letter in message:
        position_ascii = ord(letter)
        binaire = bin(position_ascii)[2:]
        while len(binaire) < 8:
            binaire = "0" + binaire
        finalmessage += binaire
    print("message encodé en binaire :", finalmessage)

    # récupérer la longueur et l'inscrire sur 2 octets (16 bits)
    longueur = len(finalmessage)
    binaire = bin(longueur)[2:]
    while len(binaire) < 16:
        binaire = "0" + binaire

    print("taille à encoder", binaire)
    resultat = binaire + finalmessage

    print(data[0][0])
    tour = 0
    y = 0
    for line in data:
        x = 0
        for colonne in line:
            rgb = 0
            for color in colonne:
                valeur = data[y][x][rgb]
                binaire = bin(valeur)[2:]
                binaire_list = list(binaire)
                del binaire_list[-1]
                binaire_list.append(resultat[tour])
                decimal = int("".join(binaire_list), 2)
                data[y][x][rgb] = decimal
                tour += 1
                rgb += 1
                if tour >= len(resultat):
                    break
            x += 1
            if tour >= len(resultat):
                break
        y += 1
        if tour >= len(resultat):
            break
    imagefinal = Image.fromarray(data)
    imagefinal.save("secret.png")

def discover(image_name):
    image = Image.open(image_name)
    data = np.asarray(image).copy()
    tour = 0
    taille = ""
    taillenew = 0
    message = ""
    y = 0
    for line in data:
        x = 0
        for colonne in line:
            rgb = 0
            for color in colonne:
                valeur = data[y][x][rgb]
                binaire = bin(valeur)[2:]
                last = binaire[-1]
                if tour < 16:
                    taille += last
                if tour == 16:
                    taillenew = int(taille, 2)
                if tour - 16 < taillenew:
                    message += last
                if tour - 16 >= taillenew:
                    break
                tour += 1
                rgb += 1
            if tour - 16 >= taillenew:
                break
            x += 1
        if tour - 16 >= taillenew:
            break
        y += 1
    print(message)
    octet = []
    for i in range(len(message) // 8):
        octet.append(message[i * 8:(i + 1) * 8])
    print(octet)
    result = ""
    for oc in octet:
        index = int(oc, 2)
        lettre_ascii = chr(index)
        result += lettre_ascii
    print("message:", str(result)[2:])
image_name="C:/xampp/htdocs/boite-crypto/projet/drop.PNG"
hide("bonjour", image_name)
discover("secret.png")
