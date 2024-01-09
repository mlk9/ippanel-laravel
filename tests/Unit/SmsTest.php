<?php

namespace Mlk9\SmsPackage\Tests\Unit;

use Mlk9\Sms\Facades\Sms;
use Mlk9\SmsPackage\Tests\TestCase;

class SmsTest extends TestCase
{
	private function isSiteAvailible($url){
		// Check, if a valid url is provided
		if(!filter_var($url, FILTER_VALIDATE_URL)){
			return false;
		}
	
		// Initialize cURL
		$curlInit = curl_init($url);
		
		// Set options
		curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,10);
		curl_setopt($curlInit,CURLOPT_HEADER,true);
		curl_setopt($curlInit,CURLOPT_NOBODY,true);
		curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);
	
		// Get response
		$response = curl_exec($curlInit);
		
		// Close a cURL session
		curl_close($curlInit);
	
		return $response?true:false;
	}

	public function testServer()
	{
		$this->assertEquals($this->isSiteAvailible(config('ippanel.server', 'https://ippanel.com/services.jspd')),true);
	}
	
}