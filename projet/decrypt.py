import sys

def miroirdecry(message):
    if message.startswith("00"):
        # Remove the leading "000" and reverse the rest
        reversed_message = message[3:][::-1]
        return reversed_message
    elif message.startswith("00"):
        # Remove the leading "001" and the last letter, then reverse the rest
        modified_message = message[3:-1][::-1]
        return modified_message
    else:
        return "Invalid format"

if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("Usage: python decrypt.py <message>")
    else:
        encrypted_message = sys.argv[1]
        decrypted = miroirdecry(encrypted_message)
        print(decrypted)
