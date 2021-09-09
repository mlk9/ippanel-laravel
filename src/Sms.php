<?php

namespace Mlk9\Sms;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Sms
{
    protected $endpoint = 'http://rest.ippanel.com';
    protected $uri;
    protected $connection;
    protected $param;
    protected $method;

    public function __construct($api,$originator)
    {
        $this->connection = [
            'api'=>$api,
            'originator'=>$originator,
        ];

        return $this;
    }

    public function message($message,$recipients = [])
    {
        $this->param =[
            'recipients'=>$this->integerToString($recipients),
            'message'=>'message',
            'originator'=>$this->connection['originator'],
        ];
        $this->uri = '/v1/messages';
        $this->method = 'POST';
        return $this;
    } 

    public function patternMessage($code,$values = [],$recipient)
    {
        $this->param = [
            'recipient'=>$this->integerToString($recipient),
            'pattern_code'=>$code,
            'values'=>$values,
            'originator'=>$this->connection['originator'],
        ];
        $this->uri = '/v1/messages/patterns/send';
        $this->method = 'POST';
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
            $response = $client->request($this->method, $this->endpoint.$this->uri, [
                'headers' => [
                    'Authorization' => 'AccessKey '.$this->connection['api'],
                ],
                'json' =>  $this->param,

            ]);
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
        if(!is_array($array))
        {
            return strval($array);
        }
        $newArray = [];
        foreach ($array as $key => $value) {
            $newArray[$key] = strval($value);
        }
        return $newArray;
    }

}