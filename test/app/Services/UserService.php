<?php

/**
 * ユーザー
 */

namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\BaseRepository;
use App\Repositories\AuthenticationRepository;
use Exception;

class UserService
{
    private $userRepository;
    private $authenticationRepository;

    public function __construct(
        UserRepository $userRepository,
        AuthenticationRepository $authenticationRepository
    ) {
        $this->userRepository           = $userRepository;
        $this->authenticationRepository = $authenticationRepository;
    }

    /**
     * Insert user data
     *
     * @param array $input
     * @return array
     */
    public function insertUser(array $input)
    {

        $inserted_data = $this->userRepository->insertUser([
            'nickname' => $input['nickname']
        ]);

        return $inserted_data;
    }

    /**
     * アクセストークン生成
     *
     * @return string
     */
    private function createToken()
    {
        return str_random(64);
    }
}
