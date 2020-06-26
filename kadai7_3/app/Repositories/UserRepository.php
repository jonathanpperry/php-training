<?php

/**
 * ユーザーテーブル
 */

namespace App\Repositories;

use App\Models\UserModel;

class UserRepository
{
    /**
     * ユーザーIDを指定してデータを取得する
     *
     * @param int $UserId
     * @return User
     */
    public function getByUserId(int $UserId)
    {
        return UserModel::query()->where('id', $UserId)->first();
    }

    /**
     * データを挿入する
     *
     * @param array $params
     * @return User
     */

    public function insertUser(array $params)
    {
        return UserModel::create($params);
    }

    /**
     * データを挿入する
     *
     * @param array $params
     * @return User
     */
    public function assignTokenToUser(int $UserId, string $token)
    {
        return UserModel::where('id', $UserId)->update(['access_token' => $token]);
    }
}
