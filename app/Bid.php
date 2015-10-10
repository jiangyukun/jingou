<?php namespace ZuiHuiGou;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bid extends Model {
    use SoftDeletes;

    protected $dates = ['deleted_at'];
	//

    public function demand()
    {
        return $this->belongsTo('ZuiHuiGou\Demand');
    }
    public function user()
    {
        return $this->belongsTo('ZuiHuiGou\User');
    }
    protected static function addRules()
    {
        return [
            'price' => 'required|numeric',
            'url' => 'url'
        ];
    }
}
