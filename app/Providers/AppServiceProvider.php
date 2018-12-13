<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\DataStructures\DataStructuresFactory;
use SoapClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('SoapClient', function () {
            try {
                $opts = array(
                    'http'=>array(
                        'user_agent' => 'PHPSoapClient'
                    )
                );
                $context = stream_context_create($opts);
                return new SoapClient(
                    'https://test.placetopay.com/soap/pse/',
                    array(
                        'stream_context' => $context,
                        'cache_wsdl' => WSDL_CACHE_NONE
                    )
                );
            } catch (Exception $e) {
                return null;
            }
        });

        $this->app->singleton('DataStructuresFactory', function () {
            return new DataStructuresFactory();
        });
    }
}
