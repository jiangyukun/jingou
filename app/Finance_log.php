<?php namespace ZuiHuiGou;

use Illuminate\Database\Eloquent\Model;

class Finance_log extends Model {
    use SoftDeletes;

    protected $dates = ['deleted_at'];
	//

}
