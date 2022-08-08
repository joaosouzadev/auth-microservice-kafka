<?php

namespace App\Console\Commands;

use App\Handlers\EmailJobHandler;
use Illuminate\Console\Command;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Deserializers\JsonDeserializer;

class KafkaConsumer extends Command {
    protected $signature = 'kafka:consume';

    protected $description = 'Command description';

    public function handle() {
        $consumer = Kafka::createConsumer()->subscribe('default')
            ->withHandler(new EmailJobHandler)
            ->withConsumerGroupId(env('KAFKA_GROUP_ID'))
            ->withOptions([
                'bootstrap.servers' => env('KAFKA_BROKERS'),
                'security.protocol' => env('KAFKA_SECURITY_PROTOCOL'),
                'sasl.mechanisms' => env('KAFKA_SASL_MECHANISMS'),
                'sasl.username' => env('KAFKA_SASL_USERNAME'),
                'sasl.password' => env('KAFKA_SASL_PASSWORD'),
                'group.id' => env('KAFKA_GROUP_ID'),
                'auto.offset.reset' => 'earliest'
            ])
            ->usingDeserializer(new JsonDeserializer())
            ->build();

        $consumer->consume();
    }
}
