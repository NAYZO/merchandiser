<?php

namespace Nzo\MerchandBundle\ConsumerService;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class ManagerConsumer implements ConsumerInterface
{
    private $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function execute(AMQPMessage $msg)
    {
        $Array = unserialize($msg->body);
        $file = $this->path . '/Resources/views/Manager/file.xml';
        //$file = __DIR__ . '/../Resources/views/Manager/file.xml';

        $xml = simplexml_load_file($file);
        if ($xml->count() === 10) {
            unset($xml->node[0]);
        }

        $new = $xml->addChild("node");
        $new->addChild("sellername", $Array['sellername']);
        $new->addChild("buyername", $Array['buyername']);
        $new->addChild("price", $Array['price']);
        $new->addChild("amount", $Array['amount']);
        $xml->asXML($file);
    }

}
