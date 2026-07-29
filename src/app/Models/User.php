<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Constants\UserConstant;
use App\Providers\Filament\Avatars\DiceBearAvatarsProvider;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Override;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser, HasAvatar
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected function avatar(): Attribute
    {
        return Attribute::make(get: fn(?string $value) => $value ? asset($value) : (new DiceBearAvatarsProvider)->get($this));
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function lecturer()
    {
        return $this->hasOne(Lecturer::class);
    }

    #[Override]
    public function canAccessPanel(Panel $panel): bool
    {
        return match ($panel->getId()) {
            'admin'         => $this->role === UserConstant::Role_Admin,
            'lecturer'      => $this->role === UserConstant::Role_Lecturer,
            'student'       => $this->role === UserConstant::Role_Student,
            default         => false,
        } && in_array($this->status, [
            UserConstant::Status_Pending,
            UserConstant::Status_Approved
        ]);
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar ? asset($this->avatar) : null;
    }
}
