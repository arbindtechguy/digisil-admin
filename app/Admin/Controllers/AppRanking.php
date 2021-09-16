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

class AppRanking extends Controller {
    private $category = null;
    private $rank = null;
    private $group = null;
    private $app = null;
    private $id = null;

    function __construct(Request $req) {
        if ($req->post('rank')) {
            $this->rank = $req->post('rank');
        }
        if ($req->post('group')) {
            $this->group = $req->post('group');
        }
        if ($req->post('app')) {
            $this->app = $req->post('app');
        }
        if ($req->post('id')) {
            $this->id = $req->post('id');
        }
    }

    public function appsList(Content $content, $groupId) {
        if (!$groupId) {
            abort(404);
        }

        $apps = DB::table('apps')->select('app', 'id')->where(
            [
                'group_id' => $groupId,
            ]
        )->get();

        $context = [
            'apps' => $apps,
            'groupId' => $groupId
        ];
        return $content
            ->title('App Classification')
            ->description('App Classification for search screen')
            ->body(view('admin.app_rank.app', $context));
    }

    public function addApp(Content $content, $groupId = "") {
        if (!$groupId) {
            abort(404);
        }
        $this->groupId = $groupId;

        $app = [];
        if ($this->app) {
            $app['rank'] = $this->rank;
            $app['group_id'] = $groupId;
            $app['app'] = $this->app;
        }
        $msg_type = 'flash_message_error';
        $msg = "エラー：もう一回登録してください。";
        if ($this->app) {
            if (DB::table('apps')->insert($app)) {
                $msg_type = 'flash_message';
                $msg = "アプリを登録されました。";
            }
        }
        return Redirect::back()->with($msg_type, $msg);
    }

    public function deleteApp(Content $content, $id = "") {
        if (!$id) {
            abort(404);
        }
        $this->id = $id;
        
        $msg_type = 'flash_message_error';
        $msg = "エラー：もう一回登録してください。";
        if ($this->id) {
            if (DB::table('apps')->where([
                'id' => $id,
            ])->delete()) {
                $msg_type = 'flash_message';
                $msg = "アプリを登録されました。";
            }
        }
        return Redirect::back()->with($msg_type, $msg);
    }
}