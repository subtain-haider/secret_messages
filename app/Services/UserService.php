<?php
namespace App\Services;

use App\Models\User;
use Auth;

class UserService
{
    /**
     * Retrieve all users except the given user ID.
     *
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUsersExcept($userId)
    {
        return User::where('id', '!=', $userId)->get();
    }

    public function store($data)
    {
        $user = User::create($data);
        Auth::login($user);
    }

}
