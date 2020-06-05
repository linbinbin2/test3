<?php
namespace app\index\validate;
use think\Validate;
class User extends Validate{
    protected $rule = [
        'username'  => 'require|length:3,20',
        'contents' => 'require',
        'sheng' => 'require',
        'shi' => 'require',
        'qu' => 'require',
        'typea' => 'require',
        'typeb' => 'require',
        //'userphone' => 'require|max:11|/^1[3-8]{1}[0-9]{9}$/|require',
        'phonecheck' => 'require',
    ];
    protected $message = [
        'username.require'=>"账号不能为空",
        'username.length'=>"账号请设置3~20个字符",
        'contents.require'=>"内容不能为空",
        'sheng.require'=>"请选择省份",
        'shi.require'=>"请选择市",
        'qu.require'=>"地区县不能为空",
        'typea.require'=>"类型不能为空",
        'typeb.require'=>"商品类型不能为空"
        //'userphone.require'=>"手机号不能为空"
    ];
}