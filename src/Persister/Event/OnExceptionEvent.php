<?php

/*
 * This file is part of the FOSElasticaBundle package.
 *
 * (c) FriendsOfSymfony <https://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\ElasticaBundle\Persister\Event;

use FOS\ElasticaBundle\Persister\ObjectPersisterInterface;
use FOS\ElasticaBundle\Provider\PagerInterface;
use Symfony\Contracts\EventDispatcher\Event;

final class OnExceptionEvent extends Event implements PersistEvent
{
    private PagerInterface $pager;

    private ObjectPersisterInterface $objectPersister;

    private \Exception $exception;

    /**
     * @var array<string, mixed>
     */
    private array $options;

    /**
     * @var list<object>
     */
    private array $objects;

    private bool $ignored = false;

    /**
     * @param list<object>         $objects
     * @param array<string, mixed> $options
     */
    public function __construct(
        PagerInterface $pager,
        ObjectPersisterInterface $objectPersister,
        \Exception $exception,
        array $objects,
        array $options,
    ) {
        $this->pager = $pager;
        $this->objectPersister = $objectPersister;
        $this->exception = $exception;
        $this->options = $options;
        $this->objects = $objects;
    }

    public function getPager(): PagerInterface
    {
        return $this->pager;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getObjectPersister(): ObjectPersisterInterface
    {
        return $this->objectPersister;
    }

    public function getException(): \Exception
    {
        return $this->exception;
    }

    public function setException(\Exception $exception): void
    {
        $this->exception = $exception;
    }

    public function isIgnored(): bool
    {
        return $this->ignored;
    }

    public function setIgnored(bool $ignored): void
    {
        $this->ignored = $ignored;
    }

    /**
     * @return list<object>
     */
    public function getObjects(): array
    {
        return $this->objects;
    }
}
