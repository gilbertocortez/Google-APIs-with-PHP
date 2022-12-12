<?php
// -------------------------------------------------------------------------------------------------------------------
// Project:     Google Authenticator (App) as 2-Factor Authorization using a timestamped one time password
// Technology:  PHP, JavaScript, HTML, CSS
// Author:      Gilberto Cortez
// Website:     InteractiveUtopia.com
// -------------------------------------------------------------------------------------------------------------------

// Start Server Session
session_start();

// Display All Errors (For Easier Development)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include composer packages
require '../vendor/autoload.php';

use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

// Initiate antonioribeiro/google2fa object
$_g2fa = new Google2FA();

// Generate a secret key and a test user
$user = new stdClass();
$user->google2fa_secret = $_g2fa->generateSecretKey();
$user->email = 'save@interactiveutopia.com';

// Store user data and key in the server session
$_SESSION['g2fa_user'] = $user;

// Provide name of application (To display to user on app)
$app_name = 'Interactive Utopia';

// Generate a custom URL from user data to provide to qr code generator
$qrCodeUrl = $_g2fa->getQRCodeUrl(
    $app_name,
    $user->email,
    $user->google2fa_secret
);

// QR Code Generation using bacon/bacon-qr-code
// Set up image rendered and writer
$renderer = new ImageRenderer(
    new RendererStyle(250),
    new ImagickImageBackEnd()
);
$writer = new Writer($renderer);

// This option is to store the QR Code image in the server
$writer->writeFile($qrCodeUrl, 'qrcode.png');

// This option will create a string with the image data and base64 enconde it
$encoded_qr_data = base64_encode($writer->writeString($qrCodeUrl));

// This will provide us with the current password
$current_otp = $_g2fa->getCurrentOtp($user->google2fa_secret);
?>

<!-- HTML Code -->
<div class="container">
<h1>Google Authenticator as 2FA with PHP Example</h1>
<h2>QR Code</h2>
<p><img src="data:image/png;base64,<?= $encoded_qr_data; ?>" alt="QR Code"></p>
<p>One-time password at time of generation: <?= $current_otp; ?></p>
<h2>Verify Code</h2>
One-time password: <input type="number" name="otp" id="otp" required />
<input type="button" value="Verify" onclick="verify_otp();" />
</div>

<!-- JavaScript Code -->
<script>
    let input_otp = document.getElementById('otp');

    const verify_otp = async () => {
        let otp = document.getElementById('otp').value;
        fetch('verify.php?otp=' + otp)
            .then((response) => response.json())
            .then((data) => {
                console.log(data)
                if (data.result == true) {
                    alert("Valid One Time Password");
                } else{
                    alert("Invalid One Time Password");
                }
            });
    }
</script>

<!-- CSS Code -->
<style>
    .container {
        text-align: center;
    }
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }
</style>