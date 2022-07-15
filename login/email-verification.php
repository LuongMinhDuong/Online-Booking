<?php
include '../conn.php';
if (isset($_POST["verify_email"])) {
    $email = $_POST["email"];
    $verification_code = $_POST["verification_code"];
}
$sql = "UPDATE accounts SET email_verified_at = NOW() WHERE email = '" . $email . "' AND verification_code = '" . $verification_code . "'";
$result = $conn->query($sql);

if (mysqli_affected_rows($conn) == 0) {
    die("Verification code failed.");
}
echo "<p>You can login now.</p>";
exit();
?>

<form action="" method="post">
    <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>" required>
    <input type="text" name="verification_code" placeholder="Enter Verification Code" required>

    <input type="submit" name="verify_email" value="Verify Email">
</form>