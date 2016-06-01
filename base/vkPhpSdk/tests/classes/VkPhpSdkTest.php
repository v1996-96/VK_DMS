<?php
require_once 'PHPUnit/Framework.php';

require_once dirname(__FILE__) . '/../../classes/VkPhpSdk.php';

/**
 * Test class for VkPhpSdk.
 * Generated by PHPUnit on 2011-08-21 at 21:47:38.
 */
class VkPhpSdkTest extends PHPUnit_Framework_TestCase
{
	const ACCESS_TOKEN = 'f1a073b8f1cca72ff1cca72fe5f1e9f27b6f1ccf1cda7317e530c976d67b03c';
	const USER_ID = '7132311';
	
	/**
	 * @var VkPhpSdk
	 */
	protected $transientVkPhpSdk;

	/**
	 * @var VkPhpSdk
	 */
	protected $transientVkPhpSdkWithWrongCurlResponse;

	/**
	 * @var VkPhpSdk
	 */
	protected $transientVkPhpSdkWithWrongVkResponse;
	
	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		// Init transient VkPhpSdk
		$this->transientVkPhpSdk = new TransientVkPhpSdk();
		$this->transientVkPhpSdk->setAccessToken(self::ACCESS_TOKEN);
		$this->transientVkPhpSdk->setUserId(self::USER_ID);		
		
		// Init transient VkPhpSdk with wrong curl response
		$this->transientVkPhpSdkWithWrongCurlResponse = new TransientVkPhpSdkWithWrongCurlResponse();
		$this->transientVkPhpSdkWithWrongCurlResponse->setAccessToken(self::ACCESS_TOKEN);
		$this->transientVkPhpSdkWithWrongCurlResponse->setUserId(self::USER_ID);
		
		// Init transient VkPhpSdk with wrong VK response
		$this->transientVkPhpSdkWithWrongVkResponse = new TransientVkPhpSdkWithWrongVkResponse();
		$this->transientVkPhpSdkWithWrongVkResponse->setAccessToken(self::ACCESS_TOKEN);
		$this->transientVkPhpSdkWithWrongVkResponse->setUserId(self::USER_ID);						
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
		unset ($this->transientVkPhpSdk);
		unset ($this->transientVkPhpSdkWithWrongCurlResponse);
		unset ($this->transientVkPhpSdkWithWrongVkResponse);
	}

	public function testGetAccessToken()
	{
		$this->markTestSkipped('It just a getter');
	}

	public function testSetAccessToken()
	{
		$this->markTestSkipped('It just a setter');
	}

	public function testGetUserId()
	{
		$this->markTestSkipped('It just a getter');
	}

	public function testSetUserId()
	{
		$this->markTestSkipped('It just a setter');
	}

	public function testApi()
	{
		$result = $this->transientVkPhpSdk->api('getProfiles', array('uids' => $this->transientVkPhpSdk->getUserId()));
		
		$this->assertArrayHasKey('response', $result);
		$this->assertEquals($result['response'][0]['last_name'], 'Геоня');
	}
	
	/**
	 * @expectedException VkApiException
	 */
	public function testApiWithWrongCurlResponse()
	{
		$this->transientVkPhpSdkWithWrongCurlResponse->api('getProfiles', array(
			'uids' => $this->transientVkPhpSdkWithWrongCurlResponse->getUserId()
		));
	}
	
	/**
	 * @expectedException VkApiException
	 */
	public function testApiWithWrongVkResponse()
	{
		$this->transientVkPhpSdkWithWrongVkResponse->api('getProfiles', array(
			'uids' => $this->transientVkPhpSdkWithWrongVkResponse->getUserId()
		));
	}	
}

class TransientVkPhpSdk extends VkPhpSdk
{
	protected function makeCurlRequest($method, array $params = null)
	{
		return '{"response":[{"uid":7132311,"first_name":"Андрей","last_name":"Геоня"}]}';		
	}
}

class TransientVkPhpSdkWithWrongCurlResponse extends VkPhpSdk
{
	protected function makeCurlRequest($method, array $params = null)
	{
		throw new VkApiException(array(
			'error_code' => 3,
			'error_msg' => 'CURLE_URL_MALFORMAT',
			'error_type' => 'CurlException'
		));
	}
}

class TransientVkPhpSdkWithWrongVkResponse extends VkPhpSdk
{
	protected function makeCurlRequest($method, array $params = null)
	{
		return '{"error":{"error_code":113,"error_msg":"Invalid user id","request_params":[{"key":"oauth","value":"1"},{"key":"method","value":"getProfiles"}]}}';
	}
}