import sys

def miroirdecry(message):
    if message.startswith("00"):
        # Remove the leading "000" and reverse the rest
        reversed_message = message[3:][::-1]
        return reversed_message
    elif message.startswith("00"):
        # Remove the leading "001" and the last letter, then reverse the rest
        modified_message = message[3:-1][::-1]
        return modified_message
    else:
        return "Invalid format"


    
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

if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("Usage: python decrypt.py <message>")
    else:
        encrypted_message = sys.argv[1]
        decrypted = miroirdecry(encrypted_message)
        print(decrypted)