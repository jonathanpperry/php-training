<?php
/**
 * ユーザーマネージャークラス
 * API認証に利用する
 */

namespace App\Repositories;

use App\Models\Trn\UserManage;

class AuthenticationRepository
{
    /**
     * データを挿入する
     *
     * @param array $param
     * @return UserManage
     */
    public function inserts(array $param)
    {
        return UserManage::create($param);
    }
}
