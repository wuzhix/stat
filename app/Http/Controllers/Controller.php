<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $data;
    protected $leftMenus;
    protected $currentLeftMenu;

    function __construct()
    {
        $this->leftMenus = array(
            '用户统计' => 'user',
            '考勤统计' => 'attend',
            '流程统计' => 'circuit',
            '会议统计' => 'meeting',
            '论坛统计' => 'bbs',
            );
        $action = \Route::current()->getActionName();
        list($class, $method) = explode('@', $action);
        $class = substr(strrchr($class,'\\'),1);
        foreach($this->leftMenus as $k => $v) {
            if(strtolower("{$v}Controller") == strtolower($class)) {
                $this->currentLeftMenu = $v;
            }
        }
        $this->data = array('leftMenus'=>$this->leftMenus, 'currentLeftMenu'=>$this->currentLeftMenu);
    }
    
    protected function isDate($data, $format)
    {
        $dateResult = date($format, strtotime($data));
        return $dateResult === $data;
    }

    /** 将两个数组的key合并到每个数组，例如['a'=>1,'b'=>2]和['a'=>1,'c'=>3]合并后为
     *  ['a'=>1,'b'=>2,'c'=>$defaultValue]和['a'=>1,'b'=>$defaultValue,'c'=>3]
     * @param $array1
     * @param $array2
     * @param $sort
     * @param int $defaultValue
     */
    protected function mergeKey(&$array1, &$array2, $sort = false, $defaultValue = 0)
    {
        $merge_array = array_merge($array1, $array2);
        if($sort) {
            ksort($merge_array);
        }
        $array1_result = array();
        $array2_result = array();
        foreach($merge_array as $k => $v) {
            if(array_key_exists($k, $array1)) {
                $array1_result[$k] = $array1[$k];
            } else {
                $array1_result[$k] = $defaultValue;
            }
            if(array_key_exists($k, $array2)) {
                $array2_result[$k] = $array2[$k];
            } else {
                $array2_result[$k] = $defaultValue;
            }
        }
        $array1 = $array1_result;
        $array2 = $array2_result;
    }
}
