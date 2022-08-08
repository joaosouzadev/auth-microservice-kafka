<?php

namespace App\Handlers;

use Junges\Kafka\Contracts\KafkaConsumerMessage;

class EmailJobHandler {
    public function __invoke(KafkaConsumerMessage $message) {
        $class = "App\Jobs\\" . $message->getBody()['action'];
        $class::dispatch($message->getBody()['data']);
    }
}
