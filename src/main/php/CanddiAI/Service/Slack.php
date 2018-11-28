<?php
/**
 * Service for Stackpath api
 *
 * @author Tim Langley
 **/
namespace Canddi\Service;

use Crummy\Phlack\Phlack as Phlack;

class Slack
    implements \Canddi_Interface_Singleton
{
    use \Canddi_Traits_Singleton;

    const SLACK_USERNAME= "PHP Processing";

    const SLACK_WEBHOOK_PHP_PROCESSING = "https://hooks.slack.com/services/".
        "T04KLULQ9/B90M6CDU7/KdsG3WRcBmqPFaNGOpk73sdX";
    const SLACK_WEBHOOK_PHP_SLOW = "https://hooks.slack.com/services/".
        "T04KLULQ9/B96ERNYAX/tMac3GRa2h8HUO3hKAOjt7jf";

    /*
     *  Sends a message via slack
     *
     * @param $strMessage = thing to send
     *
     * @return void
     *
     * @author Tim Langley
    */
    public function sendMessage(
        $strMessage,
        $strUsername    = self::SLACK_USERNAME,
        $strWebHook     = self::SLACK_WEBHOOK_PHP_PROCESSING
    )
    {
        $phlack = new Phlack($strWebHook);

        $response   = $phlack->send([
            'username'     => $strUsername,
            'text'         => $strMessage
        ]);
        if(200 !== $response['status']) {
            //For some reason we can't send the message
            // so lets log instead
            \Canddi_Helper_Log::getInstance()->log(
                "Error sending Slack.  Message was : ".$strMessage,
                \Zend_Log::NOTICE
            );
        }
    }
}
