<?php

namespace Mlk9\Sms;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Sms
{
    private function sendRequest($param)
    {
        $server = config('ippanel.server', 'https://ippanel.com/services.jspd');
        $authorization = [
            'uname' => config('ippanel.username', null),
            'pass' => config('ippanel.password', null),
        ];
        try {
            $client = new Client();
            $response = $client->request('POST', $server, [
                'form_params' =>  array_merge($authorization, $param),
                'verify' => false
            ]);

            $body = $response->getBody();
            $remainingBytes = $body->getContents();
            return $remainingBytes;
        } catch (RequestException $e) {
            throw $e;
        }
    }

    /**
     * integerToString function
     *
     * @param array|string $data
     * @return string|array
     */
    private function integerToString($data)
    {
        if (!is_array($data)) {
            return $this->convertNumbers(strval($data));
        }
        $newArray = [];
        foreach ($data as $key => $value) {
            $newArray[$key] = $this->convertNumbers(strval($value));
        }
        return $newArray;
    }

    /**
     * convertNumbers function (fa and ar to en)
     *
     * @param string $string
     * @return string
     */
    private function convertNumbers($string = "")
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١', '٠'];

        $num = range(0, 9);
        $convertedPersianNums = str_replace($persian, $num, $string);
        $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);

        return $englishNumbersOnly;
    }

    public function getCredit()
    {
        $param = [
            'op' => 'credit',
        ];

        try {
            $response = $this->sendRequest($param);
        } catch (\Exception $e) {
            throw $e;
        }

        return json_decode($response)[1];
    }

    public function sendMessage($text, $recipients)
    {
        if (is_array($recipients) === false) {
            $recipients = [$recipients];
        }
        $param = [
            'op' => 'send',
            'from' => config('ippanel.originator', null),
            'message' => $text,
            'to' => json_encode($this->integerToString($recipients)),
        ];
        try {
            $this->sendRequest($param);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function sendPatternMessage($code_pattern, $recipient, $entries = [])
    {
        $param = [
            'op' => 'sendPattern',
            'from' => config('ippanel.originator', null),
            'code_pattern' => $code_pattern,
            'data_input' => json_encode($entries),
            'to' => $this->integerToString($recipient),
        ];
        try {
            $this->sendRequest($param);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}
