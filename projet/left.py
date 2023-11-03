import sys
def left_shift(message):
    result = ""
    for char in message:
        if char.isdigit():
            result += str((int(char) - 1) % 10)
        elif char.isalpha():
            ascii_offset = ord('a') if char.islower() else ord('A')
            shifted_char = chr((ord(char) - ascii_offset - 1) % 26 + ascii_offset)
            result += shifted_char
        else:
            result += char
    return result


x = sys.argv[1]

message = left_shift(x)


print("L_"+message)