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
        sendMessage($chatId, $response,false);
        break;
    case '/info':
        $response = 'Hola! Soy @alex';
        sendMessage($chatId, $response,false);
        break;
    case '/categorias':
        $keyboard = array('keyboard' =>
        array(array(
            array('text'=>'/nacional 📣','callback_data'=>"1"),
            array('text'=>'/internacional 🌎','callback_data'=>"2"),
            array('text'=>'/economia 💵','callback_data'=>"3")
        ),
            array(
                array('text'=>'/deportes ⚽','callback_data'=>"4")
            )), 'one_time_keyboard' => false, 'resize_keyboard' => true
    );
    file_get_contents('https://api.telegram.org/bot5181655141:AAGOwNr1KZEu21rDBxEwuCruSOR2_Dh55gQ/sendMessage?chat_id='.$chatId.'&parse_mode=HTML&reply_markup='.json_encode($keyboard).'&text=Cargando...');
        break;
    case '/nacional 📣':
        nacional($chatId,false);
        break;
    case '/economia 💵':
        economia($chatId,false);
        break;
    case '/internacional 🌎':
        internacional($chatId,false);
        break;
    case '/titulos':
        titulos($chatId);
        break;
    case '/deportes ⚽':
        deportes($chatId);
        break;
    case '/mostrar':
        $response='Eliga una de estas categorias: Nacional, Internacional, Economia, Deportes';
        Mostrarcategorias($chatId,$response,TRUE);
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

function titulos($chatId){
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

function Mostrarcategorias($chatId,$response){
    $context= stream_context_create(array('http'=> array('header'=>'Accept:application/xml')));
    $url='https://www.elperiodico.com/es/rss/'.$response.'/rss.xml';
    $xmlstring= file_get_contents($url, false, $context);
    $xml =simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
    $json= json_encode($xml);
    $array= json_decode($json , TRUE);

        for($i=0; $i<=4; $i++ ){
            $titulos=$array['channel']['item'][$i]['title']."<a href='".$array['channel']['item'][$i]['link']."'>+info</a>"; 
            sendMessage($chatId,$titulos,TRUE);   
        };
    
};

function nacional($chatId){
    $context= stream_context_create(array('http'=> array('header'=>'Accept:application/xml')));
    $url='https://www.europapress.es/rss/rss.aspx?ch=00066';
    $xmlstring= file_get_contents($url, false, $context);
    $xml =simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
    $json= json_encode($xml);
    $array= json_decode($json , TRUE);
    
    for($i=0; $i<=9; $i++ ){
        $titulos=$array['channel']['item'][$i]['title']."<a href='".$array['channel']['item'][$i]['link']."'>+info</a>"; 
        sendMessage($chatId,$titulos,false);
    };   
}
function internacional($chatId){
    $context= stream_context_create(array('http'=> array('header'=>'Accept:application/xml')));
    $url='https://www.europapress.es/rss/rss.aspx?ch=00069';
    $xmlstring= file_get_contents($url, false, $context);
    $xml =simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
    $json= json_encode($xml);
    $array= json_decode($json , TRUE);
    
    for($i=0; $i<=9; $i++ ){
        $titulos=$array['channel']['item'][$i]['title']."<a href='".$array['channel']['item'][$i]['link']."'>+info</a>"; 
        sendMessage($chatId,$titulos,false);
    };   
}
function economia($chatId){
    $context= stream_context_create(array('http'=> array('header'=>'Accept:application/xml')));
    $url='https://www.europapress.es/rss/rss.aspx?ch=00136';
    $xmlstring= file_get_contents($url, false, $context);
    $xml =simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
    $json= json_encode($xml);
    $array= json_decode($json , TRUE);
    
    for($i=0; $i<=9; $i++ ){
        $titulos=$array['channel']['item'][$i]['title']."<a href='".$array['channel']['item'][$i]['link']."'>+info</a>"; 
        sendMessage($chatId,$titulos,false);
    };   
}
function deportes($chatId){
    $context= stream_context_create(array('http'=> array('header'=>'Accept:application/xml')));
    $url='https://www.europapress.es/rss/rss.aspx?ch=00067';
    $xmlstring= file_get_contents($url, false, $context);
    $xml =simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
    $json= json_encode($xml);
    $array= json_decode($json , TRUE);
    
    for($i=0; $i<=9; $i++ ){
        $titulos=$array['channel']['item'][$i]['title']."<a href='".$array['channel']['item'][$i]['link']."'>+info</a>"; 
        sendMessage($chatId,$titulos,false);
    };   
}

?>