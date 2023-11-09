<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <!-- Include necessary CSS or stylesheets -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include jQuery -->
</head>
<body>

<h2>Forgot Password</h2>
<p>Please enter your email address to reset your password.</p>

<form id="forgot-password-form" method="post">
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div>
        <input type="submit" value="Reset Password">
    </div>
</form>

<script>
$(document).ready(function() {
    $('#forgot-password-form').submit(function(e){
        e.preventDefault();
        var email = $('#email').val();

        $.ajax({
            url: 'reset_password_backend.php', // Replace with the correct path to your backend file
            method: 'POST',
            data: { email: email },
            success: function(response) {
                // Example: Display a message based on the response
                if (response.status === 'success') {
                    alert(response.message); // Show success message
                } else {
                    alert('Error: ' + response.message); // Show error message
                }
            },
            error: function(xhr, status, error) {
                alert('An error occurred: ' + error); // Show error if the AJAX request fails
            }
        });
    });
});
</script>

</body>
</html>
