<?php
/**
 * 更新服务
 */

namespace app\service;


use app\common\controller\AppCommon;

class UpdateService
{
    public static function get_version()
    {
        $version = config('version');
        $dbVersion = AppCommon::data_get('version');
        if (empty($dbVersion) && !empty($version)) {
            //初始化安装
            AppCommon::data_add('version', [
                'app_version' => $version['app'],
                'sql_version' => $version['sql'],
                'file_version' => $version['file']
            ]);
            $dbVersion = AppCommon::data_get('version');
        }
        return [
            'new' => $version,
            'old' => $dbVersion
        ];
    }

    public static function app_update()
    {
        $version = self::get_version();
        if (!empty($version['new']) && !empty($version['old'])) {
            if ($version['old']['sql_version'] < $version['new']['sql']) {
                self::sql($version['old']['sql_version'], $version['new']['sql']);
            }
        }

        return data_return_arr();
    }

    private static function update_version($field, $v1, $v2)
    {
        AppCommon::data_update('version', [$field => $v1], [$field => $v2]);
    }

    private static function sql($oldVersion, $newVersion)
    {
        if (!file_exists(ROOT_PATH . 'install/update_sql.php')) {
            exit('update_sql.php缺失，不能完成更新');
        }
        $sqlArr = include ROOT_PATH . 'install/update_sql.php';
        if (!empty($sqlArr['v' . $newVersion])) {
            foreach ($sqlArr['v' . $newVersion] as $sql) {
                AppCommon::execute($sql);
            }
            self::update_version('sql_version', $oldVersion, $newVersion);
        }

    }
}