
<?php
//connect
$conn = mysqli_connect('mysql.eecs.ku.edu', 'xxxxxxx', 'xxxx', 'xxxxxxx');

if (!$conn) {
    die('Could not connect: ' . mysqli_connect_error());
}
//sanitize
$search = mysqli_real_escape_string($conn, $_GET['search']);

$query = "SELECT * FROM Product WHERE column_name LIKE '%$search%'";
$result = mysqli_query($conn, $query);

if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}

echo "<table>\n";
while ($line = mysqli_fetch_assoc($result)) {
    echo "\t<tr>\n";
    foreach ($line as $col_value) {
        echo "\t\t<td>$col_value</td>\n";
    }
    echo "\t</tr>\n";
}
echo "</table>\n";

echo "Number of fields: " . mysqli_num_fields($result) . "<br>";
echo "Number of records: " . mysqli_num_rows($result) . "<br>";

mysqli_free_result($result);
//close connection
mysqli_close($conn);
?>
