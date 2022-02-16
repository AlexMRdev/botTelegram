<?php
$token = '5181655141:AAGOwNr1KZEu21rDBxEwuCruSOR2_Dh55gQ';
$website = 'https://api.telegram.org/bot'.$token;

$input = file_get_contents('php://input');
$update = json_decode($input, TRUE);

$chatId = $update['message']['chat']['id'];
$message = $update['message']['text'];
$reply=$update['mesage']['relpy_to_message']['text'];

switch($message) {
    case '/start':
        $response = 'Me has iniciado';
        sendMessage($chatId, $response,TRUE);
        break;
    case '/info':
        $response = 'Hola! Soy @alex';
        sendMessage($chatId, $response,TRUE);
        break;
    case '/categorias':
        categorias($chatId,true);
        break;
    case '/titulos':
        getPc($chatId);
        break;
    default:
        $response = 'No te he entendido';
        sendMessage($chatId, $response,TRUE);
        break;
};


function sendMessage($chatId, $response,$repl) {
    if ($repl == TRUE){ 
        $reply_mark = array('force_reply' => True); 
        $url = $GLOBALS['website'].'/sendMessage?chat_id='.$chatId.'&parse_mode=HTML&reply_markup='.json_encode($reply_mark).'&text='.urlencode($response); 
    }else{ 
        $url = $GLOBALS['website'].'/sendMessage?chat_id='.$chatId.'&parse_mode=HTML&text='.urlencode($response); 
    } 
    file_get_contents($url);
};

function getPc($chatId){
    $context= stream_context_create(array('http'=> array('header'=>'Accept:application/xml')));
    $url='https://www.europapress.es/rss/rss.aspx';
    $xmlstring= file_get_contents($url, false, $context);
    $xml =simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
    $json= json_encode($xml);
    $array= json_decode($json , TRUE);
    
    for($i=0; $i<=9; $i++ ){
        $titulos=$array['channel']['item'][$i]['title']."<a href='".$array['channel']['item'][$i]['link']."'>+info</a>"; 
        sendMessage($chatId,$titulos,false);
    };    
};

function categorias($chatId){
    $context= stream_context_create(array('http'=> array('header'=>'Accept:application/xml')));
    $url='https://www.europapress.es/rss/rss.aspx';
    $xmlstring= file_get_contents($url, false, $context);
    $xml =simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
    $json= json_encode($xml);
    $array= json_decode($json , TRUE);

    
    for($i=0; $i<=9; $i++ ){
        $titulos=$array['channel']['item'][$i]['category'];
    };
    sendMessage($chatId,$titulos,TRUE);   
};
// function categorias($chatId){
//     $context= stream_context_create(array('http'=> array('header'=>'Accept:application/xml')));
//     $url='https://www.abc.es/rss/feeds/abc_ultima.xml';
//     $xmlstring= file_get_contents($url, false, $context);
//     $xml =simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
//     $json= json_encode($xml);
//     $array= json_decode($json , TRUE);
//         for($i=0; $i<=9; $i++ ){
//         $titulos=$array['channel']['item'][$i]['category'];
//         sendMessage($chatId,$titulos,TRUE);   
//     }
// };



//  function buscarNoticia($chatId,$palabra){
//     $context= stream_context_create(array('http'=> array('header'=>'Accept:application/xml')));
//     $url='https://www.europapress.es/rss/rss.aspx';
//     $xmlstring= file_get_contents($url, false, $context);
//     $xml =simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
//     $json= json_encode($xml);
//     $array= json_decode($json , TRUE);

//     sendMessage($chatId,"Indique la palabra a buscar y le saldran 5 noticias que la contienen");
    

//  };
?>