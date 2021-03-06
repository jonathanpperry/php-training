<?php

/**
 * ユーザー
 */

namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\BaseRepository;
use Exception;

class UserService
{
    private $userRepository;

    public function __construct(
        UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    /**
     * Insert user data
     *
     * @param int $user_id
     * @return array
     */
    public function getUserByUserID(int $user_id)
    {
        $inserted_data = $this->userRepository->getByUserId($user_id);
        return $inserted_data;
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
     * Assign the generated token to the user
     *
     * @param int $UserId
     * @param string $token
     * @return string
     */
    public function assignTokenToUser(int $UserId)
    {
        // Create a token
        $token = random_bytes(8);
        $token = substr(bin2hex($token), 0, 8);
        $userObject = $this->userRepository->getUserByUserID($UserId);
        if ($userObject) {
            $this->userRepository->assignTokenToUser($UserId, $token);
            return $token;
        } else {
            return 500;
        }
        return null;
    }
}
