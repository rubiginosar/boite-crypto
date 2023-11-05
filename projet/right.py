import sys

# Définition d'une fonction nommée 'right_shift' prenant un message en tant que paramètre
def right_shift(message):
    result = ""  # Initialise une chaîne vide pour stocker le résultat du décalage
    for char in message:  # Parcours chaque caractère dans le message d'entrée
        if char.isdigit():  # Vérifie si le caractère est un chiffre
            result += str((int(char) + 1) % 10)  # Effectue un décalage circulaire sur les chiffres
        elif char.isalpha():  # Vérifie si le caractère est une lettre (alphabétique)
            ascii_offset = ord('a') if char.islower() else ord('A')  # Détermine l'offset ASCII en fonction de la casse
            shifted_char = chr((ord(char) - ascii_offset + 1) % 26 + ascii_offset)  # Effectue un décalage circulaire sur les lettres
            result += shifted_char  # Ajoute le caractère décalé au résultat
        else:
            result += char  # Si le caractère n'est ni une lettre ni un chiffre, conservez-le tel quel

    return result  # Renvoie le résultat du décalage

x = sys.argv[1]  # Récupère le message à partir des arguments de ligne de commande

message = right_shift(x)  # Appelle la fonction 'right_shift' pour décaler le message

print("R_" + message)  # Affiche le message décalé avec la lettre "R_" pour indiquer un décalage vers la droite
