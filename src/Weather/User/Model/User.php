<?php

declare(strict_types=1);

namespace Weather\User\Model;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Pandawa\Component\Ddd\AbstractModel;
use Pandawa\Module\Api\Security\Contract\SignableUserInterface;

/**
 * Class User
 * @author Komala Surya <komala.surya.w@gmail.com>
 * @property string $id
 * @property string $username
 * @property string $email
 */
class User extends AbstractModel implements AuthenticatableContract, SignableUserInterface
{
    use Authenticatable;

    /**
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password'
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    protected function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * @return array
     */
    public function getSignPayload(): array
    {
        return [
            'sub' => $this->id,
            'username' => $this->username,
        ];
    }

    public function toArray(): array
    {
        return [];
    }
}