<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Company extends Model
{
    protected $fillable = [
        'name',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function shortUrls(): HasMany
    {
        return $this->hasMany(ShortUrl::class);
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class);
    }

    /**
     * The first admin invite - the one SuperAdmin sent when creating the client.
     */
    public function clientInvitation(): HasOne
    {
        return $this->hasOne(Invitation::class)->ofMany(
            ['id' => 'min'],
            fn ($query) => $query->where('role', 'admin')
        );
    }
}
