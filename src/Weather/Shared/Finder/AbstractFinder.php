<?php
declare(strict_types=1);

namespace Shared\Finder;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;
use Pandawa\Component\Ddd\AbstractModel;
use Pandawa\Component\Ddd\Repository\EntityManagerInterface;
use Pandawa\Component\Ddd\Repository\RepositoryInterface;
use ReflectionClass;
use ReflectionException;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
abstract class AbstractFinder
{
    /**
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * @param string $id
     * @param int|null $lock
     * @return mixed|AbstractModel|null
     * @throws ReflectionException
     */
    public function findOrFail(string $id, int $lock = null)
    {
        if (null !== $model = $this->repository()->find($id, $lock)) {
            return $model;
        }

        $class = new ReflectionClass($this->modelClass());

        throw new ModelNotFoundException(
            __(
                ':name with id :id is not found.',
                [
                    'name' => Str::kebab($class->getShortName()),
                    'id'   => $id,
                ]
            )
        );
    }

    /**
     * @param string|null $id
     * @param array       $params
     *
     * @return mixed|AbstractModel|null
     */
    public function findOrCreate(?string $id, array $params)
    {
        return $this->findOneByOrCreate($id ? ['id' => $id] : null, $params);
    }

    /**
     * @param array|null $criteria
     * @param array      $params
     *
     * @return mixed|AbstractModel|null
     */
    public function findOneByOrCreate(?array $criteria, array $params)
    {
        if (null !== $criteria) {
            if (null !== $model = $this->repository()->findOneBy($criteria)) {
                return $model;
            }
        }

        $class = $this->modelClass();

        return new $class($params);
    }

    /**
     * @return RepositoryInterface
     */
    protected function repository(): RepositoryInterface
    {
        if (null === $this->repository) {
            $this->repository = $this->entityManager()->getRepository($this->modelClass());
        }

        return $this->repository;
    }

    abstract protected function modelClass(): string;

    /**
     * @return EntityManagerInterface
     */
    private function entityManager(): EntityManagerInterface
    {
        return app(EntityManagerInterface::class);
    }
}
