<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UpdateProfileController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreUserRequest $request, int $id)
    {
        $user = User::findOrFail($id);

        abort_if(auth()->id() !== $id, 403);

        $data = $request->validated();


        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            $path = $request->file('profile_picture')
                ->store('users/profile', 'public');

            $data['profile_picture'] = $path;
        }

        $user->update($data);
        return redirect()->route('profile.show')->with('message', 'Profiel succesvol bijgewerkt.');
    }
}
