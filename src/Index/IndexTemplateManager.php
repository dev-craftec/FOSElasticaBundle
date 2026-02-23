<?php

/*
 * This file is part of the FOSElasticaBundle package.
 *
 * (c) FriendsOfSymfony <https://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\ElasticaBundle\Index;

use Elastica\IndexTemplate;

/**
 * @author Dmitry Balabka <dmitry.balabka@intexsys.lv>
 */
class IndexTemplateManager
{
    /**
     * @var array<string, IndexTemplate>
     */
    private array $templates;

    /**
     * @param array<string, IndexTemplate> $templates
     */
    public function __construct(array $templates)
    {
        $this->templates = $templates;
    }

    /**
     * Gets an index template by its name.
     *
     * @param string $name Index template to return
     *
     * @throws \InvalidArgumentException if no index template exists for the given name
     */
    public function getIndexTemplate(string $name): IndexTemplate
    {
        if (!isset($this->templates[$name])) {
            throw new \InvalidArgumentException(\sprintf('The index template "%s" does not exist', $name));
        }

        return $this->templates[$name];
    }
}
