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

class CategoryRanking extends Controller {
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

    public function addCategory() {
        $msg_type = 'flash_message_error';
        $msg = "エラー：もう一回登録してください。";
        if ($this->category) {
            if (AppRankings::addCategory($this->rank, $this->category)) {
                $msg_type = 'flash_message';
                $msg = "カテゴリを登録されました。";
            }
        }
        return Redirect::back()->with($msg_type, $msg);
    }

    public function deleteCategory(Content $content, $id = "") {
        if (!$id) {
            abort(404);
        }
        $this->id = $id;
        
        $msg_type = 'flash_message_error';
        $msg = "エラー：もう一回登録してください。";
        if ($this->id) {
            if (DB::table('apps_category')->where([
                'id' => $id,
            ])->delete()) {
                $msg_type = 'flash_message';
                $msg = "アプリを登録されました。";
            }
        }
        return Redirect::back()->with($msg_type, $msg);
    }

    public function getCategoriesList() {
        return json_encode(AppRankings::getCategories());
    }
}