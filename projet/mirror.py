import sys
import random
import string
def miroircry(message):
    if message == message[::-1]:
        inv = message[::-1]
        inv += random.choice(string.ascii_letters)
        return "01" + inv
    else:
        inv = message[::-1]
        return "00" + inv

def miroirdecry(message):
    inv = ""
    for i in message:
        inv = i + inv
    return inv

x=sys.argv[1]
message=miroircry(x)
print("000"+message) 