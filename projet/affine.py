import math
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

def saisie_entier_positif(message):
    while True:
        try:
            entier = int(input(message))
            if entier >= 0 and entier <= 25:
                return entier
            else:
                print("Veuillez saisir un entier entre 0 et 25.")
        except ValueError:
            print("Veuillez saisir un entier valide.")

def saisie_entier_positif_strict(message):
    while True:
        try:
            entier = int(input(message))
            if entier > 0 and entier <= 25:
                return entier
            else:
                print("Veuillez saisir un entier entre 1 et 25.")
        except ValueError:
            print("Veuillez saisir un entier valide.")

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
        a = saisie_entier_positif_strict("Entrez la valeur de a : ")

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

# Saisie des valeurs de a et b par l'utilisateur
a = saisie_entier_positif_strict("Entrez la valeur de a : ")
if ((pgcd(a,26)!=1) or (a==0)):
    a = saisie_entier_positif_strict("Entrez la valeur de a : ")
b = saisie_entier_positif_strict("Entrez la valeur de b : ")
if((b==0)):
    b = saisie_entier_positif_strict("Entrez la valeur de b : ")

if not est_premier_entre_eux(a, b):
    print("a et b ne sont pas premiers entre eux. Veuillez saisir d'autres valeurs.")
    a = saisie_entier_positif_strict("Entrez la valeur de a : ")
    b = saisie_entier_positif_strict("Entrez la valeur de b : ")

# Saisie du message à chiffrer
message = input("Entrez le message à chiffrer : ")

# Chiffrement du message
message_chiffre = chiffrement_affine(message, a, b)
print("Message chiffré :", message_chiffre)

# Déchiffrement du message
message_dechiffre = dechiffrement_affine(message_chiffre, a, b)
print("Message déchiffré :", message_dechiffre)