<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Illuminate\Http\Request;
use DB;
use Lib\Admin\AppRankings;
use Redirect;

class GroupRanking extends Controller {
    private $category = null;
    private $rank = null;
    private $group = null;
    private $id = null;

    function __construct(Request $req) {
        if ($req->post('category')) {
            $this->category = $req->post('category');
        }
        if ($req->post('rank')) {
            $this->rank = $req->post('rank');
        }
        if ($req->post('group')) {
            $this->group = $req->post('group');
        }
        if ($req->post('id')) {
            $this->id = $req->post('id');
        }
    }

    public function groupList(Content $content, $categoryID = "") {
        if (!$categoryID) {
            abort(404);
        }

        $groups = DB::table('apps_group')->where(['category_id' => $categoryID])->get();
        $context = [
            'groups' => $groups,
            'categoryID' => $categoryID
        ];
        return $content
            ->title('App Classification')
            ->description('App Classification for search screen')
            ->body(view('admin.app_rank.group', $context));
    }

    public function addGroup(Content $content, $categoryID = "") {
        if (!$categoryID) {
            abort(404);
        }
        $this->category = $categoryID;

        $groups = [];
        if ($this->group) {
            $group['rank'] = $this->rank;
            $group['category_id'] = $categoryID;
            $group['group'] = $this->group;
        }
        $msg_type = 'flash_message_error';
        $msg = "エラー：もう一回登録してください。";
        if ($this->category) {
            if (DB::table('apps_group')->insert($group)) {
                $msg_type = 'flash_message';
                $msg = "カテゴリを登録されました。";
            }
        }
        return Redirect::back()->with($msg_type, $msg);
    }

    public function deleteGroup(Content $content, $id = "") {
        if (!$id) {
            abort(404);
        }
        $this->id = $id;
        
        $msg_type = 'flash_message_error';
        $msg = "エラー：もう一回登録してください。";
        if ($this->id) {
            if (DB::table('apps_group')->where([
                'id' => $id,
            ])->delete()) {
                $msg_type = 'flash_message';
                $msg = "アプリを登録されました。";
            }
        }
        return Redirect::back()->with($msg_type, $msg);
    }

}