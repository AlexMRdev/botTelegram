<?php
$token = '5181655141:AAGOwNr1KZEu21rDBxEwuCruSOR2_Dh55gQ';
$website = 'https://api.telegram.org/bot'.$token;

$input = file_get_contents('php://input');
$update = json_decode($input, TRUE);

$chatId = $update['message']['chat']['id'];
$message = $update['message']['text'];

switch($message) {
    case '/start':
        $response = 'Me has iniciado';
        sendMessage($chatId, $response);
        break;
    case '/info':
        $response = 'Hola! Soy @alex';
        sendMessage($chatId, $response);
        break;
    case '/tengo_sed':
        $response="Pues bebe agua tonto";
        sendMessage($chatId, $response);
        break;
    case '/titulos':
        getPc($chatId);
        break;
    default:
        $response = 'No te he entendido';
        sendMessage($chatId, $response);
        break;
}

function sendMessage($chatId, $response) {
    $url = $GLOBALS['website'].'/sendMessage?chat_id='.$chatId.'&parse_mode=HTML&text='.urlencode($response);
    file_get_contents($url);
};
function getPc($chatId){
    $context= stream_context_create(array('http'=> array('header'=>'Accept:application/xml')));
    /*$url='https://www.europapress.es/rss/rss.aspx';
    $xmlstring= file_get_contents($url, false, $context);
    $xml =simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
    $json= json_encode($xml);
    $array= json_decode($json , TRUE);*
    
    for($i=0; $i<=9; $i++ ){
        $titulos=$array['channel']['item'][$i]['title']."<a href='".$array['channel']['item'][$i]['link']."'>+info</a>"; 
        sendMessage($chatId,$titulos);
    };*/
    $url='https://www.freetogame.com/api/games';
    /*$json= json_encode($url);
    $array= json_decode($json , TRUE);*/
    for($i=0; $i<=9; $i++ ){
        $titulos=$url['id'][$i]['title']; 
        sendMessage($chatId,$titulos);
    };
};

?>