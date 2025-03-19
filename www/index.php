<?php
// www/index.php

require_once '../model/Database.php';

// Connexion à la base de données
$db = new Database('../model/notes.db');
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer et valider les données du formulaire
    $name = $_POST['nom'] ?? '';
    $note = $_POST['pages'] ?? 0;

    if (!empty($name) && is_numeric($note)) {
        // Préparer et exécuter une requête SQL pour insérer les données
        $stmt = $conn->prepare("INSERT INTO grades (name, note) VALUES (:name, :note)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':note', $note);
        $stmt->execute();
    }
}

// Récupérer toutes les notes pour les afficher
$stmt = $conn->query("SELECT * FROM grades");
$grades = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Relevé de notes</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="scripts.js"></script>
</head>
<body>
    <h1>Relevé de notes</h1>
    <div>
        <canvas id="myChart"></canvas>
    </div>

    <hr>

    <form id="gradeForm" method="POST">
        <label for="nom">Nom du contrôle</label>
        <input type="text" name="nom" required>
        <label for="pages">Note</label>
        <input type="number" name="pages" min="0" max="20" step="0.1" required>
        <button type="submit">Ajouter note</button>
    </form>

    <script>
        const labels = <?php echo json_encode(array_column($grades, 'name')); ?>;
        const data = <?php echo json_encode(array_column($grades, 'note')); ?>;

        const ctx = document.getElementById('myChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Relevé de notes',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        max: 20,
                        min: 0,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>