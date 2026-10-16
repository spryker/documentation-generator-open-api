<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Glue\DocumentationGeneratorOpenApi\Formatter;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\AnnotationTransfer;
use Generated\Shared\Transfer\ApiApplicationSchemaContextTransfer;
use Generated\Shared\Transfer\CustomRoutesContextTransfer;
use Generated\Shared\Transfer\PathAnnotationTransfer;
use Spryker\Glue\DocumentationGeneratorOpenApi\DocumentationGeneratorOpenApiFactory;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Glue
 * @group DocumentationGeneratorOpenApi
 * @group Formatter
 * @group OpenApiSchemasFormatterTest
 * Add your own group annotations below this line
 */
class OpenApiSchemasFormatterTest extends Unit
{
    public function testFormatSkipsCustomRouteAnnotationsWithoutResponseAttributesClassName(): void
    {
        // Arrange
        $annotationTransfer = (new AnnotationTransfer())->setSummary(['Retrieves dynamic entities.']);
        $customRoutesContextTransfer = (new CustomRoutesContextTransfer())
            ->setPath('/dynamic-entity/{resourceName}')
            ->setDefaults(['_controller' => ['Some\Controller', 'getCollectionAction'], '_method' => 'GET'])
            ->setPathAnnotation(
                (new PathAnnotationTransfer())
                    ->setGetCollection($annotationTransfer)
                    ->setGetResourceById($annotationTransfer)
                    ->setPost($annotationTransfer)
                    ->setPatch($annotationTransfer)
                    ->setDelete($annotationTransfer),
            );
        $apiApplicationSchemaContextTransfer = (new ApiApplicationSchemaContextTransfer())
            ->addCustomRoutesContext($customRoutesContextTransfer);
        $factory = new DocumentationGeneratorOpenApiFactory();
        $expectedSchemas = $factory->createOpenApiSchemasFormatter()
            ->format([], new ApiApplicationSchemaContextTransfer())['components']['schemas'];

        // Act
        $formattedData = $factory->createOpenApiSchemasFormatter()->format([], $apiApplicationSchemaContextTransfer);

        // Assert
        $this->assertSame($expectedSchemas, $formattedData['components']['schemas']);
    }
}
