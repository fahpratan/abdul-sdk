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
use LINE\LINEBot\Event;
use LINE\LINEBot\Event\BaseEvent;
use LINE\LINEBot\Event\MessageEvent;
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
//DATA TELL UTL
$obj2 = array();
$Name_tel_UTL_1 = fopen('filesort.csv', 'r');
while( ($objB = fgetcsv($Name_tel_UTL_1)) !== false) {
        $obj2[] = $objB;
      }
/////////////////////
$obj3 = array();
$Name_tel_UTL_3 = fopen('off.csv', 'r');
while( ($objz = fgetcsv($Name_tel_UTL_3)) !== false) {
        $obj3[] = $objz;
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
///////////////////////////////////////ASK TEL UTL////////////////////
        $Name_tel_UTL = fopen('filesort.csv', 'r');
    	while (($objArr = fgetcsv($Name_tel_UTL)) !== FALSE) {
	    if(strtoupper($userMessage)==$objArr[2]){
			 $textReplyMessage = "E/N:".$objArr[1]." "."NAME:".$objArr[2]." ".$objArr[3]." "."GROUP:".$objArr[4]." "."DEPT:".$objArr[5]." "."SUP:".$objArr[6]." "."TEL:".$objArr[7]." "."TYPE:".$objArr[8];
             $replyData = new TextMessageBuilder($textReplyMessage);
	     $check =1;
			}
              if ($check==1){break;}                
              }
////////////////////////////////////ASK IP//////////////////////////////
		$Name_tel_UTL3 = fopen('off.csv', 'r');
    	while (($objArr = fgetcsv($Name_tel_UTL)) !== FALSE) {
	    if(strtoupper($userMessage)=="Offline"){
			 $textReplyMessage = "IP:".$objArr[0];
             $replyData = new TextMessageBuilder($textReplyMessage);
	     $check =1;
			}
              if ($check==1){break;}                
              }
         /////////////////////////////////
         for ($i=1;$i<5967;$i++){
                  if($userMessage == $obj2[$i][1]){
                    $textReplyMessage = "E/N:".$obj2[$i][1]." "."NAME:".$obj2[$i][2]." ".$obj2[$i][3]." "."GROUP:".$obj2[$i][4]." "."DEPT:".$obj2[$i][5]." "."SUP:".$obj2[$i][6]." "."TEL:".$obj2[$i][7]." "."TYPE:".$obj2[$i][8];
                    $replyData = new TextMessageBuilder($textReplyMessage);
                    $check =1;
                    }
                    if ($check==1){break;}
                    }        
///////////////////////////////////////////TEST SEND FILE/////////////////////////////////////////////////    
                  if(strtoupper($userMessage) == "FILE"){
                        $fileName = 'file.txt';
                        $fileSize = 4;
                        $replyData = new FileMessage($fileName, $fileSize); 
                        $check =1;
                        //$packageId = $eventObj->getFileName();
                        //$stickerId = $eventObj->getFileSize();
                        } 
////////////////////////////////////////VIDEO/////////////////////////////////////
                  if(strtoupper($userMessage) == "V"){
                        $textReplyMessage = "Bot ตอบกลับคุณเป็นข้อความ";
                    	$replyData = new TextMessageBuilder($textReplyMessage);
                        $check =1; 
                       }
//////////////////////////////////////////////////////////////////////////////////////////////////////
		   if(strtoupper($userMessage) == "F"){
                        $textReplyMessage = "https://raw.githubusercontent.com/fahpratan/abdul-sdk/master/filesort.csv";
                    	$replyData = new TextMessageBuilder($textReplyMessage);
                        $check =1; 
                       }
//////////////////////////////////////////ASK TELL ALL////////////////////////////////////////////////                    
                    if(strtoupper($userMessage) == "TEL"){
                        // กำหนด action 4 ปุ่ม 4 ประเภท
                        $actionBuilder = array(
                            new MessageTemplateActionBuilder(
                                'UTL1',// ข้อความแสดงในปุ่ม
                                'TEL1' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                            ),
                            new MessageTemplateActionBuilder(
                                'UTL2',// ข้อความแสดงในปุ่ม
                                'TEL2' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                            ),
                            new MessageTemplateActionBuilder(
                                'UTL3',// ข้อความแสดงในปุ่ม
                                'TEL3' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                            ),
    
                        );
                        $imageUrl = 'https://cdn3.iconfinder.com/data/icons/communication-1/100/old_phone-512.png';
                        $replyData = new TemplateMessageBuilder('Button Template',
                            new ButtonTemplateBuilder(
                                    'Telephone Dept', // กำหนดหัวเรื่อง
                                    'Please select UTL', // กำหนดรายละเอียด
                                    $imageUrl, // กำหนด url รุปภาพ
                                    $actionBuilder  // กำหนด action object
                            )
                        );              
                       $check =1; 
                       }
///////////////////////////////////////////ASK PRINTER///////////////////////////////////////////////                    
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
                        $check =1;
                        }
                  if(strtoupper($userMessage) == "PRINTER2") {
                        $picFullSize2_1 = 'https://raw.githubusercontent.com/fahpratan/abdul-sdk/master/ip-printer-utl2-1.JPG';
                        $picThumbnail2_1 = 'https://raw.githubusercontent.com/fahpratan/abdul-sdk/master/ip-printer-utl2-1.JPG/240';
                        $replyData = new ImageMessageBuilder($picFullSize2_1,$picThumbnail2_1);
                        $check =1;
                        }
                 if(strtoupper($userMessage) == "PRINTER3") {
                        $picFullSize3_1 = 'https://raw.githubusercontent.com/fahpratan/abdul-sdk/master/ip-printer-utl3-1.JPG';
                        $picThumbnail3_1 = 'https://raw.githubusercontent.com/fahpratan/abdul-sdk/master/ip-printer-utl3-1.JPG/240';
                        $replyData3_1 = new ImageMessageBuilder($picFullSize3_1,$picThumbnail3_1);
                        $picFullSize3_2 = 'https://raw.githubusercontent.com/fahpratan/abdul-sdk/master/ip-printer-utl3-2.JPG';
                        $picThumbnail3_2 = 'https://raw.githubusercontent.com/fahpratan/abdul-sdk/master/ip-printer-utl3-2.JPG/240';
                        $replyData3_2 = new ImageMessageBuilder($picFullSize3_2,$picThumbnail3_2);
                        $multiMessage3 = new MultiMessageBuilder;
                        $multiMessage3->add($replyData3_1);
                        $multiMessage3->add($replyData3_2);
                        $replyData = $multiMessage3;
                        $check =1;
                        }                   
