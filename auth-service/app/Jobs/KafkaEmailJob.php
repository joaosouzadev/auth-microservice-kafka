<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;
use Junges\Kafka\Message\Serializers\JsonSerializer;

class KafkaEmailJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $data;
    protected string $action;
    protected Message $message;

    public function __construct(array $data, string $action) {
        $this->data = $data;
        $this->action = $action;
    }

    public function handle() {
        $this->buildMessage();

        $producer = Kafka::publishOn('default')
            ->withMessage($this->message)
            ->withDebugEnabled()
            ->usingSerializer(new JsonSerializer())
            ->withConfigOptions([
                'bootstrap.servers' => env('KAFKA_BROKERS'),
                'security.protocol' => env('KAFKA_SECURITY_PROTOCOL'),
                'sasl.mechanisms' => env('KAFKA_SASL_MECHANISMS'),
                'sasl.username' => env('KAFKA_SASL_USERNAME'),
                'sasl.password' => env('KAFKA_SASL_PASSWORD'),
                'group.id' => env('KAFKA_GROUP_ID')
            ])
        ;
        $producer->send();
    }

    private function buildMessage() {
        switch ($this->action) {
            case "WelcomeEmail":
                $this->welcomeEmailMessage();
                break;
            case "ResetPasswordEmail":
                $this->resetPasswordEmailMessage();
                break;
            case "ResetPasswordEmailConfirmation":
                $this->resetPasswordEmailConfirmationMessage();
                break;
            default:
                throw new \Exception('Invalid action');
        }
    }

    private function welcomeEmailMessage(): void {
        $this->message = new Message(
            body: ['action' => $this->action, 'data' => ['name' => $this->data['name'], 'email' => $this->data['email']]],
        );
    }

    private function resetPasswordEmailMessage(): void {
        $this->message = new Message(
            body: ['action' => $this->action, 'data' => ['email' => $this->data['email'], 'token' => $this->data['token']]],
        );
    }

    private function resetPasswordEmailConfirmationMessage(): void {
        $this->message = new Message(
            body: ['action' => $this->action, 'data' => ['email' => $this->data['email']]],
        );
    }
}
