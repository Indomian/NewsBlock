<?php
namespace app\components\parser;

use Curl\Curl;

trait ParserDownload {

    protected function getContent() {
        $obRequest=new Curl();
        if(!is_null($this->lastRequest)) {
            $obRequest->setHeader('If-Modified-Since',gmdate('D, d M Y H:i:s T',strtotime($this->lastRequest)));
        }
        $obRequest->get($this->url);
        $obRequest->close();

        if ($obRequest->error) {
            \Yii::warning('Cant download source page: '.$this->url,__METHOD__);
            return false;
        }
        else
        {
            $currentCharset='utf-8';
            $charset='utf-8';
            foreach($obRequest->response_headers as $header) {
                if(preg_match('#^Content-Type:.*charset=(.*)$#',$header,$matches)) {
                    $charset=strtolower($matches[1]);
                }
            }
            if($currentCharset!=$charset) {
                $result=iconv($charset,$currentCharset,$obRequest->response);
            } else {
                $result=$obRequest->response;
            }
            return $result;
        }
    }

}