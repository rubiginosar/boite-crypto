import sys
import numpy as np
from PIL import Image

def discover(image_name):
    image = Image.open(image_name)
    data = np.asarray(image).copy()
    tour = 0
    taille = ""
    taillenew = 12574
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
            print("No message found in the image.")
