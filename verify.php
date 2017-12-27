<?php
$access_token = 'S8TzqHkbXbka8fuEOcKWikC0QAIq8PrEuScRVHFTwaf/zZ/N/snNi+uUc2m7d4ygavhrJwyRY/GJbQYuJScE3LsfWpufj0Xvgp1NpRj2T6EMhcgAouT/OP9fCksN+alaqF1k+AcwhLNGsnOxyDumNAdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;
