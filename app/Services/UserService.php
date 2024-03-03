<?php

namespace App\Services;

use App\Exceptions\RegistrationFailException;
use App\Exceptions\ResourceForbiddenException;
use App\Models\Admin;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class UserService
{
    public function register(array $requestArray): string
    {
        DB::beginTransaction();
        try {
            $user = User::create($requestArray);
            $token = $user->createToken('USER-AUTH-TOKEN')->plainTextToken;
            DB::commit();
            return $token;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new RegistrationFailException('Failed to register user');
        }
    }

    public function login(array $requestArray): string
    {
        $user = User::where('email', $requestArray['email'])->first();

        if (is_null($user)) {
            throw new ResourceNotFoundException('User not found');
        }

        if (!Hash::check($requestArray['password'], $user->password)) {
            throw new ResourceForbiddenException('Email or password is incorrect');
        }

        return $user->createToken('USER-AUTH-TOKEN')->plainTextToken;
    }

    public function getUserProfile()
    {
        return Auth::guard('user')->user();
    }

    public function logout()
    {
        /** @var \App\Models\User $user **/
        $user = Auth::guard('user')->user();
        $user->tokens()->delete();
    }
}
