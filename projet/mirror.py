#method 1: add a random char if palindrome and 2 bits de controle, necessite another script to decrypt 
# def miroircry(message):
#     if message == message[::-1]:
#         # inv = message[::-1]
#         # inv += random.choice(string.ascii_letters)
#         # return "01" + inv
#         else:
#             inv = "00"+message[::-1]
#     return inv    #return "00" + inv
#method2 : we fix the char at the middle and we reverse before/after that
# Importez le module sys pour gérer les arguments en ligne de commande
import sys

# Définissez une fonction appelée 'mirror' qui prend une chaîne de caractères 's' en entrée
def mirror(s):
    # Initialisez une chaîne vide 'inv' pour stocker la chaîne miroir
    inv = ""

    # Parcourez les caractères de la chaîne d'entrée 's' en ordre inverse
    for i in range(len(s)):
        inv += s[len(s) - 1 - i]  # Ajoutez les caractères à 'inv' dans l'ordre inverse

    # Vérifiez si la chaîne d'entrée est un palindrome en la comparant à sa version inversée
    if s == inv:
        # Si c'est un palindrome, initialisez une chaîne vide 'inv1' pour le résultat miroir
        inv1 = mirror(s[0:int(len(s) / 2)])  # Inversez récursivement la première moitié

        # Vérifiez si la longueur de la chaîne d'entrée est impaire
        if len(s) % 2 == 1:
            inv1 += s[int(len(s) / 2)] + s[0:int(len(s) / 2)]  # Concaténez le caractère central
        else:
            inv1 += s[0:int(len(s) / 2)]  # Pour les palindromes de longueur paire, aucun caractère central n'est ajouté

        # Mettez à jour 'inv' avec le résultat miroir de la première moitié
        inv = inv1

    # Renvoyez la chaîne miroir 'inv'
    return inv

# Récupérez la chaîne d'entrée à partir des arguments en ligne de commande
x = sys.argv[1]

# Appelez la fonction 'mirror' pour inverser la chaîne d'entrée
message = mirror(x)

# Affichez le message inversé
print(message)
