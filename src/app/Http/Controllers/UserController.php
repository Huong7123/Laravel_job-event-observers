<?php

namespace App\Http\Controllers;

use App\Jobs\TestJob;
use App\Jobs\SendTelegramNotificationJob;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController 
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getAllUsers();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $user = $this->userService->createUser($data);

        $message = "🎉 <b>Người dùng đăng ký mới!</b>\nName: {$user->name}\nEmail: {$user->email}";
        SendTelegramNotificationJob::dispatch($message);

        return response()->json($user, 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'password' => 'sometimes|string|min:6',
        ]);

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $user = $this->userService->updateUser($id, $data);

        $changes = [];
        if ($user->wasChanged('name')) {
            $changes[] = 'name';
        }
        if ($user->wasChanged('password')) {
            $changes[] = 'password';
        }

        if (!empty($changes)) {
            \Illuminate\Support\Facades\Log::info("Đang gọi event UserUpdated cho User ID: {$user->id} với thay đổi: " . implode(', ', $changes));
            \App\Events\UserUpdated::dispatch($user, $changes);
        }

        return response()->json($user);
    }
}
