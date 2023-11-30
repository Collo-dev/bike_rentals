
// Replace these variables with your actual database credentials

$host = DB_SERVER;
$username = DB_USERNAME;
$password = DB_PASSWORD;
$database = DB_NAME;
//$charset = DB_CHARSET;  

// Function to check if the email exists in the database
function checkIfEmailExistsInDatabase($email)
{
    global $servername, $username, $password, $dbname;

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute a query to check if the email exists
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    // Close the connection
    $conn->close();

    // Return true if the email exists, false otherwise
    return $count > 0;
}

// Main code for handling the POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch the email from the form data
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    // Validate email
    if (!$email) {
        $response = ['status' => 'error', 'message' => 'Invalid email format'];
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    // Perform database checks
    $emailExists = checkIfEmailExistsInDatabase($email);

    if (!$emailExists) {
        $response = ['status' => 'error', 'message' => 'Email not found in the database'];
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    // Simulating sending an email for password reset (replace this with actual email sending code)
    $message = "An email for password reset has been sent to $email";
    $response = ['status' => 'success', 'message' => $message];

    // Send response back to the front-end (JSON format)
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // If the request method is not POST, handle the situation accordingly
    $response = ['status' => 'error', 'message' => 'Invalid request method'];
    http_response_code(405); // Method Not Allowed
    header('Content-Type: application/json');
    echo json_encode($response);
}
