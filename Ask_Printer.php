<?php
                     if(strtoupper($userMessage) == "PRINTER"){
                        // ????? action 4 ???? 4 ??????
                        $actionBuilder = array(
                            new MessageTemplateActionBuilder(
                                'UTL1',// ?????????????????
                                'PRINTER1' // ?????????????????????????? ??????????????
                            ),
                            new MessageTemplateActionBuilder(
                                'UTL2',// ?????????????????
                                'PRINTER2' // ?????????????????????????? ??????????????
                            ),
                            new MessageTemplateActionBuilder(
                                'UTL3',// ?????????????????
                                'PRINTER3' // ?????????????????????????? ??????????????
                            ),
    
                        );
                        $imageUrl = 'https://thetomatos.com/wp-content/uploads/2016/02/printer-clipart-5.png';
                        $replyData = new TemplateMessageBuilder('Button Template',
                            new ButtonTemplateBuilder(
                                    'IP Printer UTL', // ??????????????
                                    'Please select UTL', // ???????????????
                                    $imageUrl, // ????? url ??????
                                    $actionBuilder  // ????? action object
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
?>