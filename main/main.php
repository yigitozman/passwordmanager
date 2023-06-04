<?php
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "passwordmanager";


// Establish a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to encrypt a string
function encrypt($data)
{
    // Perform encryption logic here (e.g., using a secure encryption algorithm)
    // ...
    $encryptionKey = "7075166676";
    $encryptedData = openssl_encrypt($data, 'AES-256-CBC', $encryptionKey, 0, substr(hash('sha256', $encryptionKey), 0, 16));
    return $encryptedData;
}

// Function to decrypt a string
function decrypt($encryptedData)
{
    // Perform decryption logic here (e.g., using the same encryption algorithm)
    // ...
    $encryptionKey = "7075166676";
    $decryptedData = openssl_decrypt($encryptedData, 'AES-256-CBC', $encryptionKey, 0, substr(hash('sha256', $encryptionKey), 0, 16));
    return $decryptedData;
}

// Fetch login information from the database
$user_id = $_SESSION["user_id"];
$query = "SELECT * FROM userdata WHERE user_id = $user_id";
$result = $conn->query($query);

// Store decrypted login information
$logins = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Decrypt the login information
        $username = decrypt($row['username']);
        $password = decrypt($row['password']);

        // Add decrypted login information to the array
        $logins[] = array('username' => $username, 'password' => $password);
    }
}

// Handle form submission to create new data
if (isset($_POST['submit'])) {
    $newUsername = encrypt($_POST['new_username']);
    $newPassword = encrypt($_POST['new_password']);

    // Insert the new data into the database
    $createQuery = "INSERT INTO userdata (username, password, user_id) VALUES ('$newUsername', '$newPassword', '$user_id')";

    if ($conn->query($createQuery) === TRUE) {
        // Refresh the page to show the updated data
        header("Location: main.php");
        exit();
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}


$sql = "SELECT * FROM userdata WHERE user_id = '$user_id'";
$result = $conn->query($sql);



?>

<!DOCTYPE html>
<html>

<head>
    <title>Password Manager</title>
    <link rel="stylesheet" href="style.css" media="screen">
</head>

<body>
    <h2>Password Manager</h2>

    <h3>Login Information:</h3>
    <table>
        <thead>
            <tr>
                <th>Username</th>
                <th>Password</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($logins as $login) { ?>
                <?php $row = $result->fetch_assoc(); ?>
                <tr>
                    <td>
                        <?php echo $login["username"] ?>
                    </td>
                    <td>
                        <?php echo $login['password']; ?>
                    </td>
                    <td>
                        <?php echo "<td><a href='delete.php?data_id=" . $row["data_id"] . "'> <button>Delete</button></a></td>"; ?>
                    </td>
                </tr>
            <?php } ?>

        </tbody>
    </table>

    <h3>Create New Data:</h3>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="new_username">Username:</label>
        <input type="text" name="new_username" required><br><br>

        <label for="new_password">Password:</label>
        <input type="password" name="new_password" required><br><br>

        <input type="submit" name="submit" value="Create Data">
    </form>
    <br>
    <td><a href="login_screen.php"> <button>Logout</button></a></td>
</body>

</html>