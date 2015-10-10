<?php namespace ZuiHuiGou;

use Illuminate\Database\Eloquent\Model;

class Trade_log extends Model {
    use SoftDeletes;

    protected $dates = ['deleted_at'];
	//

}
