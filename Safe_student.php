<?php
$host = "sql1.njit.edu";
$dbname = "art56";
$username = "art56";
$password = "cw85*Fmusd|6bKuLZXTG";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed");
}

$result = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentName = $_POST["studentName"];

    // SAFE: prepared statement prevents SQL injection
    $sql = "SELECT Name, ID, Major FROM Student WHERE Name = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $studentName);
    $stmt->execute();

    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Safe Student Search</title>
</head>
<body>

<h2>Safe Student Search</h2>
<p>This version prevents SQL Injection using prepared statements.</p>

<form method="post">
    <label>Enter Student Name:</label>
    <input type="text" name="studentName">
    <input type="submit" value="Search">
</form>

<?php if ($result !== null) { ?>
<table border="1">
    <tr>
        <th>Name</th>
        <th>ID</th>
        <th>Major</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo htmlspecialchars($row["Name"]); ?></td>
        <td><?php echo htmlspecialchars($row["ID"]); ?></td>
        <td><?php echo htmlspecialchars($row["Major"]); ?></td>
    </tr>
    <?php } ?>
</table>
<?php } ?>

</body>
</html>

<?php
if (isset($stmt)) {
    $stmt->close();
}
$conn->close();
?>
