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
