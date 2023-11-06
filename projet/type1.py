
import sys
import time

def fst(password):
    Ist = ['0', '1']
    RSM = ""  # Initialize RSM
    RaN = password  # Set RaN to the provided password

    start_time = time.time()  # Record the time at the beginning of the search

    for a in Ist:
        for b in Ist:
            for c in Ist:
                RSM = a + b + c  # Concatenate a, b, and c to form RSM

                if RaN == RSM:  # Check if RaN matches RSM
                    end_time = time.time()  # Record the time at the end of the search
                    elapsed_time_ms = (end_time - start_time) * 1000
                    return RSM, elapsed_time_ms  # Return the discovered password and elapsed time

    return None, None  # Return None if the password is not found

if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("Usage: python type1.py [password]")
    else:
        provided_password = sys.argv[1]
        discovered_password, elapsed_time = fst(provided_password)
        
        if discovered_password:
            print("Mot de passe trouve. Il est :", discovered_password)
            if elapsed_time is not None:
                print("Temps ecoule (en millisecondes):", elapsed_time)
