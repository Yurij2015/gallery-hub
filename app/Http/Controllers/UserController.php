<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateUserSettingsRequest;
use App\Models\User;
use Exception;
use DateTime;
use Illuminate\Support\Facades\Storage;
use Log;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('userDetail')->paginate();

        $userStatuses = [
            'active' => 'Active',
            'inactive' => 'Inactive',
            'pending' => 'Pending',
            'hold' => 'Hold',
            'suspend' => 'Suspend',
            'blocked' => 'Blocked',
        ];

        $roles = Role::all();

        return view('users.index', compact('users', 'userStatuses', 'roles'));
    }

    /**
     * @throws Exception
     */
    public function update(User $user, UpdateUserRequest $request)
    {
        $validatedRequest = $request->validated();

        $name = $validatedRequest['name'];
        $user->update(['name' => $name]);

        if (array_key_exists('role', $validatedRequest)) {
            $user->syncRoles($validatedRequest['role']);
        }

        try {
            $image = $request->file('file');
            $imageName = $image?->getClientOriginalName();
            $filePath = $user->email.'/images/'.$imageName;

            if ($imageName) {
                Storage::disk('s3')->put($filePath, file_get_contents($image));
                $avatar = Storage::disk('s3')->url($filePath);
                $validatedRequest['avatar'] = $avatar ?? null;
            }
        } catch (Exception $e) {
            Log::info($e->getMessage());
            throw $e;
//            return redirect()->back()->with('error', 'Failed to upload image');
        }

        $validatedRequest['dob'] = (DateTime::createFromFormat('d/m/Y', $validatedRequest['dob']))->format('Y-m-d');

        $user->userDetail()->updateOrCreate(
            ['user_id' => $user->id],
            $validatedRequest
        );

        return redirect()->route('users.index');
    }

    /**
     * @throws Exception
     */
    public function updateUserSettings(UpdateUserSettingsRequest $request)
    {
        $user = auth()->user();
        $validatedRequest = $request->validated();

        $name = $validatedRequest['name'];
        $user->update(['name' => $name]);

        try {
            $image = $request->file('file');
            $imageName = $image?->getClientOriginalName();
            $filePath = $user->email.'/images/'.$imageName;

            if ($imageName) {
                Storage::disk('s3')->put($filePath, file_get_contents($image));
                $avatar = Storage::disk('s3')->url($filePath);
                $validatedRequest['avatar'] = $avatar ?? null;
            }
        } catch (Exception $e) {
            Log::info($e->getMessage());
            throw $e;
        }

        $validatedRequest['dob'] = (DateTime::createFromFormat('d/m/Y', $validatedRequest['dob']))->format('Y-m-d');

        $user->userDetail()->updateOrCreate(
            ['user_id' => $user->id],
            $validatedRequest
        );

        return redirect()->route('profile.settings');
    }
}
