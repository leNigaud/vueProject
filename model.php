<?php
    $host = "localhost";
    $dbName = "vue";
    $username = "root";
    $password= "";

    try {
        $conn = new PDO("mysql:host=$host; dbname=$dbName", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e) {
        die("DB connect error: " . $e->getMessage());
    }

    $dataReceived = json_decode(file_get_contents("php://input"));

    if($dataReceived->action == 'fetchall') {
        // $query = "SELECT * FROM etudiant";
        $statement = $conn->query("SELECT * FROM etudiant");
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);

        print(json_encode($data));
    }

    else if($dataReceived->action == 'getall') {

        // moyenneClasse query
        $query = "SELECT AVG((note_math + note_phys) / 2) as moyenneClasse FROM etudiant";
        $statement = $conn->query($query);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $moyenneClasse = $result['moyenneClasse'];
    
        // Min and Max query
        $query = "SELECT MIN((note_math + note_phys) / 2) as MinMoyenne, MAX((note_math + note_phys) / 2) as MaxMoyenne FROM etudiant";
        $statement = $conn->query($query);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $minMoyenne = $result['MinMoyenne'];
        $maxMoyenne = $result['MaxMoyenne'];
    
        // Number of redoublants query
        $query = "SELECT COUNT(*) as NumberRedoublants FROM etudiant WHERE ((note_math + note_phys) / 2) < 10";
        $statement = $conn->query($query);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $numberRedoublants = $result['NumberRedoublants'];
    
        // Number of admis query
        $query = "SELECT COUNT(*) as NumberAdmis FROM etudiant WHERE ((note_math + note_phys) / 2) >= 10";
        $statement = $conn->query($query);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $numberAdmis = $result['NumberAdmis'];
    
        // Put all results into one array
        $data = array(
            'moyenneClasse' => $moyenneClasse,
            'minMoyenne' => $minMoyenne,
            'maxMoyenne' => $maxMoyenne,
            'numberRedoublants' => $numberRedoublants,
            'numberAdmis' => $numberAdmis,
        );
    
        // Convert to JSON and print
        print(json_encode($data));
    }
    

    else if($dataReceived->action == 'insert') {
        $numEt = $dataReceived->numEt;
        $nom = $dataReceived->nom;
        $note_math = $dataReceived->note_math;
        $note_phys = $dataReceived->note_phys;
        
        $query = "INSERT INTO etudiant (numEt, nom, note_math, note_phys) VALUES (?, ?, ?, ?)";

        $statement = $conn->prepare($query);
        $statement->execute([$numEt, $nom, $note_math, $note_phys]);
    }

    else if($dataReceived->action == 'update') {
        
        $ancientNum = $dataReceived->ancientNum;
        $numEt = $dataReceived->numEt;
        $nom = $dataReceived->nom;
        $note_math = $dataReceived->note_math;
        $note_phys = $dataReceived->note_phys;        

        $query = "UPDATE etudiant SET numEt=?, nom=?, note_math=?, note_phys=? WHERE numEt=?";
        $statement = $conn->prepare($query);

        $statement->execute([$numEt, $nom, $note_math, $note_phys, $ancientNum]);

    }

    else if($dataReceived->action == 'delete') {
        $numEt = $dataReceived->numEt;
        $query = "DELETE FROM etudiant WHERE numEt = ?";
        
        $statement = $conn->prepare($query);
        $statement->execute([$numEt]);
    }
