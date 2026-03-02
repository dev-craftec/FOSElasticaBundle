<?php

/*
 * This file is part of the FOSElasticaBundle package.
 *
 * (c) FriendsOfSymfony <https://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\ElasticaBundle\Event;

use FOS\ElasticaBundle\Configuration\IndexConfigInterface;

/**
 * @phpstan-import-type TMapping from IndexConfigInterface
 */
final class PostIndexMappingBuildEvent extends AbstractIndexEvent
{
    /**
     * @param TMapping $mapping
     */
    public function __construct(
        private readonly IndexConfigInterface $indexConfig,
        private array $mapping,
    ) {
        parent::__construct($this->indexConfig->getName());
    }

    public function getIndexConfig(): IndexConfigInterface
    {
        return $this->indexConfig;
    }

    /**
     * @return TMapping
     */
    public function getMapping(): array
    {
        return $this->mapping;
    }

    /**
     * @param TMapping $mapping
     */
    public function setMapping(array $mapping): void
    {
        $this->mapping = $mapping;
    }
}
