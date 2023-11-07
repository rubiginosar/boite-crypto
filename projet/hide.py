import numpy as np
from PIL import Image
import sys
import time #pour générer un horodatage

# La fonction hide prend un message et le chemin de l'image en entrée, puis cache le message dans l'image.
# L'image est ouverte et convertie en un tableau NumPy.
# Le message est converti en binaire en utilisant la fonction ord pour obtenir la valeur ASCII de chaque caractère.
# Les bits manquants (pour obtenir 8 bits) sont remplis de zéros.
# Le message binaire est stocké dans la variable finalmessage.
# La longueur du message est encodée en binaire sur 16 bits.
# Les bits manquants (pour obtenir 16 bits) sont remplis de zéros.
# La longueur encodée est stockée dans la variable binary_length.
# Le message final est composé en ajoutant d'abord la longueur encodée, puis le message binaire.
# Les boucles imbriquées parcourent les composantes RVB de chaque pixel de l'image.
# Pour chaque composante RVB, le dernier bit de la valeur est remplacé par un bit du message.
# Les données de l'image sont mises à jour pour inclure le message caché.
# Une nouvelle image est créée à partir des données modifiées et sauvegardée avec un nom de fichier unique.


def hide(message, image_name):
    finalmessage = ""

    # Ouvre l'image spécifiée
    image = Image.open(image_name)

    # Convertit l'image en tableau NumPy
    data = np.asarray(image).copy()

    # Convertit le message en binaire
    for letter in message:
        position_ascii = ord(letter)
        binaire = bin(position_ascii)[2:]

        # Remplit les bits manquants avec des zéros pour obtenir 8 bits
        while len(binaire) < 8:
            binaire = "0" + binaire

        finalmessage += binaire

    # Affiche le message encodé en binaire
    print("Message encodé en binaire :", finalmessage)

    # Obtient la longueur du message et l'encode en 16 bits
    length = len(finalmessage)
    binary_length = bin(length)[2:]

    # Remplit les bits manquants avec des zéros pour obtenir 16 bits
    while len(binary_length) < 16:
        binary_length = "0" + binary_length

    # Affiche la longueur encodée
    print("Longueur à encoder :", binary_length)

    # Compose le message final en ajoutant la longueur au début
    result = binary_length + finalmessage

    tour = 0
    y = 0

    # Parcours de chaque ligne de pixels de l'image
    for line in data:
        x = 0

        # Parcours de chaque colonne de pixels
        for column in line:
            rgb = 0

            # Parcours des composantes RVB (rouge, vert, bleu) de chaque pixel
            for color in column:
                value = data[y][x][rgb]
                binary_value = bin(value)[2:]
                binary_list = list(binary_value)

                # Remplace le dernier bit de la valeur par un bit du message
                del binary_list[-1]
                binary_list.append(result[tour])
                decimal = int("".join(binary_list), 2)
                data[y][x][rgb] = decimal
                tour += 1
                rgb += 1

                # Si tout le message a été caché, sort de la boucle
                if tour >= len(result):
                    break

            x += 1

            # Si tout le message a été caché, sort de la boucle
            if tour >= len(result):
                break

        y += 1

        # Si tout le message a été caché, sort de la boucle
        if tour >= len(result):
            break

    # Génère un nom de fichier unique avec un horodatage
    timestamp = int(time.time())
    output_path = "C:/Users/user/Desktop/uploads/secret_{}.png".format(timestamp)

    # Crée une nouvelle image à partir des données modifiées et la sauvegarde
    image_final = Image.fromarray(data)
    image_final.save(output_path)

if __name__ == "__main__":
    if len(sys.argv) != 3:
        print("Utilisation : python hide.py <message> <chemin_image>")
        sys.exit(1)

    message = sys.argv[1]
    image_path = sys.argv[2]
    hide(message, image_path)
