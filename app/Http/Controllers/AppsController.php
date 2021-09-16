<?php
namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
class AppsController extends BaseController {
    private $category_id = null;
    private $rank = null;
    private $group_id = null;
    private $id = null;
    private $key = null;
    private $where;

    function __construct(Request $req) {
        if ($req->get('category_id')) {
            $this->category_id = $req->get('category_id');
        }
        if ($req->get('rank')) {
            $this->rank = $req->get('rank');
        }
        if ($req->get('group_id')) {
            $this->group_id = $req->get('group_id');
        }
        if ($req->get('id')) {
            $this->id = $req->get('id');
        }
        if ($req->get('key')) {
            $this->key = $req->get('key');
            if ($this->key != md5('digisil')) {
                abort(403);
            }
        }
        else {
            abort(403);
        }
    }

    public function getCategories() {
        $getCategories = DB::table('apps_category')->select('category', 'rank', 'id')->get();
        return json_encode($getCategories);
    }
    public function getGroups() {
        if ($this->category_id) {
            $this->where['category_id'] = $this->category_id;
        }
        $getCategories = DB::table('apps_group')->select('group', 'rank', 'id', 'category_id')
        ->where($this->where)
        ->get();
        return json_encode($getCategories);
    }
    
    public function getApps() {
        if ($this->group_id) {
            $this->where['group_id'] = $this->group_id;
        }
        $getCategories = DB::table('apps')->select('app', 'rank', 'id', 'group_id')
        ->where($this->where)
        ->get();
        return json_encode($getCategories);
    }
    
}