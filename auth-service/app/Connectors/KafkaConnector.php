<?php

namespace App\Connectors;

use App\Queues\KafkaQueue;
use Illuminate\Queue\Connectors\ConnectorInterface;

class KafkaConnector implements ConnectorInterface {
    public function connect(array $config) {
        $conf = new \RdKafka\Conf();
        $conf->set('bootstrap.servers', $config['boostrap_servers']);
        $conf->set('security.protocol', $config['security_protocol']);
        $conf->set('sasl.mechanisms', $config['sasl_mechanisms']);
        $conf->set('sasl.username', $config['sasl_username']);
        $conf->set('sasl.password', $config['sasl_password']);

        $producer = new \RdKafka\Producer($conf);

        $conf->set('group.id', $config['group_id']);
        $conf->set('auto.offset.reset', $config['auto_offset_reset']);

        $consumer = new \RdKafka\KafkaConsumer($conf);

        return new KafkaQueue($producer, $consumer);
    }
}
