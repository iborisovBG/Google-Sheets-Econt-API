
<?php
/**
 * Разработено от Ивайло Борисов
 *
 * Google Sheets + Еконт модул
 * Следния скрипт позволява импортването на добавени
 * поръчки в Google Sheet към Еконт създавайки
 * Нови Товарителници
 * 
 *
 * 
 * Github : https://github.com/iborisovBG
 * Facebook : https://www.facebook.com/einsteineee
 * телефон за контакт 0878550460
 *
 */
// [START sheets_quickstart]
require __DIR__ . '/vendor/autoload.php';



/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient()
{
    $client = new Google_Client();
    $client->setApplicationName('Google Sheets API PHP Quickstart');
    $client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);
    $client->setAuthConfig('credentials.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    // Load previously authorized token from a file, if it exists.
    // The file token.json stores the user's access and refresh tokens, and is
    // created automatically when the authorization flow completes for the first
    // time.
    $tokenPath = 'token.json';
    if (file_exists($tokenPath)) {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
    }

    // If there is no previous token or it's expired.
    if ($client->isAccessTokenExpired()) {
        // Refresh the token if possible, else fetch a new one.
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        } else {
            // Request authorization from the user.
            $authUrl = $client->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            print 'Enter verification code: ';
            $authCode = trim(fgets(STDIN));

            // Exchange authorization code for an access token.
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            $client->setAccessToken($accessToken);

            // Check to see if there was an error.
            if (array_key_exists('error', $accessToken)) {
                throw new Exception(join(', ', $accessToken));
            }
        }
        // Save the token to a file.
        if (!file_exists(dirname($tokenPath))) {
            mkdir(dirname($tokenPath), 0700, true);
        }
        file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    }
    return $client;
}


// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_Sheets($client);

// Prints the names and majors of students in a sample spreadsheet:
// https://docs.google.com/spreadsheets/d/1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms/edit
$spreadsheetId = '1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms';
$range = 'Class Data!A2:E';
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
$values = $response->getValues();