///////////////////////////////////////////////////////////////////MAP//////////////////////////////////////////////// 
                 if(strtoupper($userMessage) == "MAP") {
                        // กำหนด action 4 ปุ่ม 4 ประเภท
                        $actionBuilder = array(
                            new MessageTemplateActionBuilder(
                                'UTL1',// ข้อความแสดงในปุ่ม
                                'LOCATION1' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                            ),
                            new MessageTemplateActionBuilder(
                                'UTL2',// ข้อความแสดงในปุ่ม
                                'LOCATION2' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                            ),
                            new MessageTemplateActionBuilder(
                                'UTL3',// ข้อความแสดงในปุ่ม
                                'LOCATION3' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                            ),
    
                        );
                        $imageUrl = 'https://eteknix-eteknixltd.netdna-ssl.com/wp-content/uploads/2016/06/gps-location.png';
                        $replyData = new TemplateMessageBuilder('Button Template',
                            new ButtonTemplateBuilder(
                                    'Location Utac Thai Limited', // กำหนดหัวเรื่อง
                                    'Please select UTL', // กำหนดรายละเอียด
                                    $imageUrl, // กำหนด url รุปภาพ
                                    $actionBuilder  // กำหนด action object
                            )
                        );              
                        $check =1;
                        } 
                  if(strtoupper($userMessage) == "LOCATION1") {
                        $placeName = "Utac Thai Limited1";
                        $placeAddress = "สุขุมวิท, 237 ซอย สุขุมวิท 105 Khwaeng Bang Na, Khet Bang Na, Krung Thep Maha Nakhon 10260";
                        $latitude = 13.661728;
                        $longitude = 100.608836;
                        $locationMessage = new LocationMessageBuilder($placeName, $placeAddress, $latitude ,$longitude);              
 
                        $picFullSizeMAP1 = 'https://raw.githubusercontent.com/fahpratan/abdul-sdk/master/UTL1-MAP.jpg';
                        $picThumbnailMAP1 = 'https://raw.githubusercontent.com/fahpratan/abdul-sdk/master/UTL1-MAP.jpg/240';
                        $imageMessage = new ImageMessageBuilder($picFullSizeMAP1,$picThumbnailMAP1);
                        $multiMessage = new MultiMessageBuilder;                        
                        $multiMessage->add($locationMessage);
                        $multiMessage->add($imageMessage);
                        $replyData = $multiMessage;      
                        $check =1;
                        } 
                  if(strtoupper($userMessage) == "LOCATION2") {
                        $placeName = "Utac Thai Limited2";
                        $placeAddress = "บริษัท ยูแทคไทย จำกัด (สาขา 2) Tambon Bang Samak, Amphoe Bang Pakong, Chang Wat Chachoengsao 24180";
                        $latitude = 13.661728;
                        $longitude = 100.608836;
                        $locationMessage = new LocationMessageBuilder($placeName, $placeAddress, $latitude ,$longitude);  
                   
                        $picFullSizeMAP2 = 'https://raw.githubusercontent.com/fahpratan/abdul-sdk/master/UTL2-MAP.jpg';
                        $picThumbnailMAP2 = 'https://raw.githubusercontent.com/fahpratan/abdul-sdk/master/UTL2-MAP.jpg/240';
                        $imageMessage = new ImageMessageBuilder($picFullSizeMAP2,$picThumbnailMAP2);
                        $multiMessage = new MultiMessageBuilder;                        
                        $multiMessage->add($locationMessage);
                        $multiMessage->add($imageMessage);
                        $replyData = $multiMessage;      
                        $check =1;
                        } 
                  if(strtoupper($userMessage) == "LOCATION3") {
                        $placeName = "Utac Thai Limited3";
                        $placeAddress = "Bang Samak, Bang Pakong District, Chachoengsao 24180";
                        $latitude = 13.581658;
                        $longitude = 100.930541;
                        $locationMessage = new LocationMessageBuilder($placeName, $placeAddress, $latitude ,$longitude);              
                       
                        $picFullSizeMAP3 = 'https://raw.githubusercontent.com/fahpratan/abdul-sdk/master/UTL3-MAP.jpg';
                        $picThumbnailMAP3 = 'https://raw.githubusercontent.com/fahpratan/abdul-sdk/master/UTL3-MAP.jpg/240';
                        $imageMessage = new ImageMessageBuilder($picFullSizeMAP3,$picThumbnailMAP3);
                        $multiMessage = new MultiMessageBuilder;                        
                        $multiMessage->add($locationMessage);
                        $multiMessage->add($imageMessage);
                        $replyData = $multiMessage;      
                        $check =1;
                        } 
