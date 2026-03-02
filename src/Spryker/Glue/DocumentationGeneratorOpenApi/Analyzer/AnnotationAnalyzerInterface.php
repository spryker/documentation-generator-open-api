<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\DocumentationGeneratorOpenApi\Analyzer;

use Spryker\Shared\Kernel\Transfer\AbstractTransfer;

interface AnnotationAnalyzerInterface
{
    public function getResourceParametersFromResource(
        string $classPath,
        AbstractTransfer $annotationsTransfer,
        ?string $actionName
    ): ?AbstractTransfer;
}
