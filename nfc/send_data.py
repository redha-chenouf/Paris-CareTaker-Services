import serial
import requests
import time
from datetime import datetime

serial_port = 'COM3'
baud_rate = 9600

server_url = 'https://www.pariscs.fr/rfid.php'

id_bien = input("Entrez l'ID du bien : ")

def send_data_to_server(uid, scan_datetime, id_bien):
    try:
        payload = {'uid': uid, 'timestamp': scan_datetime, 'id_bien': id_bien}
        response = requests.post(server_url, data=payload, verify=False)
        if response.status_code == 200:
            print(f"Données envoyées avec succès au serveur : {uid} - {scan_datetime} - ID Bien : {id_bien}")
        else:
            print(f"Échec de l'envoi des données - Statut {response.status_code}")
    except requests.exceptions.RequestException as e:
        print(f"Erreur de connexion au serveur : {e}")

if __name__ == '__main__':
    try:
        ser = serial.Serial(serial_port, baud_rate, timeout=1)
        print(f"Port série {serial_port} ouvert avec succès")

        while True:
            if ser.in_waiting > 0:
                # Lire la première ligne "Card detected:"
                line1 = ser.readline().decode('utf-8').strip()
                if line1.startswith("Card detected:"):
                    # Lire la deuxième ligne (contenant l'UID)
                    line2 = ser.readline().decode('utf-8').strip()
                    uid = line2  # Utiliser la deuxième ligne comme UID

                    # Obtenir la date et l'heure actuelle
                    scan_datetime = datetime.now().strftime('%Y-%m-%d %H:%M:%S')

                    # Envoyer les données au serveur
                    send_data_to_server(uid, scan_datetime, id_bien)

            time.sleep(1)

    except serial.SerialException as se:
        print(f"Erreur série : {se}")
    except Exception as e:
        print(f"Erreur inattendue : {e}")
    finally:
        if 'ser' in locals() and ser.is_open:
            ser.close()
            print("Port série fermé")
