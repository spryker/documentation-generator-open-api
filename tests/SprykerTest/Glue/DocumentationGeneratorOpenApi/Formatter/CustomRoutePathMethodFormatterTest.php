<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Glue\DocumentationGeneratorOpenApi\Formatter;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\AnnotationTransfer;
use Generated\Shared\Transfer\CustomRoutesContextTransfer;
use Generated\Shared\Transfer\PathAnnotationTransfer;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Paths\OpenApiSpecificationPathMethodFormatterInterface;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Processor\CustomRoutePathMethodFormatter;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Glue
 * @group DocumentationGeneratorOpenApi
 * @group Formatter
 * @group CustomRoutePathMethodFormatterTest
 * Add your own group annotations below this line
 */
class CustomRoutePathMethodFormatterTest extends Unit
{
    public function testFormatSkipsCustomRouteWithoutResponseAttributesClassName(): void
    {
        // Arrange
        $pathMethodFormatterMock = $this->createMock(OpenApiSpecificationPathMethodFormatterInterface::class);
        $pathMethodFormatterMock->expects($this->never())->method('getPathMethodComponentData');
        $pathMethodFormatterMock->expects($this->never())->method('addPath');

        $customRoutesContextTransfer = (new CustomRoutesContextTransfer())
            ->setPath('/dynamic-entity/{resourceName}')
            ->setDefaults(['_controller' => ['Some\Controller', 'getAction'], '_method' => 'GET'])
            ->setPathAnnotation(
                (new PathAnnotationTransfer())->setGetResourceById((new AnnotationTransfer())->setSummary(['Creates dynamic entities.'])),
            );
        $formattedData = ['paths' => []];

        // Act
        $result = (new CustomRoutePathMethodFormatter($pathMethodFormatterMock))->format($customRoutesContextTransfer, $formattedData);

        // Assert
        $this->assertSame($formattedData, $result);
    }

    public function testFormatSkipsUppercaseMethodCustomRouteWithoutResponseAttributesClassName(): void
    {
        // Arrange
        $pathMethodFormatterMock = $this->createMock(OpenApiSpecificationPathMethodFormatterInterface::class);
        $pathMethodFormatterMock->expects($this->never())->method('getPathMethodComponentData');

        $customRoutesContextTransfer = (new CustomRoutesContextTransfer())
            ->setPath('/dynamic-entity/{resourceName}')
            ->setDefaults(['_controller' => ['Some\Controller', 'postAction'], '_method' => 'POST'])
            ->setPathAnnotation(
                (new PathAnnotationTransfer())->setPost((new AnnotationTransfer())->setSummary(['Creates dynamic entities.'])),
            );
        $formattedData = ['paths' => []];

        // Act
        $result = (new CustomRoutePathMethodFormatter($pathMethodFormatterMock))->format($customRoutesContextTransfer, $formattedData);

        // Assert
        $this->assertSame($formattedData, $result);
    }

    public function testFormatSkipsCustomRouteWithoutAnnotationForRequestMethod(): void
    {
        // Arrange
        $pathMethodFormatterMock = $this->createMock(OpenApiSpecificationPathMethodFormatterInterface::class);
        $pathMethodFormatterMock->expects($this->never())->method('getPathMethodComponentData');

        $customRoutesContextTransfer = (new CustomRoutesContextTransfer())
            ->setPath('/dynamic-entity/{resourceName}')
            ->setDefaults(['_controller' => ['Some\Controller', 'putAction'], '_method' => 'PUT'])
            ->setPathAnnotation(
                (new PathAnnotationTransfer())->setPost((new AnnotationTransfer())->setSummary(['Creates dynamic entities.'])),
            );
        $formattedData = ['paths' => []];

        // Act
        $result = (new CustomRoutePathMethodFormatter($pathMethodFormatterMock))->format($customRoutesContextTransfer, $formattedData);

        // Assert
        $this->assertSame($formattedData, $result);
    }

    public function testFormatDocumentsGetCollectionCustomRouteWithResponseAttributesClassName(): void
    {
        // Arrange
        $pathMethodFormatterMock = $this->createMock(OpenApiSpecificationPathMethodFormatterInterface::class);
        $pathMethodFormatterMock->expects($this->once())
            ->method('getPathMethodComponentData')
            ->willReturn(['summary' => 'Get foos.']);
        $pathMethodFormatterMock->expects($this->once())
            ->method('addPath')
            ->willReturn(['paths' => ['/foos' => ['get' => []]]]);

        $customRoutesContextTransfer = (new CustomRoutesContextTransfer())
            ->setPath('/foos')
            ->setDefaults(['_controller' => ['Some\Controller', 'getCollectionAction'], '_method' => 'getCollection'])
            ->setPathAnnotation(
                (new PathAnnotationTransfer())->setGetCollection(
                    (new AnnotationTransfer())->setResponseAttributesClassName('Generated\Shared\Transfer\FoosRestAttributesTransfer'),
                ),
            );

        // Act
        $result = (new CustomRoutePathMethodFormatter($pathMethodFormatterMock))->format($customRoutesContextTransfer, ['paths' => []]);

        // Assert
        $this->assertArrayHasKey('/foos', $result['paths']);
    }
}