///////////////////////////////////////////////////////////////////SERVER STATUS////////////////////////////////////////////////        
                  if(strtoupper($userMessage) == "SERVER STATUS") {  
                        // กำหนด action 4 ปุ่ม 4 ประเภท
                        $actionBuilder = array(
                            new MessageTemplateActionBuilder(
                                'ACCESS POINT',// ข้อความแสดงในปุ่ม
                                'ACCESS POINT' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                            ),
                            new MessageTemplateActionBuilder(
                                'SWITCH',// ข้อความแสดงในปุ่ม
                                'SWITCH' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                            ),
                            new MessageTemplateActionBuilder(
                                'PRINTER',// ข้อความแสดงในปุ่ม
                                'PRINTER' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                            ),
                        );
                        $imageUrl = 'https://cdn.iconscout.com/public/images/icon/premium/png-512/check-server-status-checklist-3ddf4743e512df9c-512x512.png';
                        $replyData = new TemplateMessageBuilder('Button Template',
                            new ButtonTemplateBuilder(
                                    'Asset Status', // กำหนดหัวเรื่อง
                                    'Please select Asset', // กำหนดรายละเอียด
                                    $imageUrl, // กำหนด url รุปภาพ
                                    $actionBuilder  // กำหนด action object
                            )
                        );              
                        $check =1;
                        }
                    if(strtoupper($userMessage) == "ACCESS POINT") {    
                        // กำหนด action 4 ปุ่ม 4 ประเภท
                        $actionBuilder = array(
                            new MessageTemplateActionBuilder(
                                'UTL1',// ข้อความแสดงในปุ่ม
                                'ACCESS_P1' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                            ),
                            new MessageTemplateActionBuilder(
                                'UTL2',// ข้อความแสดงในปุ่ม
                                'ACCESS_P2' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                            ),
                            new MessageTemplateActionBuilder(
                                'UTL3',// ข้อความแสดงในปุ่ม
                                'ACCESS_P3' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                            ),
    
                        );
                        $imageUrl = 'https://www.osisoft.com/uploadedImages/Micro_Sites/IIoT/Overview/Benefits-icon-170x170.png';
                        $replyData = new TemplateMessageBuilder('Button Template',
                            new ButtonTemplateBuilder(
                                    'Access Point', // กำหนดหัวเรื่อง
                                    'Please select UTL', // กำหนดรายละเอียด
                                    $imageUrl, // กำหนด url รุปภาพ
                                    $actionBuilder  // กำหนด action object
                            )
                        );              
                        $check =1;
                        } 
                    if(strtoupper($userMessage) == "SWITCH") {
                        // กำหนด action 4 ปุ่ม 4 ประเภท
                        $actionBuilder = array(
                            new MessageTemplateActionBuilder(
                                'UTL1',// ข้อความแสดงในปุ่ม
                                'SWITCH1' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                            ),
                            new MessageTemplateActionBuilder(
                                'UTL2',// ข้อความแสดงในปุ่ม
                                'SWITCH2' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                            ),
                            new MessageTemplateActionBuilder(
                                'UTL3',// ข้อความแสดงในปุ่ม
                                'SWITCH3' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                            ),
    
                        );
                        $imageUrl = 'https://www.iconshock.com/v2/image/Stroke/Computer_gadgets/switch';
                        $replyData = new TemplateMessageBuilder('Button Template',
                            new ButtonTemplateBuilder(
                                    'Switch', // กำหนดหัวเรื่อง
                                    'Please select UTL', // กำหนดรายละเอียด
                                    $imageUrl, // กำหนด url รุปภาพ
                                    $actionBuilder  // กำหนด action object
                            )
                        );              
                        $check =1;
                        } 
                   if(strtoupper($userMessage) == "PRINTER") {    
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
                            new MessageTemplateActionBuilder(
                                'MODEL',// ข้อความแสดงในปุ่ม
                                'PRINTER4' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
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
///////////////////////////////////////////////////////////////////HELP////////////////////////////////////////////////
                     if(strtoupper($userMessage) == "HELP") { 
                        // กำหนด action 4 ปุ่ม 4 ประเภท
                     $actionBuilder = array(
                            new MessageTemplateActionBuilder(
                                'UTL1',// ข้อความแสดงในปุ่ม
                                'LOCATION1' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                            ),
                           new MessageTemplateActionBuilder(
                                'UTL2',// ข้อความแสดงในปุ่ม
                                'LOCATION2' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                            ),
                            new MessageTemplateActionBuilder(
                                'UTL3',// ข้อความแสดงในปุ่ม
                                'LOCATION3' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                            ),
                        );
                   $actionBuilder2 = array(
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
                   $actionBuilder3 = array(
                            new MessageTemplateActionBuilder(
                                'UTL1',// ข้อความแสดงในปุ่ม
                                'TEL1' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                            ),
                           new MessageTemplateActionBuilder(
                                'UTL2',// ข้อความแสดงในปุ่ม
                                'TEL2' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                            ),
                            new MessageTemplateActionBuilder(
                                'UTL3',// ข้อความแสดงในปุ่ม
                                'TEL3' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                            ),
                        );
                        $replyData = new TemplateMessageBuilder('Carousel',
                            new CarouselTemplateBuilder(
                                array(
                                    new CarouselColumnTemplateBuilder(
                                        'Location Utac Thai Limited',
                                        'Please select UTL',
                                        'https://articles-images.sftcdn.net/wp-content/uploads/sites/3/2016/03/1424198413_079371_1424198643_noticia_normal.jpg',
                                        $actionBuilder
                                    ),
                                    new CarouselColumnTemplateBuilder(
                                        'IP Printer UTL',
                                        'Please select UTL',
                                        'https://thetomatos.com/wp-content/uploads/2016/02/printer-clipart-5.png',
                                        $actionBuilder2
                                    ),
                                    new CarouselColumnTemplateBuilder(
                                        'Telephone Dept',
                                        'Please select UTL',
                                        'https://cdn3.iconfinder.com/data/icons/communication-1/100/old_phone-512.png',
                                        $actionBuilder3
                                    ),                                 
                                )
                            )
                        );
                        $check =1; 
                        }                                                      
//////////////////////////////////////////////////////////////////////////////////////       
                 if ($check==0){
                    $textReplyMessage = " Service ไม่เข้าใจคำสั่งของคุณ";
                    $replyData = new TextMessageBuilder($textReplyMessage);    
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
