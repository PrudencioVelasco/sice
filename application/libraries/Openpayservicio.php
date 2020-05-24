<?php 
class openpayservicio
{
     public function __construct()
    {
        //require_once(str_replace("\\", "/", APPPATH) . 'libraries/openpay/openpay.php'); //If we are executing this script on a Windows server
        if (!function_exists('curl_init')) {
			throw new Exception('CURL PHP extension is required to run Openpay client.');
		}
		if (!function_exists('json_decode')) {
			throw new Exception('JSON PHP extension is required to run Openpay client.');
		}
		if (!function_exists('mb_detect_encoding')) {
			throw new Exception('Multibyte String PHP extension is required to run Openpay client.');
		}

		require_once(str_replace("\\", "/", APPPATH) . 'libraries/openpay/data/OpenpayApiError.php');
		require_once(str_replace("\\", "/", APPPATH) . 'libraries/openpay/data/OpenpayApiConsole.php');
		require_once(str_replace("\\", "/", APPPATH) . 'libraries/openpay/data/OpenpayApiResourceBase.php');
		require_once(str_replace("\\", "/", APPPATH) . 'libraries/openpay/data/OpenpayApiConnector.php');
		require_once(str_replace("\\", "/", APPPATH) . 'libraries/openpay/data/OpenpayApiDerivedResource.php');
		require_once(str_replace("\\", "/", APPPATH) . 'libraries/openpay/data/OpenpayApi.php');

		require_once(str_replace("\\", "/", APPPATH) . 'libraries/openpay/resources/OpenpayBankAccount.php');
		require_once(str_replace("\\", "/", APPPATH) . 'libraries/openpay/resources/OpenpayCapture.php');
		require_once(str_replace("\\", "/", APPPATH) . 'libraries/openpay/resources/OpenpayCard.php');
		require_once(str_replace("\\", "/", APPPATH) . 'libraries/openpay/resources/OpenpayCharge.php');
		require_once(str_replace("\\", "/", APPPATH) . 'libraries/openpay/resources/OpenpayCustomer.php');
		require_once(str_replace("\\", "/", APPPATH) . 'libraries/openpay/resources/OpenpayFee.php');
		require_once(str_replace("\\", "/", APPPATH) . 'libraries/openpay/resources/OpenpayPayout.php');
		require_once(str_replace("\\", "/", APPPATH) . 'libraries/openpay/resources/OpenpayPlan.php');
		require_once(str_replace("\\", "/", APPPATH) . 'libraries/openpay/resources/OpenpayRefund.php');
		require_once(str_replace("\\", "/", APPPATH) . 'libraries/openpay/resources/OpenpaySubscription.php');
		require_once(str_replace("\\", "/", APPPATH) . 'libraries/openpay/resources/OpenpayTransfer.php');
		require_once(str_replace("\\", "/", APPPATH) . 'libraries/openpay/resources/OpenpayWebhook.php');
		require_once(str_replace("\\", "/", APPPATH) . 'libraries/openpay/resources/OpenpayToken.php');
    }
}
?>