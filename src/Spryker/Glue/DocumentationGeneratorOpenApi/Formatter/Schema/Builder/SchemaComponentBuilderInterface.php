<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Schema\Builder;

use Generated\Shared\Transfer\SchemaDataTransfer;
use Generated\Shared\Transfer\SchemaItemsTransfer;
use Generated\Shared\Transfer\SchemaPropertyTransfer;

interface SchemaComponentBuilderInterface
{
    /**
     * @param string $key
     * @param string $schemaName
     * @param array<mixed> $objectMetadata
     *
     * @return \Generated\Shared\Transfer\SchemaPropertyTransfer
     */
    public function createObjectSchemaTypeTransfer(string $key, string $schemaName, array $objectMetadata): SchemaPropertyTransfer;

    public function createScalarSchemaTypeTransfer(string $key, string $type, bool $isNullable = false): SchemaPropertyTransfer;

    public function createSchemaDataTransfer(string $name): SchemaDataTransfer;

    public function createTypePropertyTransfer(string $name, string $type, bool $isNullable = false): SchemaPropertyTransfer;

    public function createReferencePropertyTransfer(string $name, string $ref, bool $isNullable = false): SchemaPropertyTransfer;

    public function createArrayOfObjectsPropertyTransfer(string $name, string $itemsRef, bool $isNullable = false): SchemaPropertyTransfer;

    public function createArrayOfTypesPropertyTransfer(string $name, string $itemsType, bool $isNullable = false): SchemaPropertyTransfer;

    public function createArrayOfMixedTypesPropertyTransfer(string $name, bool $isNullable = false): SchemaPropertyTransfer;

    /**
     * @param string $metadataKey
     * @param array<mixed> $metadataValue
     *
     * @return \Generated\Shared\Transfer\SchemaPropertyTransfer
     */
    public function createResponseSchemaPropertyTransfer(string $metadataKey, array $metadataValue): SchemaPropertyTransfer;

    /**
     * @param string $metadataKey
     * @param array<mixed> $metadataValue
     *
     * @return \Generated\Shared\Transfer\SchemaPropertyTransfer
     */
    public function createRequestSchemaPropertyTransfer(string $metadataKey, array $metadataValue): SchemaPropertyTransfer;

    /**
     * @param array<string> $resourceRelationships
     *
     * @return \Generated\Shared\Transfer\SchemaItemsTransfer
     */
    public function createRelationshipSchemaItemsTransfer(array $resourceRelationships): SchemaItemsTransfer;
}
