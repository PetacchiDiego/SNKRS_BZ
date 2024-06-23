<?php
// Configurazione del database
$servername = "localhost";
$username = "petacchidiego";
$password = "";
$dbname = "my_petacchidiego";

// Connessione al database
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Funzione per importare i dati da CSV
function importaCSV($conn, $filePath, $siteId, $hasColor) {
    if (($handle = fopen($filePath, "r")) !== FALSE) {
        // Salta l'intestazione
        fgetcsv($handle, 1000, ",");

        // Inserimento dati
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Preparazione della query SQL
            if ($hasColor) {
                $sql = "REPLACE INTO item (idSito, link, nome, prezzo, linkImg, color, tipologia) VALUES (?, ?, ?, ?, ?, ?, ?)";
            } else {
                $sql = "REPLACE INTO item (idSito, link, nome, prezzo, linkImg, tipologia) VALUES (?, ?, ?, ?, ?, ?)";
            }

            $stmt = $conn->prepare($sql);
            if ($stmt === FALSE) {
                die("Errore nella preparazione della query: " . $conn->error);
            }

            // Bind dei parametri
            if ($hasColor) {
                $stmt->bind_param("ississs", $siteId, $data[0], $data[1], $data[2], $data[3], $data[4], $data[5]);
            } else {
                $stmt->bind_param("ississ", $siteId, $data[0], $data[1], $data[2], $data[3], $data[4]);
            }

            // Esecuzione della query
            if (!$stmt->execute()) {
                echo "Errore nell'inserimento dei dati: " . $stmt->error . "<br>";
            }
        }

        fclose($handle);
    } else {
        echo "Errore nell'apertura del file: $filePath";
    }
}

// Elimina i dati esistenti per i siti specificati
function cancellaDati($conn, $siteId) {
    $sql = "DELETE FROM item WHERE idSito = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === FALSE) {
        die("Errore nella preparazione della query: " . $conn->error);
    }
    $stmt->bind_param("i", $siteId);
    if (!$stmt->execute()) {
        echo "Errore nella cancellazione dei dati: " . $stmt->error . "<br>";
    }
}

// Percorsi dei file CSV sul server
$fileHypeboost = '/SNKRS_BZ/dati.csv';
$fileNaked = '/SNKRS_BZ/datiNaked.csv';
$fileDropList = '/SNKRS_BZ/datiDropList.csv';

// Importazione dei dati
cancellaDati($conn, 1);
importaCSV($conn, $fileHypeboost, 1, false);

cancellaDati($conn, 3);
importaCSV($conn, $fileNaked, 3, true);

cancellaDati($conn, 2);
importaCSV($conn, $fileDropList, 2, false);

// Chiudi la connessione
$conn->close();
?>
