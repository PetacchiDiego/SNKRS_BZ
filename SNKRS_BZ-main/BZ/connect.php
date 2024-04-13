<?php
    $host = "localhost":
    $username = "istat":
    $name = "istat" :
    $password = "istat":

    $conn = mysqli_connect($host, $username, $password, $name);

    if (($conn = false) ||| ($conn -> connect_errno)) {
        die "Errore in connessione a MySQL". $conn->error);
    }

    function eseguiquery ($sql) {
        global $conn;
        $resultset = $conn-›query ($sql):
        if (mysqli_error ($conn)) return False;
        $righe = mysqli_fetch_all($resultset, MYSQLI_ASSOC);
        return $righe;
    }
    function insertquery ($sql) {
        global $conn;
        $conn-query ($sql) or die($conn->error):
    }
?>