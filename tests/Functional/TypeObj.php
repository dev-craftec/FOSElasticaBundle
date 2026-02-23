<?php

/*
 * This file is part of the FOSElasticaBundle package.
 *
 * (c) FriendsOfSymfony <https://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\ElasticaBundle\Tests\Functional;

class TypeObj
{
    public int $id = 5;
    public mixed $coll = null;
    public mixed $field1 = null;
    public mixed $field2 = null;

    public function isIndexable(): bool
    {
        return true;
    }

    public function isntIndexable(): bool
    {
        return false;
    }
}
