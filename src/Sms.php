<?php

namespace Mlk9\Sms;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Sms
{
    protected $endpoint = 'http://rest.ippanel.com';//ippanel rest server
    protected $uri;
    protected $connection;
    protected $param;
    protected $method;

    /**
     * __construct
     *
     * @param string $api
     * @param string $originator
     */
    public function __construct($api,$originator)
    {
        $this->connection = [
            'api'=>$api,
            'originator'=>$originator,
        ];

        return $this;
    }

    /**
     * message function
     *
     * @param string $message
     * @param array $recipients
     * @return void
     */
    public function message($message="",$recipients = [])
    {
        $this->uri = '/v1/messages';
        $this->method = 'POST';
        $this->param =[
            'recipients'=>$this->integerToString($recipients),
            'message'=> $message,
            'originator'=>$this->connection['originator'],
        ];
        
        return $this;
    } 

    /**
     * patternMessage function
     *
     * @param string $code
     * @param array $values
     * @param integer $recipient
     * @return void
     */
    public function patternMessage($code="",$values = [],$recipient=0)
    {
        $this->uri = '/v1/messages/patterns/send';
        $this->method = 'POST';

        $this->param = [
            'recipient'=>$this->integerToString($recipient),
            'pattern_code'=>$code,
            'values'=>$values,
            'originator'=>$this->connection['originator'],
        ];
        
        return $this;
    } 

    /**
     * send function
     *
     * @return void
     */
    public function send()
    {
        if(is_null($this->param))
        {
            throw new \Exception('param not isset');
        }
        if(is_null($this->connection['api']))
        {
            throw new \Exception('please configure api');
        }
        if(is_null($this->connection['originator']))
        {
            throw new \Exception('please configure originator');
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

    /**
     * integerToString function
     *
     * @param array $array
     * @return void
     */
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