<?php namespace ZuiHuiGou\Http\Controllers;

use ZuiHuiGou\Demand;
class WelcomeController extends Controller {
	public function __construct()
	{
		//$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
        if($this->ismobile())
        {
            $model=new Demand();
            $demands=$model->getBidding();
            $data=array(
                'demands'=>$demands
            );
            return view('indexm')->with($data);
        }
        else
            return view('index');

	}
}
