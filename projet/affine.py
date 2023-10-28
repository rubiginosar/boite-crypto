import math
import sys

def pgcd(a, b):
    while b != 0:
        a, b = b, a % b
    return a

def est_premier(n):
    if n < 2:
        return False
    for i in range(2, int(n**0.5) + 1):
        if n % i == 0:
            return False
    return True

def chiffrement_affine(message, a, b):
    alphabet = 'abcdefghijklmnopqrstuvwxyz'
    message_chiffre = ''
    for lettre in message:
        if lettre.lower() in alphabet:
            index = alphabet.index(lettre.lower())
            lettre_chiffree = alphabet[(a * index + b) % 26]
            if lettre.isupper():
                lettre_chiffree = lettre_chiffree.upper()
            message_chiffre += lettre_chiffree
        else:
            message_chiffre += lettre
    return message_chiffre

def dechiffrement_affine(message_chiffre, a, b):
    alphabet = 'abcdefghijklmnopqrstuvwxyz'
    message_dechiffre = ''

    # Calcul de l'inverse de a modulo 26
    a_inverse = None
    for i in range(1, 26):
        if (a * i) % 26 == 1:
            a_inverse = i
            break

    if a_inverse is None:
        a = int(sys.argv[1])  # Read a from the command-line argument

    for lettre in message_chiffre:
        if lettre.lower() in alphabet:
            index = alphabet.index(lettre.lower())
            lettre_dechiffree = alphabet[(a_inverse * (index - b)) % 26]
            if lettre.isupper():
                lettre_dechiffree = lettre_dechiffree.upper()
            message_dechiffre += lettre_dechiffree
        else:
            message_dechiffre += lettre
    return message_dechiffre

def est_premier_entre_eux(a, b):
    return math.gcd(a, b) == 1

# Read values of a and b from command-line arguments
a = int(sys.argv[1])
b = int(sys.argv[2])

if a <= 0 or b <= 0 or not est_premier_entre_eux(a, 26):
    print("error")
    sys.exit(1)

# Read the message from command-line argument
message = sys.argv[3]

# Chiffrement du message
message_chiffre = chiffrement_affine(message, a, b)

# Print the encrypted message with a and b occupying two positions each
formatted_message = "{:02d}{:02d}".format(a, b) + message_chiffre
print(formatted_message)
