<?php
require __DIR__ . '/vendor/autoload.php';

use Cloud\Client\Api\PackagesApi;
use Cloud\Client\Api\RecognizeApi;
use Cloud\Client\Model\AudioFileDto;
use Cloud\Client\Model\RecognitionRequestDto;
use Cloud\Client\Model\StartSessionRequest;
use Swagger\Client\Api\SessionApi;

//$sessionApi = new SessionApi();
//$credentials = array("username"=>"bulakhov@gmail.com", "password"=>"f8f585a2N$", "domain_id"=>"2945");
//$startRequest = new StartSessionRequest($credentials);
//$sessionId = $sessionApi -> startSession($startRequest) -> getSessionId();
$sessionId = "5795d00b-2d90-4379-91f0-4640ddc2195e";
$packageApi = new PackagesApi();
$packages = $packageApi -> getAvailablePackages($sessionId);
$loadPackageStatus = $packageApi -> load($sessionId, "FarField") -> getStatus();
$recognitionApi = new RecognizeApi();
$handle = fopen("/home/fivern/PhpstormProjects/testspeek/asr/2.wav", "rb");
$contents = fread($handle, filesize("/home/fivern/PhpstormProjects/testspeek/asr/2.wav"));
fclose($handle);
$encoded_sound = base64_encode($contents);
$audioFile = new AudioFileDto(array("data"=>$encoded_sound, "mime"=>"audio/basic"));
$recognitionRequest = new RecognitionRequestDto(array("audio"=>$audioFile, "package_id" => 'FarField'));
$recognitionResult = $recognitionApi -> recognize($sessionId, $recognitionRequest);
echo $recognitionResult;
?>