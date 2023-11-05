import sys

def left_shift(message):
    result = ""
    for char in message:
        if char.isdigit():
            # Si le caractère est un chiffre, effectue un décalage (shift) vers la gauche modulo 10
            result += str((int(char) - 1) % 10)
        elif char.isalpha():
            # Si le caractère est alphabétique, effectue un décalage (shift) vers la gauche modulo 26
            ascii_offset = ord('a') if char.islower() else ord('A')  # Détermine l'offset ASCII pour minuscules ou majuscules
            shifted_char = chr((ord(char) - ascii_offset - 1) % 26 + ascii_offset)
            result += shifted_char
        else:
            # Pour les caractères non numériques ni alphabétiques, conserve le caractère tel quel
            result += char
    return result

# Récupère le message en ligne de commande
x = sys.argv[1]

# Applique la fonction de décalage vers la gauche
message = left_shift(x)

# Affiche le message résultant avec un préfixe "L_"
print("L_" + message)
