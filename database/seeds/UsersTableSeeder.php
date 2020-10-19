<?php
declare(strict_types=1);

use Illuminate\Database\Seeder;
use Pandawa\Component\Ddd\Repository\EntityManagerInterface;
use Pandawa\Component\Ddd\Repository\RepositoryInterface;
use Weather\User\Model\User;
use function Pandawa\Reactive\fromArray;
use function Pandawa\Reactive\map;
use function Pandawa\Reactive\tap;

final class UsersTableSeeder extends Seeder
{
    private $data = [
        [
            'id'           => 'e3e3c309-b4c2-49ea-8faf-84bee751542b',
            'email'        => 'komala.surya.w@gmail.com',
            'username'     => 'komalasurya',
            'password'     => 'secret',
        ],
    ];

    public function run(): void
    {
        fromArray($this->data)->pipe(
            map(function (array $params) {
                return new User($params);
            }),
            tap(function (User $user) {
                $this->userRepo()->save($user);
            })
        )->subscribe();
    }

    /**
     * @return RepositoryInterface
     */
    private function userRepo(): RepositoryInterface
    {
        return app(EntityManagerInterface::class)->getRepository(User::class);
    }
}