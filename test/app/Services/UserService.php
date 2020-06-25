<?php

/**
 * ユーザー
 */

namespace App\Services\Api;

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
     * ユーザーデータ登録
     *
     * @param array $input
     * @return array
     */
    public function createUser(array $input)
    {
        $this->baseRepository->startTransaction();

        try {
            // ユーザーマネージャーデータ作成
            $token  = $this->createToken();

            $authentication = $this->authenticationRepository->inserts([
                'uuid'      => $input['uuid'],
                'api_token' => $token,
            ]);

            $userId    = $authentication->id;


            // 子どもデータ作成
            $childData  = $this->userRepository->inserts([
                'trn_user_id'   => $userId,
                'nickname'      => $input['nickname'],
            ]);


            $this->baseRepository->commitTransaction();
        } catch (Exception $e) {
            $this->baseRepository->rollBackTransaction();
            throw $e;
        }


        $result = [
            'errorCode'     => config('errorcode.SUCCESS'),
            'userId'        => $userId,
            'accessToken'   => $token,
        ];

        return $result;
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
