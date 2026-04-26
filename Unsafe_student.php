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

    // UNSAFE: allows SQL injection
    $sql = "SELECT * FROM Student WHERE Name = '$studentName'";

    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Unsafe Student Search</title>
</head>
<body>

<h2>Unsafe Student Search</h2>
<p>This version allows SQL Injection.</p>

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
        <td><?php echo $row["Name"]; ?></td>
        <td><?php echo $row["ID"]; ?></td>
        <td><?php echo $row["Major"]; ?></td>
    </tr>
    <?php } ?>
</table>
<?php } ?>

</body>
</html>

<?php
$conn->close();
?>
