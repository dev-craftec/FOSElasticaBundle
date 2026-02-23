<?php

/*
 * This file is part of the FOSElasticaBundle package.
 *
 * (c) FriendsOfSymfony <https://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\ElasticaBundle\Persister;

use Elastica\Document;
use Elastica\Exception\BulkException;
use Elastica\Index;
use FOS\ElasticaBundle\Transformer\ModelToElasticaTransformerInterface;
use Psr\Log\LoggerInterface;

/**
 * Inserts, replaces and deletes single documents in an elastica type
 * Accepts domain model objects and converts them to elastica documents.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 *
 * @phpstan-type TOptions = array<string, mixed>
 *
 * @phpstan-import-type TFields from ModelToElasticaTransformerInterface
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/docs-bulk.html for TOptions description
 */
class ObjectPersister implements ObjectPersisterInterface
{
    protected Index $index;
    protected ModelToElasticaTransformerInterface $transformer;
    /**
     * @var class-string
     */
    protected string $objectClass;
    /**
     * @var TFields
     */
    protected array $fields;
    protected ?LoggerInterface $logger;
    /**
     * @var TOptions
     */
    private array $options;

    /**
     * @param class-string $objectClass
     * @param TFields      $fields
     * @param TOptions     $options
     */
    public function __construct(Index $index, ModelToElasticaTransformerInterface $transformer, string $objectClass, array $fields, array $options = [])
    {
        $this->index = $index;
        $this->transformer = $transformer;
        $this->objectClass = $objectClass;
        $this->fields = $fields;
        $this->options = $options;
    }

    public function handlesObject(object $object): bool
    {
        return $object instanceof $this->objectClass;
    }

    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    public function insertOne(object $object): void
    {
        $this->insertMany([$object]);
    }

    public function replaceOne(object $object): void
    {
        $this->replaceMany([$object]);
    }

    public function deleteOne(object $object): void
    {
        $this->deleteMany([$object]);
    }

    public function deleteById(string $id, string|bool $routing = false): void
    {
        $this->deleteManyByIdentifiers([(string) $id], $routing);
    }

    public function insertMany(array $objects): void
    {
        $documents = [];
        foreach ($objects as $object) {
            $documents[] = $this->transformToElasticaDocument($object);
        }
        try {
            $this->index->addDocuments($documents, $this->options);
        } catch (BulkException $e) {
            $this->log($e);
        }
    }

    public function replaceMany(array $objects): void
    {
        $documents = [];
        foreach ($objects as $object) {
            $document = $this->transformToElasticaDocument($object);
            $document->setDocAsUpsert(true);
            $documents[] = $document;
        }

        try {
            $this->index->updateDocuments($documents, $this->options);
        } catch (BulkException $e) {
            $this->log($e);
        }
    }

    public function deleteMany(array $objects): void
    {
        $documents = [];
        foreach ($objects as $object) {
            $documents[] = $this->transformToElasticaDocument($object);
        }
        try {
            $this->index->deleteDocuments($documents);
        } catch (BulkException $e) {
            $this->log($e);
        }
    }

    public function deleteManyByIdentifiers(array $identifiers, string|bool $routing = false): void
    {
        try {
            $this->index->getClient()->deleteIds($identifiers, $this->index->getName(), $routing);
        } catch (BulkException $e) {
            $this->log($e);
        }
    }

    /**
     * Transforms an object to an elastica document.
     */
    public function transformToElasticaDocument(object $object): Document
    {
        return $this->transformer->transform($object, $this->fields);
    }

    /**
     * Log exception if logger defined for persister belonging to the current listener, otherwise re-throw.
     *
     * @throws BulkException
     */
    private function log(BulkException $e): void
    {
        if (!$this->logger) {
            throw $e;
        }

        $this->logger->error($e);
    }
}
