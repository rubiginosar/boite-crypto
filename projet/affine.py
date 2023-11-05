import math
import sys

# Définition de la fonction pgcd (Plus Grand Commun Diviseur)
def pgcd(a, b):
    while b != 0:
        a, b = b, a % b
    return a

# Cette fonction calcule le PGCD (Plus Grand Commun Diviseur) de deux nombres a et b en utilisant l'algorithme d'Euclide.

# Définition de la fonction est_premier pour vérifier si un nombre est premier
def est_premier(n):
    if n < 2:
        return False
    for i in range(2, int(n**0.5) + 1):
        if n % i == 0:
            return False
    return True

# Cette fonction vérifie si un nombre n est premier. Elle retourne True si n est premier, sinon False.

# Définition de la fonction chiffrement_affine pour chiffrer un message
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

# Cette fonction chiffre un message en utilisant le chiffrement affine. Elle prend en compte chaque lettre du message et applique la transformation affine.

# Définition de la fonction dechiffrement_affine pour déchiffrer un message
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
        a = int(sys.argv[1])  # Lire la valeur de a à partir de l'argument en ligne de commande

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

# Cette fonction déchiffre un message chiffré en utilisant le chiffrement affine. Elle utilise l'inverse de a pour inverser la transformation et retrouver le message original.

# Définition de la fonction est_premier_entre_eux pour vérifier si deux nombres sont premiers entre eux
def est_premier_entre_eux(a, b):
    return math.gcd(a, b) == 1

# Cette fonction vérifie si deux nombres a et b sont premiers entre eux
# Lire les valeurs de a et b à partir des arguments en ligne de commande
a = int(sys.argv[1])
b = int(sys.argv[2])

# Vérifier si a et b sont des entiers positifs et premiers entre eux avec 26
if a <= 0 and b <= 0 or not est_premier_entre_eux(a, 26):
    print("error")
    sys.exit(1)

# Lire le message à partir de l'argument en ligne de commande
message = sys.argv[3]

# Chiffrer le message
message_chiffre = chiffrement_affine(message, a, b)

# Formater le message chiffré avec a et b occupant deux positions chacun
formatted_message = "{:02d}{:02d}".format(a, b) + message_chiffre
print("A_"+formatted_message)
