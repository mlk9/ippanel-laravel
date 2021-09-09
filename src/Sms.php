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
            'to'=>json_encode($to),
            'op'=>'send',
        ]);
        return $this;
    } 

    public function patternMessage($message,$code,$data = [],$to = [])
    {
        $this->param = array_merge($this->connection,[
            'to'=>json_encode($to),
            'pattern_code'=>$code,
            'input_data'=>$data,
            'op'=>'sendPattern',
        ]);
        return $this;
    } 

    public function send()
    {
        if(is_null($this->param))
        {
            return null;
        }
        try {
            $client = new Client();
            $response = $client->request('POST', 'https://ippanel.com/services.jspd', $this->param);
            return $response;
        }
        catch (RequestException $e) 
        {   
            return $e;
        }

        return null;
    } 

}