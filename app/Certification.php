<?php namespace ZuiHuiGou;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Certification extends Model {
    use SoftDeletes;

    protected $dates = ['deleted_at'];
	//

}
