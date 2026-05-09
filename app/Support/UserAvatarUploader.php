<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class UserAvatarUploader
{
    public function store(User $user, UploadedFile $uploadedAvatar): string
    {
        $relativePath = $uploadedAvatar->store('avatars/' . $user->id, 'public');

        if (! is_string($relativePath)) {
            throw new RuntimeException('Unable to store avatar.');
        }

        $this->deleteManagedAvatar($user->avatar_path);

        return 'storage/' . $relativePath;
    }

    public function deleteManagedAvatar(?string $avatarPath): void
    {
        if ($avatarPath === null || ! str_starts_with($avatarPath, 'storage/avatars/')) {
            return;
        }

        Storage::disk('public')->delete(Str::after($avatarPath, 'storage/'));
    }
}