if (empty($values)) {
    print "No data found.\n";
} else {
    print "Name, Major:\n";
    foreach ($values as $row) {
        
        // Print columns A and E, which correspond to indices 0 and 4.
       //  printf("%s, %s\n", $row[1], $row[2]);




//////////////////////////////////////////ЕКОНТ/////////////////////////////////////////////////////////

// Пример за извикване на обект за иницииране на отдалечена услуга 
$curl = curl_init(); 
curl_setopt($curl, CURLOPT_URL, 'http://delivery.econt.com/services/OrdersService.updateOrder.json'); 
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); 
curl_setopt($curl, CURLOPT_HTTPHEADER, [ 
'Content-Type: application/json', 
'Authorization: ИДЕНТИФИКАЦИОНЕН КОД' 
]); 
curl_setopt($curl, CURLOPT_POST, true); 
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array( // Type: Order -> http://delivery.econt.com/services/#Order 
  'id' => '', // ако имаме "id" ще потърси съществуваща поръчка и ще я обнови с новите данни, ако не намери ще добави нова 
  'orderNumber' => '', //ADD FOLLOWING ROW FROM SHEET TABLE EXAMPLE $row[1]
  'status' => '', //ADD FOLLOWING ROW FROM SHEET TABLE EXAMPLE $row[1]
  'orderTime' => '', //ADD FOLLOWING ROW FROM SHEET TABLE EXAMPLE $row[1]
  'cod' => '', //ADD FOLLOWING ROW FROM SHEET TABLE EXAMPLE $row[1]
  'partialDelivery' => '', //ADD FOLLOWING ROW FROM SHEET TABLE EXAMPLE $row[1]
  'currency' => '', //ADD FOLLOWING ROW FROM SHEET TABLE EXAMPLE $row[1]
  'shipmentDescription' => '', //ADD FOLLOWING ROW FROM SHEET TABLE EXAMPLE $row[1]
  'shipmentNumber' => '', //ADD FOLLOWING ROW FROM SHEET TABLE EXAMPLE $row[1]
  'customerInfo' => array( // Type: CustomerInfo -> http://delivery.econt.com/services/#CustomerInfo 
    'id' => '', //ADD FOLLOWING ROW FROM SHEET TABLE EXAMPLE $row[1]
    'name' => '', //ADD FOLLOWING ROW FROM SHEET TABLE EXAMPLE $row[1]
    'face' => '', //ADD FOLLOWING ROW FROM SHEET TABLE EXAMPLE $row[1]
    'phone' => '', //ADD FOLLOWING ROW FROM SHEET TABLE EXAMPLE $row[1]
    'e-mail' => '', //ADD FOLLOWING ROW FROM SHEET TABLE EXAMPLE $row[1]
    'countryCode' => '', //ADD FOLLOWING ROW FROM SHEET TABLE EXAMPLE $row[1]
    'cityName' => '', //ADD FOLLOWING ROW FROM SHEET TABLE EXAMPLE $row[1]
    'postCode' => '', //ADD FOLLOWING ROW FROM SHEET TABLE EXAMPLE $row[1]
    'officeCode' => '', //ADD FOLLOWING ROW FROM SHEET TABLE EXAMPLE $row[1]
    'zipCode' => '', //ADD FOLLOWING ROW FROM SHEET TABLE EXAMPLE $row[1]
    'address' => '', //ADD FOLLOWING ROW FROM SHEET TABLE EXAMPLE $row[1]
    'priorityFrom' => '', //ADD FOLLOWING ROW FROM SHEET TABLE EXAMPLE $row[1]
    'priorityTo' => '' //ADD FOLLOWING ROW FROM SHEET TABLE EXAMPLE $row[1]
  ), 
  'items' => array( 
    0 => array( // Type: OrderItem -> http://delivery.econt.com/services/#OrderItem 
      'name' => '', //ADD FOLLOWING ROW FROM SHEET TABLE EXAMPLE $row[1]
      'SKU' => '', //ADD FOLLOWING ROW FROM SHEET TABLE EXAMPLE $row[1]
      'URL' => '', //ADD FOLLOWING ROW FROM SHEET TABLE EXAMPLE $row[1]
      'count' => '', //ADD FOLLOWING ROW FROM SHEET TABLE EXAMPLE $row[1]
      'hideCount' => '', // приема стойности 0 и 1. Служи за скриване на формата за промяна на количество.  
      'totalPrice' => '', //ADD FOLLOWING ROW FROM SHEET TABLE EXAMPLE $row[1]
      'totalWeight' => '' //ADD FOLLOWING ROW FROM SHEET TABLE EXAMPLE $row[1]
    ), 
    1 => array( 
      'name' => '', //ADD FOLLOWING ROW FROM SHEET TABLE EXAMPLE $row[1]
      'SKU' => '', //ADD FOLLOWING ROW FROM SHEET TABLE EXAMPLE $row[1]
      'URL' => '', //ADD FOLLOWING ROW FROM SHEET TABLE EXAMPLE $row[1]
      'count' => '', //ADD FOLLOWING ROW FROM SHEET TABLE EXAMPLE $row[1]
      'hideCount' => '', // приема стойности 0 и 1. Служи за скриване на формата за промяна на количество.  
      'totalPrice' => '', //ADD FOLLOWING ROW FROM SHEET TABLE EXAMPLE $row[1]
      'totalWeight' => '' //ADD FOLLOWING ROW FROM SHEET TABLE EXAMPLE $row[1]
    ) 
    // ... 
  ) 
))); 
curl_setopt($curl, CURLOPT_TIMEOUT, 10); 
 
// Изпращане на заявката 
$response = curl_exec($curl); 
 
// Показване на върнатия резултат 
var_dump($response); 
var_dump(curl_error($curl));  

//////////////////////////////////////////ЕКОНТ/////////////////////////////////////////////////////////


        
    }
}
// [END sheets_quickstart]