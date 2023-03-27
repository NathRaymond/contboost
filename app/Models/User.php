<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail, HasMedia
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use SearchableTrait;
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'about', 'username', 'status', 'google2fa_secret',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'users.name' => 10,
            'users.username' => 10,
            'users.email' => 10,
        ],
        'group_by' => [
            'users.name',
        ]
    ];

    protected $appends = ['subscription'];

    /**
     * User has many pages
     *
     * @return collection
     */
    public function pages()
    {
        return $this->hasMany(Page::class, 'author_id', 'id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'author_id', 'id');
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $notification = new ResetPassword($token);
        // Then use the createUrlUsing method
        $notification->createUrlUsing(function ($notifiable, $token) {
            return url(route("admin.password.reset", [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ]));
        });

        // Then you pass the notification
        $this->notify($notification);
    }

    public function documentWords()
    {
        return $this->documents()->sum('no_of_words');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'user_id');
    }

    /**
     * User has active subscription
     *
     * @return collection
     */
    public function activeSubscriptions()
    {
        return $this->transactions()->active()->plan()->whereDate('expiry_date', '>', now());
    }

    /**
     * User get active subscription
     *
     * @return collection
     */
    public function getSubscriptions()
    {
        return $this->activeSubscriptions()->paginate();
    }

    /**
     * User get active subscription
     *
     * @return collection
     */
    public function getActiveSubscription()
    {
        return $this->activeSubscriptions()->first();
    }

    /**
     * User has active subscription
     *
     * @return collection
     */
    public function hasActiveSubscription()
    {
        return $this->activeSubscriptions()->count() !== 0;
    }

    /**
     * User has many trnasactions
     *
     * @return collection
     */
    public function transactionsList()
    {
        return $this->hasMany(Transaction::class, 'user_id');
    }

    /**
     * User has many trnasactions
     *
     * @return collection
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_id', 'id')->latest();
    }

    public function subscription(): Attribute
    {
        return new Attribute(
            get: fn () =>  $this->getActiveSubscription(),
        );
    }

    public function hasVerifiedEmail()
    {
        if (setting('activation_required', 0) != 0) {
            return true;
        }

        return empty($this->email_verified_at);
    }
}
