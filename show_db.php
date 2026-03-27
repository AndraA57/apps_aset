<?php
$conn = mysqli_connect("localhost", "root", "", "db_asset");
if (!$conn) die("Connection failed: " . mysqli_connect_error());

$result = mysqli_query($conn, "SHOW TABLES");
echo "Tables:\n";
while ($row = mysqli_fetch_row($result)) {
    echo "- " . $row[0] . "\n";
    $desc = mysqli_query($conn, "DESCRIBE " . $row[0]);
    while ($f = mysqli_fetch_assoc($desc)) {
        echo "  " . $f['Field'] . " (" . $f['Type'] . ")\n";
    }
}
?>
