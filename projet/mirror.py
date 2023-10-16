#method 1: add a random char if palindrome and 2 bits de controle, necessite another script to decrypt 
# def miroircry(message):
#     if message == message[::-1]:
#         # inv = message[::-1]
#         # inv += random.choice(string.ascii_letters)
#         # return "01" + inv
#         else:
#             inv = "00"+message[::-1]
#     return inv    #return "00" + inv
#method2 : we fix the char at the middle and we reverse before/after that
# Import the sys module to access command-line arguments
import sys

# Define a function called 'mirror' that takes a string 's' as input
def mirror(s):
    # Initialize an empty string 'inv' to store the mirrored string
    inv = ""

    # Iterate over the characters in the input string 's' in reverse order
    for i in range(len(s)):
        inv += s[len(s) - 1 - i]

    # Check if the input string is a palindrome
    if s == inv:
        # If it's a palindrome, initialize an empty string 'inv1' for the mirrored result
        inv1 = mirror(s[0:int(len(s) / 2)])  # Recursively mirror the first half

        # Check if the length of the input string is odd
        if len(s) % 2 == 1:
            inv1 += s[int(len(s) / 2)] + s[0:int(len(s) / 2)]  # Concatenate the middle character
        else:
            inv1 += s[0:int(len(s) / 2)]  # For even-length palindromes, no middle character is added

        # Update 'inv' with the mirrored result of the first half
        inv = inv1

    # Return the mirrored string 'inv'
    return inv

# Retrieve the input string from command-line arguments
x = sys.argv[1]

# Call the 'mirror' function to mirror the input string
message = mirror(x)

# Print the mirrored message
print(message)
