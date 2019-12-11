<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

class Index extends Controller
{
    public function index(){
        $list = Db::name('currency_snapshot')->order('token asc,date asc')->paginate(10);
        $this->assign('list', $list);
        return $this->fetch();
    }
}