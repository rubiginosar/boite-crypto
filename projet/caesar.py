import sys
def cesar_cry(message, cle, direction):
    L = len(message)
    nv_message = ''
    for i in range(L):
        order = ord(message[i])
        if 65 <= order <= 90:
            if direction == 0:
                new_order = order + cle
            else:
                new_order = order - cle

            if new_order < 65:
                new_order += 26
            elif new_order > 90:
                new_order -= 26
            nv_message += chr(new_order)
        elif 97 <= order <= 122:
            if direction == 0:
                new_order = order + cle
            else:
                new_order = order - cle

            if new_order < 97:
                new_order += 26
            elif new_order > 122:
                new_order -= 26
            nv_message += chr(new_order)
        else:
            nv_message += message[i]
    return "C_" + nv_message + str(direction) + str(cle).zfill(2)

# Example values
cle = int(sys.argv[1])
direction= sys.argv[2]
if direction == "decrypt":
    direction = 1
else: 
    direction=0
message = sys.argv[3]

# Call the encryption function
resultat = cesar_cry(message, cle, direction)

# Print the result
print(resultat)
