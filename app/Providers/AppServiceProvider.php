<?php namespace ZuiHuiGou\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
        /**
         * 获取所有系统设置项并生成键值对
         */
        $ss = DB::select('select set_key,set_value from settings');
        $settings=array();
        foreach($ss as $v){
            $i = 0;$s1='';
            foreach($v as $s){
                if($i == 1){
                    $settings=array_merge($settings,array($s1=>$s));
                }
                $s1=$s;
                $i++;
            }
        }

        View::share('settings', $settings);
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'ZuiHuiGou\Services\Registrar'
		);
	}

}
