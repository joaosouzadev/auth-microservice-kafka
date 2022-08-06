<?php

namespace App\Queues;

use Illuminate\Queue\Queue;
use Illuminate\Contracts\Queue\Queue as QueueContract;

class KafkaQueue extends Queue implements QueueContract {
    protected $producer;
    protected $consumer;

    public function __construct($producer, $consumer) {
        $this->producer = $producer;
        $this->consumer = $consumer;
    }

    public function size($queue = null) {
        // TODO: Implement size() method.
    }

    public function push($job, $data = '', $queue = null) {
        $topic = $this->producer->newTopic('default');
        $topic->produce(RD_KAFKA_PARTITION_UA, 0, serialize($job));
        $this->producer->flush(10000);
    }

    public function pushRaw($payload, $queue = null, array $options = []) {
        // TODO: Implement pushRaw() method.
    }

    public function later($delay, $job, $data = '', $queue = null) {
        // TODO: Implement later() method.
    }

    public function pop($queue = null) {
        $this->consumer->subscribe(['default']);

        $message = $this->consumer->consume(120*1000);

        switch ($message->err) {
            case RD_KAFKA_RESP_ERR_NO_ERROR:
                $job = unserialize($message->payload);
                $job->handle();
                break;
            case RD_KAFKA_RESP_ERR__PARTITION_EOF:
                var_dump("No more messages, waiting for more\n");
                break;
            case RD_KAFKA_RESP_ERR__TIMED_OUT:
                var_dump("Tiemd out\n");
                break;
            default:
                throw new \Exception($message->errstr(), $message->err);
        }
    }
}
