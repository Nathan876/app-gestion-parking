<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapports Financiers et Occupation - Admin</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<main>
    <div>
        <h2>Rapports Financiers et Occupation</h2>

        <div class="report-section">
            <h3>Rapport Financier</h3>
            <table>
                <thead>
                <tr>
                    <th>Période</th>
                    <th>Revenu Total (€)</th>
                    <th>Nombre de Réservations</th>
                    <th>Revenu Moyen par Réservation (€)</th>
                </tr>
                </thead>
                <tbody id="financialReportBody">
                <tr>
                    <td>Octobre 2025</td>
                    <td>2500.50</td>
                    <td>150</td>
                    <td>16.67</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="report-section">
            <h3>Rapport d'Occupation des Places</h3>
            <table>
                <thead>
                <tr>
                    <th>Parking</th>
                    <th>Capacité Totale</th>
                    <th>Places Occupées</th>
                    <th>Taux d'Occupation (%)</th>
                </tr>
                </thead>
                <tbody id="occupancyReportBody">
                <tr>
                    <td>Parking Centre-Ville</td>
                    <td>100</td>
                    <td>75</td>
                    <td>75.00</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</main>
</body>
</html>
