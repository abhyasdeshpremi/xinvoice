<?php 

// for encrypt and decrypt
function encrypt_decrypt($string, $action = 'encrypt')
{
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'AA74CDCC2BBRT935136HH7B63C27'; // user define private key
    $secret_iv = '5fgf5HJ5g27'; // user define secret key
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16); // sha256 is hash_hmac_algo
    if ($action == 'encrypt') {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if ($action == 'decrypt') {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}

//millitime function
function millitime() {
    date_default_timezone_set("UTC");
    $microtime = microtime();
    $comps = explode(' ', $microtime);
  
    // Note: Using a string here to prevent loss of precision
    // in case of "overflow" (PHP converts it to a double)
    return sprintf('%d%03d', $comps[1], $comps[0] * 1000);
}
function invoiceIDCreation(){
    $ci = &get_instance();
    $ci->load->library('session');
    $seconds = millitime();
    $invoiceString = "invoice_".$ci->session->userdata('username')."_".$ci->session->userdata('firmcode')."_".$seconds;
    return encrypt_decrypt($invoiceString, 'encrypt');
}

function validationInvoiceID($invoiceID){
    $invoiceIDlast2 = substr($invoiceID, -2);
    $invoiceIDlast3 = substr($invoiceID, -3);
    if(($invoiceIDlast2 === '==') && ($invoiceIDlast3 !== '===')){
        $decrypt = encrypt_decrypt($invoiceID, 'decrypt');
        if(strlen($decrypt) > 0){
            $invoiceArray = explode("_", $decrypt);
            if(count($invoiceArray) >= 4){
                if($invoiceArray !== "invoice"){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }
    }
    return false;
}

function debug_function(){
    $ci = &get_instance();

      //load the session library
    $ci->load->library('session');
    echo "create Invoice";
    echo "<br>";
    echo $seconds = millitime();
    echo "<br>";
    echo date("d/m/Y H:i:s", ($seconds/1000));
    echo "<br>";
    $finalString = "invoice_".$ci->session->userdata('username')."_".$ci->session->userdata('firmcode')."_".$seconds;
    echo "Your Encrypted password is = ". $pwd = encrypt_decrypt($finalString, 'encrypt');
    echo "<br>";
    echo "Your Decrypted password is = ". encrypt_decrypt($pwd, 'decrypt');
    echo "<br>";
    echo "End Invoice";
}