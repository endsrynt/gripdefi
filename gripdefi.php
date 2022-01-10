<?php
echo "\e[0;33m[!] Reff: \e[0m";
$reff =trim(fgets(STDIN));
$listaddress = file_get_contents("akun.txt");
$addres = explode("\n", str_replace("\r","",$listaddress));
for ($i = 0; $i < count($addres); $i++){
    $address = $addres[$i];
    //echo "$address\n";

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://airdrop.gripdefi.com/?i='.$reff,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_HEADER => 1,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
  ),
));

$response = curl_exec($curl);
curl_close($curl);
$sessionid=explode(';',explode('Set-Cookie: ',$response)[1])[0];
//echo "$sessionid\n";
//echo $response;
$curl = curl_init();

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://airdrop.gripdefi.com/routes/add.php',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => 'address='.$address.'&action=add',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/x-www-form-urlencoded',
    'Cookie: PHPSESSID='.$sessionid.'; uaddress='.$reff
  ),
));

$response = curl_exec($curl);

curl_close($curl);
//echo "$response\n";
$result = json_decode($response);
//print_r($result);
$coin = $result->airdropBal;
echo "\e[0;33m[!]\e[0m Reff Count   : \e[0;32m$i\e[0m\n";
echo "\e[0;33m[!]\e[0m SessionID    : \e[0;32m$sessionid\e[0m\n";
echo "\e[0;33m[!]\e[0m Address      : \e[0;32m$address\e[0m\n";
echo "\e[0;33m[!]\e[0m Get Token    : \e[0;32m$coin GRIP\e[0m\n\n";
}
