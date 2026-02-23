<?php

/*
 * This file is part of the FOSElasticaBundle package.
 *
 * (c) FriendsOfSymfony <https://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\ElasticaBundle\Configuration;

/**
 * @phpstan-import-type TElasticConfig from IndexConfigInterface
 * @phpstan-import-type TMapping from IndexConfigInterface
 * @phpstan-import-type TDynamicDateFormats from IndexConfigInterface
 * @phpstan-import-type TDynamic from IndexConfigInterface
 */
class TypeConfig
{
    /**
     * @var TElasticConfig
     */
    private array $config;

    /**
     * @var TMapping
     */
    private array $mapping;

    private string $name;

    /**
     * @param TMapping       $mapping
     * @param TElasticConfig $config
     */
    public function __construct(string $name, array $mapping, array $config = [])
    {
        $this->config = $config;
        $this->mapping = $mapping;
        $this->name = $name;
    }

    public function getDateDetection(): ?bool
    {
        return $this->config['date_detection'] ?? null;
    }

    /**
     * @return ?TDynamicDateFormats
     */
    public function getDynamicDateFormats(): ?array
    {
        return $this->config['dynamic_date_formats'] ?? null;
    }

    public function getAnalyzer(): ?string
    {
        return $this->config['analyzer'] ?? null;
    }

    /**
     * @return TMapping
     */
    public function getMapping(): array
    {
        return $this->mapping;
    }

    public function getNumericDetection(): ?bool
    {
        return $this->config['numeric_detection'] ?? null;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return ?TDynamic
     */
    public function getDynamic(): string|bool|null
    {
        return $this->config['dynamic'] ?? null;
    }
}
