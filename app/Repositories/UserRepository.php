<?php

declare(strict_types=1);

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface UserRepository.
 */
interface UserRepository extends RepositoryInterface
{
    /**
     * Get the number of newly registered student users.
     *
     * @param $date
     * @param $userType
     * @return mixed
     */
    public function getNewlyUsers($date, $userType);

    /**
     * Get the accumulated number of registered users.
     *
     * @param $month
     * @param $userType
     * @return mixed
     */
    public function getRegisteredUsers($month, $userType);

    /**
     * Show User List.
     *
     * @param $request
     * @return mixed
     */
    public function showUserList($request);

    /**
     * Get user detail.
     *
     * @param $userId
     * @return mixed
     */
    public function getUserDetail($userId);

    /**
     * Get teacher by id.
     *
     * @param $userId
     * @return mixed
     */
    public function getDataTeacher($userId);

    /**
     * Get Rank Of User.
     *
     * @param $querySale
     * @param $queryReview
     * @param $data
     * @return mixed
     */
    public function getRankOfUser($querySale, $data);

    /**
     * Get Rank Of User By Target Date.
     *
     * @param $querySale
     * @param $queryReview
     * @param $data
     * @return mixed
     */
    public function getRankOfUserByTargetDate($querySale, $data);

    /**
     * Get user author
     * @param $userId
     * @return mixed
     */
    public function userAuthor($userId);

    /**
     * Do active account
     *
     * @param $email
     * @return mixed
     */
    public function activeAccount($email);

    /**
     * Update password
     *
     * @param $email
     * @param $password
     * @return mixed
     */
    public function resetPassword($email, $password);

    /**
     * Get user by email
     *
     * @param $email
     * @return mixed
     */
    public function getUserByEmail($email);

    /**
     * @return mixed
     */
    public function getUserLoggedIn();

    /**
     * @return mixed
     */
    public function getUserTeacher($user_id);

    /**
     * Get user teacher's rank.
     *
     * @return mixed
     */
    public function getTeacherRanks($userId);

    /**
     * Get info user by private chat
     *
     * @param $userId
     * @return mixed
     */
    public function getUserPrivateChat($userId);

    /**
     * Change status.
     *
     * @return mixed
     */
    public function changeStatus();

    public function userPurchase($userId, $courseScheduleId);

    /**
     * Get user not approve.
     *
     * @return mixed
     */
    public function getUserNotApprove();
}
