<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authorize as LaravelAuthorize;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Contracts\Auth\Access\Gate;
use Pandawa\Component\Message\MessageRegistryInterface;
use Pandawa\Component\Resource\ResourceRegistryInterface;
use RuntimeException;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class Authorize extends LaravelAuthorize
{
    use DispatchesJobs;

    /**
     * @var ResourceRegistryInterface
     */
    private $registry;

    /**
     * @var null|MessageRegistryInterface
     */
    private $messageRegistry;

    /**
     * Constructor.
     *
     * @param Auth                          $auth
     * @param Gate                          $gate
     * @param ResourceRegistryInterface     $registry
     * @param MessageRegistryInterface|null $messageRegistry
     */
    public function __construct(Auth $auth, Gate $gate, ResourceRegistryInterface $registry, MessageRegistryInterface $messageRegistry = null)
    {
        parent::__construct($gate);
        $this->registry = $registry;
        $this->auth = $auth;
        $this->messageRegistry = $messageRegistry;
    }

    protected function getModel($request, $model)
    {
        return $this->isClassName($model) ? $model : $this->getRouteModel($request, $model);
    }

    private function getRouteModel(Request $request, string $model)
    {
        $route = $request->route();

        if (null !== $this->messageRegistry
            && null !== $options = array_get($route->defaults, sprintf('bindings.%s', $model))) {

            $message = $this->getMessageClass(array_get($options, 'message'));
            $arguments = array_only(
                array_merge($request->all(), $route->parameters()),
                array_get($options, 'arguments', [])
            );

            return $this->dispatch(new $message($arguments));
        }

        if ($this->registry->has($model)) {
            $modelClass = $this->registry->get($model)->getModelClass();

            return $modelClass::{'findOrFail'}($request->route($model));
        }

        return $request->route($model);
    }

    /**
     * @param string $message
     *
     * @return string
     */
    private function getMessageClass(string $message): string
    {
        if (!$this->messageRegistry->has($message)) {
            throw new RuntimeException(sprintf('Message "%s" not found.', $message));
        }

        return $this->messageRegistry->get($message)->getMessageClass();
    }
}
