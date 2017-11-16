<?php
namespace PhpRush\Wechat\Applet;

use Illuminate\Support\ServiceProvider;

class WechatAppletServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $config_file = dirname(dirname(__DIR__)) . '/config/config.php';
        $this->mergeConfigFrom($config_file, 'wechat/applet');
        $this->publishes([
            $config_file => config_path('wechat/applet.php')
        ], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('WechatApplet', function () {
            $config = config('wechat.applet');
            return new WechatApplet($config);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'WechatApplet',
            WechatApplet::class
        ];
    }
}