<?php
// กรณีต้องการตรวจสอบการแจ้ง error ให้เปิด 3 บรรทัดล่างนี้ให้ทำงาน กรณีไม่ ให้ comment ปิดไป
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 
// include composer autoload
require_once 'vendor/autoload.php';
 
// การตั้งเกี่ยวกับ bot
require_once 'bot_settings.php';
 
// กรณีมีการเชื่อมต่อกับฐานข้อมูล
//require_once("dbconnect.php");
 
///////////// ส่วนของการเรียกใช้งาน class ผ่าน namespace
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
//use LINE\LINEBot\Event;
//use LINE\LINEBot\Event\BaseEvent;
//use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\MessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use LINE\LINEBot\MessageBuilder\LocationMessageBuilder;
use LINE\LINEBot\MessageBuilder\AudioMessageBuilder;
use LINE\LINEBot\MessageBuilder\VideoMessageBuilder;
use LINE\LINEBot\ImagemapActionBuilder;
use LINE\LINEBot\ImagemapActionBuilder\AreaBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder ;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder;
use LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder;
use LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\DatetimePickerTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselColumnTemplateBuilder;
 
 
$httpClient = new CurlHTTPClient(LINE_MESSAGE_ACCESS_TOKEN);
$bot = new LINEBot($httpClient, array('channelSecret' => LINE_MESSAGE_CHANNEL_SECRET));
 
// คำสั่งรอรับการส่งค่ามาของ LINE Messaging API
$content = file_get_contents('php://input');
// แปลงข้อความรูปแบบ JSON  ให้อยู่ในโครงสร้างตัวแปร array
$events = json_decode($content, true);
//DATA tell
$obj1 = array();
$Name_tel = fopen('Tel.csv', 'r');
while( ($objA = fgetcsv($Name_tel)) !== false) {
        $obj1[] = $objA;
      }
if(!is_null($events)){
    // ถ้ามีค่า สร้างตัวแปรเก็บ replyToken ไว้ใช้งาน
    $replyToken = $events['events'][0]['replyToken'];
    $userID = $events['events'][0]['source']['userId'];
    $sourceType = $events['events'][0]['source']['type'];        
    $is_postback = NULL;
    $is_message = NULL;
    if(isset($events['events'][0]) && array_key_exists('message',$events['events'][0])){
        $is_message = true;
        $typeMessage = $events['events'][0]['message']['type'];
        $userMessage = $events['events'][0]['message']['text'];     
        $idMessage = $events['events'][0]['message']['id'];             
    }
    if(isset($events['events'][0]) && array_key_exists('postback',$events['events'][0])){
        $is_postback = true;
        $dataPostback = NULL;
        parse_str($events['events'][0]['postback']['data'],$dataPostback);;
        $paramPostback = NULL;
        if(array_key_exists('params',$events['events'][0]['postback'])){
            if(array_key_exists('date',$events['events'][0]['postback']['params'])){
                $paramPostback = $events['events'][0]['postback']['params']['date'];
            }
            if(array_key_exists('time',$events['events'][0]['postback']['params'])){
                $paramPostback = $events['events'][0]['postback']['params']['time'];
            }
            if(array_key_exists('datetime',$events['events'][0]['postback']['params'])){
                $paramPostback = $events['events'][0]['postback']['params']['datetime'];
            }                       
        }
    }   
    if(!is_null($is_postback)){
        $textReplyMessage = "ข้อความจาก Postback Event Data = ";
        if(is_array($dataPostback)){
            $textReplyMessage.= json_encode($dataPostback);
        }
        if(!is_null($paramPostback)){
            $textReplyMessage.= " \r\nParams = ".$paramPostback;
        }
        $replyData = new TextMessageBuilder($textReplyMessage);     
    }
    if(!is_null($is_message)){
        if($typeMessage ='text'){
//////////////////////////////////////////////////////////////////////////////////////////
               $check = 0;
                  for ($i=1;$i<52;$i++){
                  if((strtoupper($userMessage) == $obj1[$i][1])||($userMessage) == $obj1[$i][3]||($userMessage) == $obj1[$i][0]){
                    $textReplyMessage = "E/N:".$obj1[$i][0]." "."NAME:".$obj1[$i][1]." ".$obj1[$i][2]." "."Nickname:".$obj1[$i][3]." "."ExtNo:".$obj1[$i][4];
                    $replyData = new TextMessageBuilder($textReplyMessage);
                    $check =1;
                    }
                    if ($check==1){break;}
                    }
                  if ($check==0){
                    $textReplyMessage = " Service ไม่เข้าใจคำสั่งของคุณ";
                    $replyData = new TextMessageBuilder($textReplyMessage);    
                    } 
                  if(strtoupper($userMessage) == "PRINTER"){
                        // กำหนด action 4 ปุ่ม 4 ประเภท
                        $actionBuilder = array(
                            new MessageTemplateActionBuilder(
                                'UTL1',// ข้อความแสดงในปุ่ม
                                'PRINTER1' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                            ),
                            new MessageTemplateActionBuilder(
                                'UTL2',// ข้อความแสดงในปุ่ม
                                'PRINTER2' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                            ),
                            new MessageTemplateActionBuilder(
                                'UTL3',// ข้อความแสดงในปุ่ม
                                'PRINTER3' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                            ),
    
                        );
                        $imageUrl = 'https://thetomatos.com/wp-content/uploads/2016/02/printer-clipart-5.png';
                        $replyData = new TemplateMessageBuilder('Button Template',
                            new ButtonTemplateBuilder(
                                    'IP Printer UTL', // กำหนดหัวเรื่อง
                                    'Please select UTL', // กำหนดรายละเอียด
                                    $imageUrl, // กำหนด url รุปภาพ
                                    $actionBuilder  // กำหนด action object
                            )
                        );              
                   $check =1; 
                  }
                  if(strtoupper($userMessage) == "PRINTER1") {
                        $picFullSize1 = 'https://raw.githubusercontent.com/fahpratan/abdul-sdk/master/ip-printer-utl1.JPG';
                        $picThumbnail1 = 'https://raw.githubusercontent.com/fahpratan/abdul-sdk/master/ip-printer-utl1.JPG/240';
                        $replyData1 = new ImageMessageBuilder($picFullSize1,$picThumbnail1);
                        $picFullSize2 = 'https://raw.githubusercontent.com/fahpratan/abdul-sdk/master/ip-printer-utl1-2.JPG';
                        $picThumbnail2 = 'https://raw.githubusercontent.com/fahpratan/abdul-sdk/master/ip-printer-utl1-2.JPG/240';
                        $replyData2 = new ImageMessageBuilder($picFullSize2,$picThumbnail2);
                        $picFullSize3 = 'https://raw.githubusercontent.com/fahpratan/abdul-sdk/master/ip-printer-utl1-3.JPG';
                        $picThumbnail3 = 'https://raw.githubusercontent.com/fahpratan/abdul-sdk/master/ip-printer-utl1-3.JPG/240';
                        $replyData3 = new ImageMessageBuilder($picFullSize3,$picThumbnail3);
                       
                        $multiMessage1 = new MultiMessageBuilder;
                        $multiMessage1->add($replyData1);
                        $multiMessage1->add($replyData2);
                        $multiMessage1->add($replyData3);
                        $replyData = $multiMessage1;  
                        $check =1
                        }    
////////////////////////////////////////////////////////////////////////////////                 
        }
    }
}
$response = $bot->replyMessage($replyToken,$replyData);
if ($response->isSucceeded()) {
    echo 'Succeeded!';
    return;
}
 
// Failed
echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
?>
