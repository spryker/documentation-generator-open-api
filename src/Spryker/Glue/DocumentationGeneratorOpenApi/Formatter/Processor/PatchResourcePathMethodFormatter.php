<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Processor;

use Generated\Shared\Transfer\PathAnnotationTransfer;
use Generated\Shared\Transfer\PathMethodComponentDataTransfer;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Paths\OpenApiSpecificationPathMethodFormatterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PatchResourcePathMethodFormatter implements PathMethodFormatterInterface
{
    /**
     * @var string
     */
    protected const PATTERN_OPERATION_ID_PATCH_RESOURCE = 'update-%s';

    /**
     * @var string
     */
    protected const PATTERN_SUMMARY_PATCH_RESOURCE = 'Update %s.';

    /**
     * @var \Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Paths\OpenApiSpecificationPathMethodFormatterInterface
     */
    protected $openApiSpecificationPathMethodFormatter;

    /**
     * @param \Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Paths\OpenApiSpecificationPathMethodFormatterInterface $openApiSpecificationPathMethodFormatter
     */
    public function __construct(OpenApiSpecificationPathMethodFormatterInterface $openApiSpecificationPathMethodFormatter)
    {
        $this->openApiSpecificationPathMethodFormatter = $openApiSpecificationPathMethodFormatter;
    }

    /**
     * @param \Generated\Shared\Transfer\PathAnnotationTransfer $pathAnnotationTransfer
     * @param array<mixed> $formattedData
     *
     * @return array<mixed>
     */
    public function format(PathAnnotationTransfer $pathAnnotationTransfer, array $formattedData): array
    {
        if (!$pathAnnotationTransfer->getPatch()) {
            return $formattedData;
        }

        $resourceType = $pathAnnotationTransfer->getResourceTypeOrFail();
        $pathName = $this->openApiSpecificationPathMethodFormatter->getPathFromResourceType($resourceType);

        $pathMethodComponentDataTransfer = (new PathMethodComponentDataTransfer())
            ->setResourceType($resourceType)
            ->setAnnotation($pathAnnotationTransfer->getGetResourceById())
            ->setPatternOperationIdResource(static::PATTERN_OPERATION_ID_PATCH_RESOURCE)
            ->setDefaultResponseCode(Response::HTTP_OK)
            ->setIsGetCollection(false)
            ->setPathName($pathName);

        $pathMethodData = $this->openApiSpecificationPathMethodFormatter->getPathMethodComponentData(
            $pathMethodComponentDataTransfer,
        );

        if (!$pathMethodData['summary']) {
            $pathMethodData['summary'] = $this->openApiSpecificationPathMethodFormatter
                ->getDefaultMethodSummary(static::PATTERN_SUMMARY_PATCH_RESOURCE, $resourceType);
        }

        return $this->openApiSpecificationPathMethodFormatter->addPath(
            $pathMethodData,
            $pathName,
            strtolower(Request::METHOD_PATCH),
            $formattedData,
        );
    }
}
