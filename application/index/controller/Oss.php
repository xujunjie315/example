<?php
namespace app\index\controller;
use OSS\OssClient;
use OSS\Core\OssException;

class Oss
{
    private $ossClient;
    public function __construct(){
        $accessKeyId = "LTAI4FpiN3GMzvarB8iegTy9";
        $accessKeySecret = "Kn20QsrvQs2RNxqjFtk9mgqThPPzeV";
        $endpoint = "http://oss-cn-beijing.aliyuncs.com";
        try {
            $this->ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
        } catch (OssException $e) {
            print $e->getMessage();
        }
    }
    public function createBucket(){
        $bucket = "xujunjie-test";
        if(!$this->ossClient->doesBucketExist($bucket)){
            $this->ossClient->createBucket($this->bucket);
            $acl = OssClient::OSS_ACL_TYPE_PRIVATE;
            $this->ossClient->putBucketAcl($bucket, $acl);
        }
    }
    public function getBucketInfo(){
        $bucket = "xujunjie-test";
        //获取存储空间的访问权限
        $res = $this->ossClient->getBucketAcl($bucket);
        print('acl: ' . $res);
        echo '<br></br>';
        //获取存储空间的地域
        $Regions = $this->ossClient->getBucketLocation($bucket);
        var_dump($Regions);
        echo '<br></br>';
        //获取存储空间元信息
        $Metas = $this->ossClient->getBucketMeta($bucket);
        var_dump($Metas);
        echo '<br></br>';
    }
    public function getBucketList(){
        $bucketList = $this->ossClient->listBuckets()->getBucketList();
        foreach($bucketList as $bucket) {
            print($bucket->getLocation() . "\t" . $bucket->getName() . "\t" . $bucket->getCreatedate() . "\n");
            echo '<br></br>';
        }
    }
    public function deleteBucket(){
        $bucket = "xujunjie-test1";
        print_r($this->ossClient->deleteBucket($bucket));
    }
    public function stringUpload(){
        $bucket = "xujunjie-test";
        $object = "file/xujunjie.txt";
        $content = "Hello OSS";
        print_r($this->ossClient->putObject($bucket, $object, $content));die;
    }
    public function fileUpload(){
        $bucket= "xujunjie-test";
        $object = "image/test.png";
        $filePath = "./5b20d7e3a4e965a95ad17e0208daf802.png";
        print_r($this->ossClient->uploadFile($bucket, $object, $filePath));die;
    }
    public function downlaod(){
        $bucket= "xujunjie-test";
        $object = "file/xujunjie.txt";
        $localfile = "./static";
        $options = array(
            OssClient::OSS_FILE_DOWNLOAD => $localfile
        );
        print_r($this->ossClient->getObject($bucket, $object, $options));
    }
    public function test(){

        
        print_r($res);die;

        // //创建bucket
        // try {
        //     $ossClient = new OssClient($this->accessKeyId, $this->accessKeySecret, $this->endpoint);
        //     $ossClient->createBucket($this->bucket);
        // } catch (OssException $e) {
        //     print $e->getMessage();
        // }
        //字符串上传
        $object = " <yourObjectName>";
        $content = "Hi, OSS.";

        try {
            $ossClient = new OssClient($this->accessKeyId, $this->accessKeySecret, $this->endpoint);
            $ossClient->putObject($this->bucket, $object, $content);
        } catch (OssException $e) {
            print $e->getMessage();
        }
    }
    
}