<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * ユーザーモデル
 */
class UserModel extends Model
{
    // テーブル名を設定
    protected $table = 'users';

    // The primary key associated with the table.
    protected $primaryKey = 'id';

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'access_token' => 0,
        'level' => 1,
        'exp' => 0
    ];
}
