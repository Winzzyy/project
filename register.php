<?php
// Fungsi untuk membuat kode acak 4 huruf
function generateVerificationCode() {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return 'IAF-' . substr(str_shuffle($characters), 0, 4);
}

// Inisialisasi kode verifikasi
$verification_code = generateVerificationCode();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="assets/css/register-styles.css">
    <script>
        // Simpan kode verifikasi yang dihasilkan oleh PHP
        const verificationCode = "<?php echo $verification_code; ?>";

        // Fungsi untuk mengambil motto dari API dan memperbarui kolom "Your Motto"
        function fetchMotto() {
            const habboName = document.getElementById('habbo_name').value;
            const url = `https://www.habbowidgets.com/habinfo/com/${habboName}`;

            if (!habboName) {
                alert("Please enter a Habbo name.");
                return;
            }

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    console.log(data);  // Lihat data yang diterima

                    // Jika motto ditemukan, update kolom "Your Motto"
                    if (data.motto) {
                        document.getElementById('user_motto').value = data.motto;
                    } else {
                        // Jika tidak ada motto ditemukan, beri pesan kesalahan di kolom "Your Motto"
                        document.getElementById('user_motto').value = "Motto not found";
                    }
                })
                .catch(error => {
                    console.error("Error fetching motto:", error);
                    // Jika terjadi kesalahan, beri pesan di kolom "Your Motto"
                    document.getElementById('user_motto').value = "Error retrieving motto";
                });
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="images/iaf.gif" alt="Logo">
        </div>
        <h1>Register</h1>
        <form method="POST" action="register.php">
            <label for="habbo_name">Habbo Name</label>
            <input type="text" id="habbo_name" name="habbo_name" placeholder="Enter your Habbo name" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter password" required>

            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm password" required>

            <label for="motto_verification_code">Motto Verification Code</label>
            <input type="text" id="motto_verification_code" name="motto_verification_code" value="<?php echo $verification_code; ?>" readonly>

            <label for="user_motto">Your Motto</label>
            <input type="text" id="user_motto" name="user_motto" placeholder="Enter motto verification code" required>

            <button type="button" onclick="fetchMotto()">Refresh Motto</button>
            <button type="submit">Next</button>
        </form>
    </div>
</body>
</html>
