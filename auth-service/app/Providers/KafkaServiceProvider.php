<?php

namespace App\Providers;

use App\Connectors\KafkaConnector;
use Illuminate\Support\ServiceProvider;

class KafkaServiceProvider extends ServiceProvider {
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {
        $manager = $this->app['queue'];
        $manager->addConnector('kafka', function() {
            return new KafkaConnector();
        });
    }
}
