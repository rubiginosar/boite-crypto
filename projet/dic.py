# 3 caractere
x = ["0", "1"]
for i in x:
    for k in x:
        for j in x:
            motdepasse = str(i) + str(j) + str(k)
            f = open("mdp.txt", "a")  # Ouvre le fichier "mdp.txt" en mode append
            f.write(motdepasse)  # Écrit le mot de passe dans le fichier
            f.write("\n")  # Ajoute une nouvelle ligne
            f.close()  # Ferme le fichier

# 5 caractere de 0 a 9
import string
x = string.digits  # x contient les chiffres de 0 à 9
for i in x:
    for k in x:
        for j in x:
            for l in x:
                for n in x:
                    motdepasse = str(i) + str(j) + str(k) + str(l) + str(n)
                    f = open("mdp.txt", "a")  # Ouvre le fichier "mdp.txt" en mode append
                    f.write(motdepasse)  # Écrit le mot de passe dans le fichier
                    f.write("\n")  # Ajoute une nouvelle ligne
                    f.close()  # Ferme le fichier

