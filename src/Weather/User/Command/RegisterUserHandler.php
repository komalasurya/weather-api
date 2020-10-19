<?php
declare(strict_types=1);

namespace Weather\User\Command;

use Weather\User\Model\User;
use Weather\User\Repository\UserRepository;
use function Pandawa\Reactive\map;
use function Pandawa\Reactive\tap;
use function Pandawa\Reactive\of;

/**
 * Class RegisterUserHandler
 * @author Komala Surya <komala.surya.w@gmail.com>
 */
final class RegisterUserHandler
{
    /** @var UserRepository */
    private $repo;

    /** @var User */
    private $result;

    /**
     * RegisterUserHandler constructor.
     * @param UserRepository $repo
     */
    public function __construct(UserRepository $repo)
    {
        $this->repo = $repo;
    }

    public function handle(RegisterUser $message)
    {
        of($message)->pipe(
            map(function (RegisterUser $message) {
                return $message->payload()->all();
            }),
            map(function (array $params) {
                return new User($params);
            }),
            tap(function (User $user) {
                $this->repo->save($user);
            })
        )->subscribe(function (User $user) {
            $this->result = $user;
        });

        return $this->result;
    }
}