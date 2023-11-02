<?php
if (isset($_POST['Submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $gmail_Id = $_POST['gmailid'];
    $phoneno = $_POST['phoneno'];
    $course = $_POST['course'];

    // Connect to the database
    $localhost = 'localhost';
    $Username = 'root';
    $Password = '';
    $databasename = 'student';


    $conn = mysqli_connect($localhost, $Username, $Password, $databasename);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement
    $sql = "INSERT INTO registration (username,password, gmailid, phoneno, course) VALUES (?, ?, ?, ?, ?)";
    // INSERT INTO `registration`(`username`, `password`, `gmailid`, `phone no`, `course`)

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

   
   
    $stmt->bind_param("sssis", $username, $password, $gmail_Id, $phoneno, $course); // fix variable name

    // Execute the prepared statement
    if (!$stmt->execute()) {
        die("Error: " . $stmt->error);
    }
    // Output a success message
    echo "Register successfully";


    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // User login
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Connect to the database
        $localhost = 'localhost';
        $Username = 'root';
        $Password = '';
        $databasename = 'student';


        $conn = mysqli_connect($localhost, $Username, $Password, $databasename);

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare the SQL statement
        $sql = "SELECT * FROM registration WHERE username=? AND password=?";

        // Create a prepared statement
        $stmt = $conn->prepare($sql);

        // Bind the parameters to the statement
        $stmt->bind_param("ss", $username, $password);

        // Execute the prepared statement
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // Check if the user exists
        if ($result->num_rows > 0) {
            // User exists, start a new session
            session_start();
            $_SESSION['username'] = $username;
            echo "Login successful";
        } else {
            // User does not exist
            echo "Invalid username or password";
        }

        // Close the statement
        $stmt->close();
        $conn->close();
    }


    // Redirect to the login page
    header("location: loginpage.html");
    exit;
} else {
    echo "Error: Submit button not pressed";
}

?>


