import sys
def miroircry(message):
    if message == message[::-1]:
        return "la chaine est palindrome impossible de chiffrer"
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
print("00"+message) 