<?php

namespace Mlk9\Sms;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Sms
{
    protected $connection;
    protected $param;

    public function __construct($username,$password,$from)
    {
        $this->connection = [
            'uname'=>$username,
            'pass'=>$password,
            'from'=>$from,
        ];

        return $this;
    }

    public function message($message,$to = [])
    {
        $this->param = array_merge($this->connection,[
            'to'=>json_encode($this->integerToString($to)),
            'op'=>'send',
        ]);
        return $this;
    } 

    public function patternMessage($code,$data = [],$to = [])
    {
        $this->param = array_merge($this->connection,[
            'to'=>json_encode($this->integerToString($to)),
            'pattern_code'=>$code,
            'input_data'=>json_encode($data),
            'op'=>'sendPattern',
        ]);
        return $this;
    } 

    public function send()
    {
        if(is_null($this->param))
        {
            throw new \Exception('param not isset');
        }
        try {
            $client = new Client();
            $response = $client->request('POST', 'https://ippanel.com/services.jspd', $this->param);
            return $response;
        }
        catch (RequestException $e) 
        {   
            throw $e;
        }

        throw new \Exception('param not isset');
    } 

    private function integerToString($array=[])
    {
        $newArray = [];
        foreach ($array as $key => $value) {
            $newArray[$key] = strval($value);
        }
        return $newArray;
    }

}