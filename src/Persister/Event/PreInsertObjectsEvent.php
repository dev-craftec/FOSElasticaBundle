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

final class PreInsertObjectsEvent extends Event implements PersistEvent
{
    private PagerInterface $pager;

    private ObjectPersisterInterface $objectPersister;

    /**
     * @var list<object>
     */
    private array $objects;

    /**
     * @var array<string, mixed>
     */
    private array $options;

    private int $filteredObjectCount = 0;

    /**
     * @param list<object>         $objects
     * @param array<string, mixed> $options
     */
    public function __construct(PagerInterface $pager, ObjectPersisterInterface $objectPersister, array $objects, array $options)
    {
        $this->pager = $pager;
        $this->objectPersister = $objectPersister;
        $this->objects = $objects;
        $this->options = $options;
    }

    public function getPager(): PagerInterface
    {
        return $this->pager;
    }

    public function setPager(PagerInterface $pager): void
    {
        $this->pager = $pager;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array<string, mixed> $options
     */
    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    public function getObjectPersister(): ObjectPersisterInterface
    {
        return $this->objectPersister;
    }

    public function setObjectPersister(ObjectPersisterInterface $objectPersister): void
    {
        $this->objectPersister = $objectPersister;
    }

    /**
     * @return list<object>
     */
    public function getObjects(): array
    {
        return $this->objects;
    }

    /**
     * @param list<object> $objects
     */
    public function setObjects(array $objects): void
    {
        $this->objects = $objects;
    }

    /**
     * @internal
     */
    public function setFilteredObjectCount(int $count): void
    {
        $this->filteredObjectCount = $count;
    }

    public function getFilteredObjectCount(): int
    {
        return $this->filteredObjectCount;
    }
}
