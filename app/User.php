<?php namespace ZuiHuiGou;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword, EntrustUserTrait;
    //use SoftDeletes;

    //protected $dates = ['deleted_at'];
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['username', 'email', 'password', 'mobile', 'telephone', 'gender', 'qq', 'wangwang', 'credit', 'head_thumb', 'last_time', 'birthday', 'balance', 'is_bidder', 'deposit', 'deposit_balance', 'ip'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

    protected static function loginRules()
    {
        return [
            'username' => 'required',
            'password' => 'required'
        ];
    }
    protected static function registerRules()
    {
        return [
            'username' => 'required|min:3|unique:users',
            'mobile' => 'required|unique:users',
            'mobile_code' => 'required|numeric',
            'password' => 'required|between:6,18|confirmed',
            'password_confirmation'=>'required|alpha_num|between:6,18'
        ];
    }
    public function demands()
    {
        return $this->hasMany('ZuiHuiGou\Demand');
    }
    public function bids()
    {
        return $this->hasMany('ZuiHuiGou\Bid');
    }

}
