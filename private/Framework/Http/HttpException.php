<?php
namespace Framework\Http;
use Exception;

/*class Handler
{
    public static function report(Exception $e){
        $date = date('Y-m-d H:i:s (T)');
        $f = fopen('../private/errors.log', 'a');
        if(!empty($f)){
            $filename = str_replace($_SERVER['DOCUMENT_ROOT'], '', $e->getFile());
            $msg = $e->getMessage();
            $linenum = $e->getLine();
            $err = "$date $msg = $filename = $linenum\r\n";
            fwrite($f, $err);
            fclose($f);
        }
    }
}*/

class HttpException extends Exception
{
    public function __construct($message){
        parent::__construct($message);
    }
}