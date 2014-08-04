<html>
  <body>
    <form action="" method="post">
<?php

require_once('system/recaptchalib.php');

// Get a key from https://www.google.com/recaptcha/admin/create
$publickey = "6Lcb-_cSAAAAAJDbx1f7OgP6Eigh39fuxBIKoGJ8";
$privatekey = "6Lcb-_cSAAAAAGTU-Fgeosq9j9rcbK2G1qbsjrmD";

# the response from reCAPTCHA
$resp = null;
# the error code from reCAPTCHA, if any
$error = null;

# was there a reCAPTCHA response?
if (isset($_POST["recaptcha_response_field"])){
        $resp = recaptcha_check_answer ($privatekey,
                                        $_SERVER["REMOTE_ADDR"],
                                        $_POST["recaptcha_challenge_field"],
                                        $_POST["recaptcha_response_field"]);

        if ($resp->is_valid) {
                echo "You got it!";
        } else {
                # set the error code so that we can display it
                $error = $resp->error;
        }
}
echo recaptcha_get_html($publickey, $error);
?>
    <br/>
    <input type="submit" value="submit" />
    </form>
  </body>
</html>
