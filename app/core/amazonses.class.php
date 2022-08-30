<?php
namespace Core;
require_once app_root . '/vendor/autoload.php';

use Aws\Ses\Exception\SesException;
use Aws\Ses\SesClient;
use Aws\Exception\AwsException;
class AmazonSes
{
    public static function send($sender,$recipients,$subject,$body,$htmlMail=true)
    {
        $char_set = 'UTF-8';

        try {

            $SesClient = new SesClient([
                'version' => 'latest',
                'region'  => 'us-east-1',
                'credentials' => array(
                    'key'    => AWS_ACCESS_KEY_ID,
                    'secret' => AWS_SECRET_ACCESS_KEY,
                )
            ]);

            if($htmlMail!=false)
                $mailBody = [
                    'Html' => [
                        'Charset' => $char_set,
                        'Data' => $body,
                    ]
                ];
            else
                $mailBody = [
                    'Text' => [
                        'Charset' => $char_set,
                        'Data' => $body,
                    ],
                ];

            $result = $SesClient->sendEmail([
                'Destination' => [
                    'ToAddresses' => $recipients,
                ],
                'ReplyToAddresses' => [$sender],
                'Source' => $sender,
                'Message' => [
                    'Body' => $mailBody,
                    'Subject' => [
                        'Charset' => $char_set,
                        'Data' => $subject,
                    ],
                ],
            ]);

            $messageId = $result['MessageId'];
            return $messageId;
        } catch (AwsException $e) {
            throw new \Exception("The email was not sent. Error message: ".$e->getMessage());
        }
    }
}
?>
