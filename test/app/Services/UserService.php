<?php

/**
 * ユーザー
 */

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Http\Exceptions\HttpResponseException;

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

    /**
     * Confirm the passed token is the one initially assigned to the user
     *
     * @param int $UserId
     * @param string $TokenToCheck
     * @return string
     */
    public function confirmUserToken(int $UserId, string $TokenToCheck)
    {
        $userObject = $this->userRepository->getUserByUserID($UserId);
        if ($userObject) {
            $userToken = $userObject['access_token'];
        } else {
            return 500;
        }
        if ($TokenToCheck != $userToken) {
            $response['data'] = ["不正です"];
            throw new HttpResponseException(
                response()->json($response, 500)
            );
        } else {
            return $userObject;
        }
    }
}
