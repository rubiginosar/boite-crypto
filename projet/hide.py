import numpy as np
from PIL import Image
import sys
import time

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
    print("Message encoded in binary:", finalmessage)

    # Get the length and encode it in 16 bits
    length = len(finalmessage)
    binary_length = bin(length)[2:]
    while len(binary_length) < 16:
        binary_length = "0" + binary_length

    print("Length to encode:", binary_length)
    result = binary_length + finalmessage

    tour = 0
    y = 0
    for line in data:
        x = 0
        for column in line:
            rgb = 0
            for color in column:
                value = data[y][x][rgb]
                binary_value = bin(value)[2:]
                binary_list = list(binary_value)
                del binary_list[-1]
                binary_list.append(result[tour])
                decimal = int("".join(binary_list), 2)
                data[y][x][rgb] = decimal
                tour += 1
                rgb += 1
                if tour >= len(result):
                    break
            x += 1
            if tour >= len(result):
                break
        y += 1
        if tour >= len(result):
            break

    # Generate a unique filename with a timestamp
    timestamp = int(time.time())
    output_path = "C:/Users/THINKPAD T470/Desktop/uploads/secret_{}.png".format(timestamp)
    image_final = Image.fromarray(data)
    image_final.save(output_path)

if __name__ == "__main__":
    if len(sys.argv) != 3:
        print("Usage: python hide.py <message> <image_path>")
        sys.exit(1)

    message = sys.argv[1]
    image_path = sys.argv[2]
    hide(message, image_path)
