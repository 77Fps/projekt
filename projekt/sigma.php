<?php
include 'baza.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $match_date = $_POST['match_date'];
    $team_a = $_POST['team_a'];
    $team_b = $_POST['team_b'];
    $wynik = $_POST['wynik'];
    $match_result = $_POST['match_result'];

    $stmt = $conn->prepare("INSERT INTO mecze (match_date, team_a, team_b, wynik, match_result) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $match_date, $team_a, $team_b, $wynik, $match_result);

    if ($stmt->execute()) {
        echo "<script>alert('Mecz dodany pomyślnie!');</script>";
    } else {
        echo "<script>alert('Błąd dodawania meczu: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projekt</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>
    <header>
        <h1>HBTV.com</h1>
        <h2>Counter Strike 2</h2>
    </header>
    <main>
        <h3>Dodaj nowy mecz</h3>
        <form method="POST" action="">
            <label for="match_date">Data rozpoczęcia meczu:</label>
            <input type="datetime-local" id="match_date" name="match_date" required><br>

            <label for="team_a">Drużyna 1:</label>
            <input type="text" id="team_a" name="team_a" required><br>

            <label for="team_b">Drużyna 2:</label>
            <input type="text" id="team_b" name="team_b" required><br>

            <label for="wynik">Wynik:</label>
            <input type="text" id="wynik" name="wynik" required><br>

            <label for="match_result">Wygrywa:</label>
            <input type="text" id="match_result" name="match_result" required><br>

            <input type="submit" value="Dodaj mecz">
        </form>

        <h3>Lista meczów</h3>
        <table>
            <tr>
                <th>Data rozpoczęcia meczu</th>
                <th>Drużyna 1</th>
                <th>Drużyna 2</th>
                <th>Wynik</th>
                <th>Wygrywa:</th>
            </tr>
            <?php
            $sql = "SELECT * FROM mecze ORDER BY match_date DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['match_date']}</td>
                            <td>{$row['team_a']}</td>
                            <td>{$row['team_b']}</td>
                            <td>{$row['wynik']}</td>
                            <td>{$row['match_result']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Nie znaleziono meczu.</td></tr>";
            }
            $conn->close();
            ?>
        </table>
    </main>
    <iframe src="https://www.hltv.org/" title="HLTV"></iframe> 

</body>
</html>