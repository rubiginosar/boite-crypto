import sys
def cesar_decry(message):
    new_message = ''
    message1 = message[:-3]
    cle = message[-3:]
    if cle[0] == '0':
        cle = int(cle[1:])
    else:
        cle = -(int(cle[1:]))

    L = len(message1)
    for i in range(L):
        new_ordre = ord(message1[i]) - cle
        if 65 <= ord(message1[i]) <= 90:
            if new_ordre < 65:
                new_ordre += 26
            elif new_ordre > 90:
                new_ordre -= 26
            new_message += chr(new_ordre)
        elif 97 <= ord(message1[i]) <= 122:
            if new_ordre < 97:
                new_ordre += 26
            elif new_ordre > 122:
                new_ordre -= 26
            new_message += chr(new_ordre)
        else:
            new_message += message1[i]
    return new_message

x = sys.argv[1]

message = cesar_decry(x)


print(message)
