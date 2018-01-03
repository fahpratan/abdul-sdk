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
        switch ($typeMessage){
            case 'text':
                $userMessage = strtoupper($userMessage); // แปลงเป็นตัวเล็ก สำหรับทดสอบ
                switch ($userMessage) {
                   case "PRINTER1":
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
                        break;
                 case "PRINTER2":
                        $picFullSize2_1 = 'https://raw.githubusercontent.com/fahpratan/abdul-sdk/master/ip-printer-utl2-1.JPG';
                        $picThumbnail2_1 = 'https://raw.githubusercontent.com/fahpratan/abdul-sdk/master/ip-printer-utl2-1.JPG/240';
                        $replyData = new ImageMessageBuilder($picFullSize2_1,$picThumbnail2_1);
                        break;
                   case "PRINTER3":
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
                        break;
                    case "V":
                        $picThumbnail = 'https://www.mywebsite.com/imgsrc/photos/f/sampleimage/240';
                        $videoUrl = "https://www.ninenik.com/line/simplevideo.mp4";             
                        $replyData = new VideoMessageBuilder($videoUrl,$picThumbnail);
                        break;
                    case "A":
                        $audioUrl = "https://www.ninenik.com/line/S_6988827932080.wav";
                        $replyData = new AudioMessageBuilder($audioUrl,20000);
                        break;
                    case "LOCATION1":
                        $placeName = "Utac Thai Limited1";
                        $placeAddress = "สุขุมวิท, 237 ซอย สุขุมวิท 105 Khwaeng Bang Na, Khet Bang Na, Krung Thep Maha Nakhon 10260";
                        $latitude = 13.661728;
                        $longitude = 100.608836;
                        $replyData = new LocationMessageBuilder($placeName, $placeAddress, $latitude ,$longitude);              
                        break;
                    case "LOCATION2":
                        $placeName = "Utac Thai Limited2";
                        $placeAddress = "บริษัท ยูแทคไทย จำกัด (สาขา 2) Tambon Bang Samak, Amphoe Bang Pakong, Chang Wat Chachoengsao 24180";
                        $latitude = 13.661728;
                        $longitude = 100.608836;
                        $replyData = new LocationMessageBuilder($placeName, $placeAddress, $latitude ,$longitude);              
                        break;
                   case "LOCATION3":
                        $placeName = "Utac Thai Limited3";
                        $placeAddress = "Bang Samak, Bang Pakong District, Chachoengsao 24180";
                        $latitude = 13.581658;
                        $longitude = 100.930541;
                        $replyData = new LocationMessageBuilder($placeName, $placeAddress, $latitude ,$longitude);              
                        break;
                    case "S":
                        $stickerID = 22;
                        $packageID = 2;
                        $replyData = new StickerMessageBuilder($packageID,$stickerID);
                        break;      
                    case "IM":
                        $imageMapUrl = 'https://www.mywebsite.com/imgsrc/photos/w/sampleimagemap';
                        $replyData = new ImagemapMessageBuilder(
                            $imageMapUrl,
                            'This is Title',
                            new BaseSizeBuilder(699,1040),
                            array(
                                new ImagemapMessageActionBuilder(
                                    'test image map',
                                    new AreaBuilder(0,0,520,699)
                                    ),
                                new ImagemapUriActionBuilder(
                                    'http://www.ninenik.com',
                                    new AreaBuilder(520,0,520,699)
                                    )
                            )); 
                        break;          
                    case "TM":
                        $replyData = new TemplateMessageBuilder('Confirm Template',
                            new ConfirmTemplateBuilder(
                                    'Confirm template builder',
                                    array(
                                        new MessageTemplateActionBuilder(
                                            'Yes',
                                            'Text Yes'
                                        ),
                                        new MessageTemplateActionBuilder(
                                            'No',
                                            'Text NO'
                                        )
                                    )
                            )
                        );
                        break;          
                    case "MAP":
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
                        break; 
                   case "TEL":
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
                        break; 
                    case "SERVER STATUS":
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
                        break; 
                    case "PRINTER":
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
                        break;  
                    case "T_F":
                        $replyData = new TemplateMessageBuilder('Confirm Template',
                            new ConfirmTemplateBuilder(
                                    'Confirm template builder', // ข้อความแนะนหรือบอกวิธีการ หรือคำอธิบาย
                                    array(
                                        new MessageTemplateActionBuilder(
                                            'Yes', // ข้อความสำหรับปุ่มแรก
                                            'YES'  // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                                        ),
                                        new MessageTemplateActionBuilder(
                                            'No', // ข้อความสำหรับปุ่มแรก
                                            'NO' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                                        )
                                    )
                            )
                        );
                        break;      
                    case "HELP":
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
                        break;           
                       case "T_IC":
                        $replyData = new TemplateMessageBuilder('Image Carousel',
                            new ImageCarouselTemplateBuilder(
                                array(
                                    new ImageCarouselColumnTemplateBuilder(
                                        'https://www.mywebsite.com/imgsrc/photos/f/sampleimage/700',
                                        new UriTemplateActionBuilder(
                                            'Uri Template', // ข้อความแสดงในปุ่ม
                                            'https://www.ninenik.com'
                                        )
                                    ),
                                    new ImageCarouselColumnTemplateBuilder(
                                        'https://www.mywebsite.com/imgsrc/photos/f/sampleimage/700',
                                        new UriTemplateActionBuilder(
                                            'Uri Template', // ข้อความแสดงในปุ่ม
                                            'https://www.ninenik.com'
                                        )
                                    )                                       
                                )
                            )
                        );
                        break;                                                                                                                                                                                                                      
                    default:
                        $textReplyMessage = " Service ไม่เข้าใจคำสั่งของคุณ";
                        $replyData = new TextMessageBuilder($textReplyMessage);         
                        break;                                      
                }
                break;
            default:
                $textReplyMessage = json_encode($events);
                $replyData = new TextMessageBuilder($textReplyMessage);         
                break;  
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
