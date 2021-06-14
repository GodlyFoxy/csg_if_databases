<?php //https://docs.hcaptcha.com/

$SECRET_KEY = "0xcBE1E022A020e002a6E8a0aDAE2737b7e3499e7b";    
$VERIFY_URL = "https://hcaptcha.com/siteverify";

// captcha verification
//https://medium.com/@hCaptcha/using-hcaptcha-with-php-fc31884aa9ea
function captcha($token, $SECRET_KEY, $VERIFY_URL) {
    
    $data = array( 'secret'=> $SECRET_KEY, 
                    'response'=> $token );
                    
    $verification = curl_init($VERIFY_URL); // initialiseer curl  
    curl_setopt($verification, CURLOPT_POST, true); //HTTP POST 
    curl_setopt($verification, CURLOPT_POSTFIELDS, http_build_query($data)); //Maakt link compatible vorm van de data
    curl_setopt($verification, CURLOPT_RETURNTRANSFER, true);//Geef de response als output van curl_exec()
    $response = curl_exec($verification); //Voor de curl uit
    $responseData = json_decode($response);//decodeer de response zodat php het begrijpt

    return $responseData;
}
//END OF FILE
