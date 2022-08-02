<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Component;

interface PathParameterSpecificationComponentInterface
{
    /**
     * @param array<mixed> $pathMethodData
     * @param string $pathName
     *
     * @return array<mixed>
     */
    public function getSpecificationComponentData(array $pathMethodData, string $pathName): array;
}
