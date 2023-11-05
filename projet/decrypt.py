import sys

# Définition de la fonction dechiffrement_affine pour déchiffrer un message
def dechiffrement_affine(encrypted_message):
    # Extraire les coefficients a et b à partir du message chiffré
    a = int(encrypted_message[0:2])
    b = int(encrypted_message[2:4])

    # Extraire le message chiffré lui-même
    message = encrypted_message[4:]

    # Définition de l'alphabet utilisé pour le chiffrement
    alphabet = 'abcdefghijklmnopqrstuvwxyz'

    # Initialisation de la variable pour le message déchiffré
    decrypted_message = ''

    for lettre in message:
        if lettre.lower() in alphabet:
            # Trouver l'index de la lettre dans l'alphabet
            index = alphabet.index(lettre.lower())

            a_inverse = None

            # Trouver l'inverse multiplicatif modulo 26 de 'a' (a^-1)
            for i in range(1, 26):
                if (a * i) % 26 == 1:
                    a_inverse = i
                    break

            if a_inverse is not None:
                # Déchiffrer la lettre
                x = (a_inverse * (index - b)) % 26

                if lettre.isupper():
                    # Si la lettre d'origine était en majuscules, conservez la majuscule
                    decrypted_letter = alphabet[x].upper()
                else:
                    decrypted_letter = alphabet[x]

                decrypted_message += decrypted_letter
            else:
                # Si 'a' n'a pas d'inverse, renvoyer un message d'erreur
                return "Erreur : 'a' n'a pas d'inverse modulo 26"
        else:
            # Les caractères qui ne sont pas dans l'alphabet ne sont pas modifiés
            decrypted_message += lettre

    return decrypted_message

# Exemple d'utilisation :
encrypted_message = sys.argv[1]  # Remplacez par votre message chiffré
decrypted_message = dechiffrement_affine(encrypted_message)
print(decrypted_message)
