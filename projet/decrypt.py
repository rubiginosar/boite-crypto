import sys
def dechiffrement_affine(encrypted_message):
    a = int(encrypted_message[0:2])
    b = int(encrypted_message[2:4])
    message = encrypted_message[4:]

    alphabet = 'abcdefghijklmnopqrstuvwxyz'
    decrypted_message = ''

    for lettre in message:
        if lettre.lower() in alphabet:
            index = alphabet.index(lettre.lower())
            a_inverse = None

            # Find the modular multiplicative inverse of 'a' (a^-1) modulo 26
            for i in range(1, 26):
                if (a * i) % 26 == 1:
                    a_inverse = i
                    break

            if a_inverse is not None:
                # Decrypt the letter
                x = (a_inverse * (index - b)) % 26
                if lettre.isupper():
                    decrypted_letter = alphabet[x].upper()
                else:
                    decrypted_letter = alphabet[x]
                decrypted_message += decrypted_letter
            else:
                # If 'a' doesn't have an inverse, return an error message
                return "Error: 'a' does not have an inverse modulo 26"
        else:
            # Non-alphabet characters are not modified
            decrypted_message += lettre

    return decrypted_message

# Example usage:
encrypted_message =sys.argv[1] # Replace with your encrypted message
decrypted_message = dechiffrement_affine(encrypted_message)
print(decrypted_message)

