import math
import sys
def pgcd(a, b):
    while b != 0:
        a, b = b, a % b
    return a

def cryAffine(message, a, b):
    l = len(message)
    c_message = ""
    i = 0
    while i < l:
        if (pgcd(a, 26) == 1) and (pgcd(a, 26) == 1):  # Fixed pgcd function call
            if a != 0 and b != 0:
                if 'a' <= message[i] <= 'z':
                    x = ord(message[i]) - ord('a')
                    x = (a * x + b) % 26
                    x += ord('a')  # Corrected variable case and added the result to x
                    c_message += chr(x)
                    i += 1
                elif 'A' <= message[i] <= 'Z':
                    x = ord(message[i]) - ord('A')
                    x = (a * x + b) % 26
                    x += ord('A')  # Corrected variable case and added the result to x
                    c_message += chr(x)
                    i += 1
                else:
                    c_message += message[i]
                    i += 1
            else:
                c_message += message[i]
                i += 1
        else:
            c_message += message[i]
            i += 1
    return c_message

a = sys.argv[1]
b = sys.argv[2]
message = sys.argv[3]

encrypted_message = cryAffine(message, a, b)
print(encrypted_message)
