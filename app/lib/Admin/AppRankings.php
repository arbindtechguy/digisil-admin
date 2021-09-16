<?php
namespace Lib\Admin;
use DB;

class AppRankings {
    const TABLE = 'apps_category';

    public static function addCategory($rank, $category) {
        $success = false;
        $tuple = [];
        if ($category) {
            $tuple['category'] = $category;
            $tuple['rank'] = $rank;
            $tuple['created_at'] = date('Y-m-d H:i:s');
            $tuple['updated_at'] = date('Y-m-d H:i:s');
            try {
                DB::table(static::TABLE)->insert($tuple);
                $success = true;
            }
            catch (\Exception $e) {
                $success = false;
            }
        }
        return $success;
    }

    public static function addGroup($rank, $group) {
        $success = false;
        $tuple = [];
        if ($group) {
            $tuple['group'] = $group;
            $tuple['rank'] = $rank;
            $tuple['created_at'] = date('Y-m-d H:i:s');
            $tuple['updated_at'] = date('Y-m-d H:i:s');
            try {
                DB::table(static::TABLE)->insertOrUpdate($tuple);
                $success = true;
            }
            catch (\Exception $e) {
                $success = false;
            }
        }
        return $success;
    }

    public static function getCategories() {
        return DB::table(static::TABLE)->select('category', 'rank', 'id')->get();
    }
    
}