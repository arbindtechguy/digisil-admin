<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Lib\Admin\AppRankings;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        $context = [
            'categories' => AppRankings::getCategories()
        ];
        return $content
            ->title('App Classification')
            ->description('App Classification for search screen')
            ->body(view('admin.app_rank.category', $context));
    }
}
