<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/16
 * Time: 15:00
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\UserModel;

class UserController extends Controller
{
    /** GET /user?key=value
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $start_date = $request->input('start_date', date('Y-m-d', time()-30*24*60*60));
        $end_date = $request->input('end_date', date('Y-m-d'));
        if(!$this->isDate($start_date, 'Y-m-d') || !$this->isDate($end_date, 'Y-m-d')) {
            return redirect('user');
        }
        $this->data['start_date'] = $start_date;
        $this->data['end_date'] = $end_date;
        $User = new UserModel();
        $joinData = $User->statJoin($start_date, $end_date);
        $leftData = $User->statLeft($start_date, $end_date);
        $this->mergeKey($joinData, $leftData, true);
        $this->data['joinKey'] = json_encode(array_keys($joinData));
        $this->data['joinValue'] = json_encode(array_values($joinData));
        $this->data['leftKey'] = json_encode(array_keys($leftData));
        $this->data['leftValue'] = json_encode(array_values($leftData));
        return view('user.index', $this->data);
    }
}