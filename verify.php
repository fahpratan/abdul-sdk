<?php
$access_token = 'IgKvG3EcE/ZE/7Cx/6Ib+D+PWeRpitdlmRNo7BwnIkqTIKpsxu0jJsECp+6SZuvdavhrJwyRY/GJbQYuJScE3LsfWpufj0Xvgp1NpRj2T6GsRNNvqD/nZe+r2u+BBfr6FHvZj9fk7tSpvXBUuNJICwdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;