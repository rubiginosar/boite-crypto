import sys
import itertools
import time

def fst(password):
    characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+*...'

    start_time = time.time()  # Enregistrer le temps au début de la recherche

    for combination in itertools.product(characters, repeat=5):
        RSM = ''.join(combination)

        if RaN == RSM:
            end_time = time.time()  # Enregistrer le temps à la fin de la recherche
            elapsed_time_ms = (end_time - start_time) * 1000
            return RSM, elapsed_time_ms

    return None, None

if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("Usage: python type3.py [password]")
    else:
        RaN = sys.argv[1]
        discovered_password, elapsed_time = fst(RaN)
        
        if discovered_password:
            print("Mot de passe trouve. Il est:", discovered_password)
            if elapsed_time is not None:
                print("Temps ecoule (en millisecondes):", elapsed_time)
