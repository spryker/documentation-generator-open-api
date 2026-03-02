<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Paths;

use Generated\Shared\Transfer\PathMethodComponentDataTransfer;
use Generated\Shared\Transfer\ResourceContextTransfer;

interface OpenApiSpecificationPathMethodFormatterInterface
{
    /**
     * @param \Generated\Shared\Transfer\PathMethodComponentDataTransfer $pathMethodComponentDataTransfer
     *
     * @return array<mixed>
     */
    public function getPathMethodComponentData(PathMethodComponentDataTransfer $pathMethodComponentDataTransfer): array;

    public function getDefaultMethodSummary(string $pattern, string $resourceType): string;

    /**
     * @param array<mixed> $pathMethodData
     * @param string $pathName
     * @param string $methodName
     * @param array<mixed> $formattedData
     *
     * @return array<mixed>
     */
    public function addPath(array $pathMethodData, string $pathName, string $methodName, array $formattedData): array;

    public function getPathFromResourceType(ResourceContextTransfer $resourceContextTransfer): string;
}
