# calcDistance

Parametro:
cep
_________________________________________________________
Exemplo usando direto no URL:

http://localhost/talkall/calcDistance.php?cep=86703040
_________________________________________________________
Exemplo cURL:

$curl = curl_init();

curl_setopt_array($curl, array(

  CURLOPT_URL => 'http://localhost/talkall/calcDistance.php?cep=86703040',

  CURLOPT_RETURNTRANSFER => true,
  
  CURLOPT_ENCODING => '',
  
  CURLOPT_MAXREDIRS => 10,

  CURLOPT_TIMEOUT => 0,
  
  CURLOPT_FOLLOWLOCATION => true,

  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

  CURLOPT_CUSTOMREQUEST => 'GET',

));

$response = curl_exec($curl);

curl_close($curl);

echo $response;
