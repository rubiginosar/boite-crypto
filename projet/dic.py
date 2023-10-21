# 3 caractere
x=["0","1"]
for i in x:
    for k in x:
        for j in x:
            motdepasse= str(i)+str(j)+str(k)
            f=open("mdp.txt","a")
            f.write(motdepasse)
            f.write("\n")
            f.close()
# 5 caractere de 0 a 9
import string
x=[]
x=string.digits
for i in x:
    for k in x:
        for j in x:
            for l in x:
                for n in x:
                    motdepasse= str(i)+str(j)+str(k)+str(l)+str(n)
                    f=open("mdp.txt","a")
                    f.write(motdepasse)
                    f.write("\n")
                    f.close()
# 5 caractere a..z A..Z 0..9 et tous les caractères spéciaux
import random
import string
char=[]
char=string.ascii_letters + string.digits + string.punctuation
for i in char:
    for k in char:
        for j in char:
            for l in char:
                for n in char:
                    motdepasse= str(i)+str(j)+str(k)+str(l)+str(n)
                    f=open("mdp.txt","a")
                    f.write(motdepasse)
                    f.write("\n")
                    f.close()