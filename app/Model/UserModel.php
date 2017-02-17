<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/18
 * Time: 15:56
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $connection = 'oa';
    protected $table = 'toa_user';

    public function statJoin($start_date, $end_date)
    {
        $sql = "select date(date) as date,count(*) as count from toa_user where ischeck = 1 and date(date) >= '{$start_date}' and date(date) <= '{$end_date}' group by date(date)";
        $data = \DB::connection('oa')->select($sql);
        $result = array();
        foreach($data as $v) {
            $result[$v->date] = $v->count;
        }
        return $result;
    }

    public function statLeft($start_date, $end_date)
    {
        $sql = "select date(updatetime) as date ,count(*) as count from toa_user where ischeck = 0 and date(updatetime) >= '{$start_date}' and date(updatetime) <= '{$end_date}' group by date(updatetime)";
        $data = \DB::connection('oa')->select($sql);
        $result = array();
        foreach($data as $v) {
            $result[$v->date] = $v->count;
        }
        return $result;
    }
}