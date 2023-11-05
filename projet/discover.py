import sys
import numpy as np
from PIL import Image #numpy pour la manipulation d'images, et PIL (Pillow) pour le traitement d'images.

#La fonction discover prend le nom du fichier image en entrée et extrait le message dissimulé dans l'image.
#L'image est ouverte et convertie en un tableau NumPy.
#Les boucles imbriquées parcourent les composantes RVB de chaque pixel de l'image.
# Pour chaque composante RVB, le script extrait le bit de poids faible (le dernier bit de la valeur) et le stocke dans la variable last.
# Les 16 premiers bits extraits représentent la taille du message dissimulé.
# Lorsque les 16 premiers bits sont lus, la taille est convertie en décimal pour déterminer la longueur du message.
# Les bits suivants sont extraits pour reconstituer le message jusqu'à atteindre la longueur déterminée.
# Le message extrait est divisé en octets de 8 bits.
# Chaque octet est converti en une valeur décimale, puis en caractères ASCII.
# Le résultat final est le message dissimulé découvert.

def discover(image_name):
    # Ouvre l'image spécifiée
    image = Image.open(image_name)

    # Convertit l'image en tableau NumPy
    data = np.asarray(image).copy()

    tour = 0
    taille = ""
    taillenew = 12574
    message = ""
    y = 0

    # Parcours de chaque ligne de pixels de l'image
    for line in data:
        x = 0

        # Parcours de chaque colonne de pixels
        for colonne in line:
            rgb = 0

            # Parcours des composantes RVB (rouge, vert, bleu) de chaque pixel
            for color in colonne:
                valeur = data[y][x][rgb]

                # Conversion de la valeur en binaire
                binaire = bin(valeur)[2:]
                last = binaire[-1]

                # Les 16 premiers bits représentent la taille du message
                if tour < 16:
                    taille += last

                # Lorsque les 16 premiers bits sont lus, met à jour la longueur du message
                if tour == 16:
                    taillenew = int(taille, 2)

                # Récupère les bits du message caché
                if tour - 16 < taillenew:
                    message += last

                # Si le message a été complètement extrait, sort de la boucle
                if tour - 16 >= taillenew:
                    break

                tour += 1
                rgb += 1

            # Si le message a été complètement extrait, sort de la boucle
            if tour - 16 >= taillenew:
                break

            x += 1

        # Si le message a été complètement extrait, sort de la boucle
        if tour - 16 >= taillenew:
            break

        y += 1

    # Divise le message en octets (groupes de 8 bits)
    octets = [message[i:i + 8] for i in range(0, len(message), 8)]

    result = ""
    for octet in octets:
        index = int(octet, 2)
        lettre_ascii = chr(index)
        result += lettre_ascii

    return result[2:]

if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("Usage: python discover.py <image_path>")
    else:
        image_path = sys.argv[1]
        discovered_message = discover(image_path)
        if discovered_message:
            print(discovered_message)
        else:
            print("Aucun message trouvé dans l'image.")