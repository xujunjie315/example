<?php
namespace app\index\controller;

use Hprose\Completer;
use Hprose\Future;
use \Hprose\Http\Client;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Response\QrCodeResponse;

class HproseClient
{
    public function index(){

        // Create a basic QR code
        $qrCode = new QrCode('Life is too short to be generating QR codes');
        $qrCode->setSize(200);

        // Set advanced options
        $qrCode->setWriterByName('png');
        $qrCode->setMargin(10);
        $qrCode->setEncoding('UTF-8');
        $qrCode->setErrorCorrectionLevel(new ErrorCorrectionLevel(ErrorCorrectionLevel::HIGH));
        $qrCode->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0]);
        $qrCode->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255, 'a' => 0]);
        // $qrCode->setLabel('Scan the code', 16, __DIR__.'/../assets/fonts/noto_sans.otf', LabelAlignment::CENTER);
        // $qrCode->setLogoPath(__DIR__.'/../assets/images/symfony.png');
        $qrCode->setLogoSize(150, 200);
        $qrCode->setRoundBlockSize(true);
        $qrCode->setValidateResult(false);
        $qrCode->setWriterOptions(['exclude_xml_declaration' => true]);

        // Directly output the QR code

        // header('Content-Type: '.$qrCode->getContentType());
        // echo $qrCode->writeString();die;

        // Save it to a file
        // $qrCode->writeFile(APP_PATH . 'qrcode.png');die;

        // Create a response object
        return $response = new QrCodeResponse($qrCode);
    }
    public function hello()
    {
        $client = new \Hprose\Http\Client('http://localhost:81/index.php/index/Index/serverStart', false);
        $result = $client->hello('xujunjie');
        print_r($result);die;
    }
    public function test()
    {
        $client = new \Hprose\Socket\Client('tcp://127.0.0.1:1314', false);
        $result = $client->hello();
        echo $result;die;
    }
    //异步
    public function test1()
    {
        $client = new Client('http://localhost:81/index.php/index/Index/serverStart', true);
        $client->mySum(1, 1000000)->then(function($result){
                var_dump($result);
            });
        // $va = $client->mySum(1, 1000000);
        // $promise = Future\value($va);
        // $promise->then(function($value) {
        //     var_dump($value);
        // });
        echo 'xujunjie';
    }
    public function test2(){
        Future\co(function() {
            $test = new Client("http://localhost:81/index.php/index/Index/serverStart", true);
            var_dump((yield $test->hello("hprose")));
            $a = $test->mySum(1, 100);
            $b = $test->mySum(1, 1000);
            var_dump((yield $test->sum($a, $b)));
            var_dump((yield $test->hello("world")));
        });
    }
}




  

