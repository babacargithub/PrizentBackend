<?php


namespace App\Services;


use Mediumart\Orange\SMS\Http\SMSClient;
use Mediumart\Orange\SMS\SMS;
/**
 * helps send SMS messages using the Bundle MediumArt for Orange Api
 * Class SMSSender
 * @package App\Utils\NotificationSender\SMSSender
 */
class SMSSender
{

    public function __construct()
    {

    }

    /**
     * Sends an SMS to the given number
     * @param $phoneNumber
     * @param $content
     * @return bool|null
     */
    public static function sendSms($phoneNumber, $content): ?bool
    {
        // if the country code is missing we add it
        if (!str_starts_with($phoneNumber, "221")) {
            $phoneNumber = "221" . $phoneNumber;
        }
        $clientId = config("app.orange_api_client_id");
        $clientSecret = config("app.orange_api_client_secret");
        $clientSenderName = config("app.orange_api_sender_name");
        $clientSenderPhoneNumber = config("app.orange_api_sender_number");

        // avoid sending real sms in test and dev environment
       /* if ($this->container->getParameter("kernel.environment") == "test") {
            if (!$this->deliverOnTestEnvironment) {
                return null;
            }
        }*/
        $client = SMSClient::getInstance($clientId, $clientSecret);
        $sms = new SMS($client);
        $sms->message($content)
            ->from($clientSenderPhoneNumber, $clientSenderName)
            ->to($phoneNumber);
        return self::hasRequestSucceeded($sms->send());
    }

    public static function hasRequestSucceeded(array $response): bool
    {
        return isset($response["outboundSMSMessageRequest"]);

    }
}
