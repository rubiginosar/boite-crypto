import random
import pyautogui
import sys
import time

def main(password):
    character = "01234567890abcdefjhijklmnopqrstuvwxyz"
    character_list = list(character)

    guess_password = ''
    start_time = time.time()

    while guess_password != password:
        guess_password = random.choices(character_list, k=len(password))
        if guess_password == list(password):
            end_time = time.time()
            time_taken = end_time - start_time
            print(f"Password found: {''.join(guess_password)}")
            print(f"Time taken: {time_taken:.2f} seconds")
            break

if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("Usage: python crack.py <password>")
        sys.exit(1)
    
    password_to_crack = sys.argv[1]
    main(password_to_crack)
