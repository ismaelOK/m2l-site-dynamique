<?php
// Forcer le téléchargement en PDF
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="bulletin.pdf"');

// Démarrer le tampon de sortie pour capturer le contenu
ob_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bulletin PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Bulletins de Salaire</h1>
    <table>
        <thead>
            <tr>
                <th>Contrat</th>
                <th>Mois</th>
                <th>Année</th>
                <th>Lien PDF</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Boucle pour afficher les bulletins
            require 'controleur/controleurSalarie.php';
            foreach ($dataBulletin2 as $bulletin) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($bulletin['contrat']) . "</td>";
                echo "<td>" . htmlspecialchars($bulletin['mois']) . "</td>";
                echo "<td>" . htmlspecialchars($bulletin['annee']) . "</td>";
                echo "<td><a href='" . htmlspecialchars($bulletin['lien_pdf']) . "'>Télécharger PDF</a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php
// Obtenir le contenu du tampon et le retourner au client
$html = ob_get_clean();

// Envoyer le contenu au navigateur
echo $html;
?>
