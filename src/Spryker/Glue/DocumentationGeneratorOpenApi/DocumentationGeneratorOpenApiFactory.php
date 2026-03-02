<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\DocumentationGeneratorOpenApi;

use Spryker\Glue\DocumentationGeneratorOpenApi\Analyzer\AnnotationAnalyzer;
use Spryker\Glue\DocumentationGeneratorOpenApi\Analyzer\AnnotationAnalyzerInterface;
use Spryker\Glue\DocumentationGeneratorOpenApi\Analyzer\ResourceTransferAnalyzer;
use Spryker\Glue\DocumentationGeneratorOpenApi\Analyzer\ResourceTransferAnalyzerInterface;
use Spryker\Glue\DocumentationGeneratorOpenApi\Dependency\External\DocumentationGeneratorOpenApiToFinderInterface;
use Spryker\Glue\DocumentationGeneratorOpenApi\Dependency\External\DocumentationGeneratorOpenApiToInflectorInterface;
use Spryker\Glue\DocumentationGeneratorOpenApi\Dependency\External\DocumentationGeneratorOpenApiToOpenApiAdapter;
use Spryker\Glue\DocumentationGeneratorOpenApi\Dependency\Service\DocumentationGeneratorOpenApiToUtilEncodingServiceInterface;
use Spryker\Glue\DocumentationGeneratorOpenApi\Expander\ContextExpanderInterface;
use Spryker\Glue\DocumentationGeneratorOpenApi\Expander\ControllerAnnotationsContextExpander;
use Spryker\Glue\DocumentationGeneratorOpenApi\Expander\CustomRouteControllerAnnotationsContextExpander;
use Spryker\Glue\DocumentationGeneratorOpenApi\Expander\RelationshipPluginAnnotationsContextExpander;
use Spryker\Glue\DocumentationGeneratorOpenApi\Finder\FinderInterface;
use Spryker\Glue\DocumentationGeneratorOpenApi\Finder\GlueFileFinder;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Component\PathParameterSpecificationComponent;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Component\PathParameterSpecificationComponentInterface;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Component\PathRequestSpecificationComponent;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Component\PathRequestSpecificationComponentInterface;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Component\PathResponseSpecificationComponent;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Component\PathResponseSpecificationComponentInterface;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\OpenApiGeneralSchemaFormatter;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\OpenApiParametersFormatter;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\OpenApiSchemaFormatterCollection;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\OpenApiSchemaFormatterInterface;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\OpenApiSchemaFormatterInterface as FormatterOpenApiGeneralSchemaFormatterInterface;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\OpenApiSchemasFormatter;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\OpenApiSecuritySchemesFormatter;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\OpenApiSpecificationPathFormatter;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\OpenApiTagGenerator;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Paths\OpenApiSpecificationPathMethodFormatter;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Paths\OpenApiSpecificationPathMethodFormatterInterface;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Processor\CustomRoutePathMethodFormatter;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Processor\DeleteResourcePathMethodFormatter;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Processor\GetCollectionResourcePathMethodFormatter;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Processor\GetResourceByIdPathMethodFormatter;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Processor\PatchResourcePathMethodFormatter;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Processor\PathMethodFormatterInterface;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Processor\PostResourcePathMethodFormatter;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Schema\Builder\OpenApiSpecificationSchemaBuilder;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Schema\Builder\OpenApiSpecificationSchemaComponentBuilder;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Schema\Builder\SchemaBuilderInterface;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Schema\Builder\SchemaComponentBuilderInterface;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Schema\Processor\ResourceRelationshipProcessor;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Schema\Processor\ResourceRelationshipProcessorInterface;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Schema\Renderer\Component\ParameterSpecificationComponent;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Schema\Renderer\Component\ParameterSpecificationComponentInterface;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Schema\Renderer\Component\SchemaItemsSpecificationComponent;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Schema\Renderer\Component\SchemaItemsSpecificationComponentInterface;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Schema\Renderer\Component\SchemaPropertySpecificationComponent;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Schema\Renderer\Component\SchemaPropertySpecificationComponentInterface;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Schema\Renderer\Component\SchemaSpecificationComponent;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Schema\Renderer\Component\SchemaSpecificationComponentInterface;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Schema\Renderer\ParameterRenderer;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Schema\Renderer\ParameterRendererInterface;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Schema\Renderer\SchemaRenderer;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Schema\Renderer\SchemaRendererInterface;
use Spryker\Glue\DocumentationGeneratorOpenApi\Generator\DocumentationContentGeneratorInterface;
use Spryker\Glue\Kernel\AbstractFactory;

/**
 * @method \Spryker\Glue\DocumentationGeneratorOpenApi\DocumentationGeneratorOpenApiConfig getConfig()
 */
class DocumentationGeneratorOpenApiFactory extends AbstractFactory
{
    public function createSchemaFormatterCollection(): OpenApiSchemaFormatterInterface
    {
        return new OpenApiSchemaFormatterCollection(
            [
                $this->createOpenApiGeneralSchemaFormatter(),
                $this->createOpenApiSpecificationPathFormatter(),
                $this->createOpenApiTagGenerator(),
                $this->createOpenApiSecuritySchemesFormatter(),
                $this->createOpenApiSchemasFormatter(),
                $this->createOpenApiParametersFormatter(),
            ],
        );
    }

    public function createOpenApiSpecificationPathFormatter(): OpenApiSpecificationPathFormatter
    {
        return new OpenApiSpecificationPathFormatter(
            $this->getResourcePathMethodFormatters(),
            $this->getCustomRoutesPathMethodFormatters(),
            $this->getOpenApiSchemaFormatterPlugins(),
        );
    }

    /**
     * @return array<\Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Processor\PathMethodFormatterInterface>
     */
    public function getResourcePathMethodFormatters(): array
    {
        return [
            $this->createGetResourceByIdPathMethodFormatter(),
            $this->createGetCollectionResourcePathMethodFormatter(),
            $this->createPostResourcePathMethodFormatter(),
            $this->createPatchResourcePathMethodFormatter(),
            $this->createDeleteResourcePathMethodFormatter(),
        ];
    }

    /**
     * @return array<\Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Processor\CustomPathMethodFormatterInterface>
     */
    public function getCustomRoutesPathMethodFormatters(): array
    {
        return [
            $this->createCustomRoutesPathMethodFormatter(),
        ];
    }

    /**
     * @return array<\Spryker\Glue\DocumentationGeneratorOpenApiExtension\Dependency\Plugin\OpenApiSchemaFormatterPluginInterface>
     */
    public function getOpenApiSchemaFormatterPlugins(): array
    {
        return $this->getProvidedDependency(DocumentationGeneratorOpenApiDependencyProvider::PLUGINS_OPEN_API_SCHEMA_FORMATTER);
    }

    public function createDocumentationContentGenerator(): DocumentationContentGeneratorInterface
    {
        return new DocumentationGeneratorOpenApiToOpenApiAdapter();
    }

    public function createOpenApiGeneralSchemaFormatter(): FormatterOpenApiGeneralSchemaFormatterInterface
    {
        return new OpenApiGeneralSchemaFormatter(
            $this->getConfig(),
        );
    }

    public function createOpenApiSecuritySchemesFormatter(): OpenApiSchemaFormatterInterface
    {
        return new OpenApiSecuritySchemesFormatter();
    }

    public function createOpenApiSchemasFormatter(): OpenApiSchemaFormatterInterface
    {
        return new OpenApiSchemasFormatter(
            $this->createResourceTransferAnalyzer(),
            $this->createOpenApiSpecificationSchemaBuilder(),
            $this->createSchemaRenderer(),
            $this->createResourceRelationshipProcessor(),
        );
    }

    public function createOpenApiParametersFormatter(): OpenApiSchemaFormatterInterface
    {
        return new OpenApiParametersFormatter(
            $this->createParameterRenderer(),
        );
    }

    public function createParameterRenderer(): ParameterRendererInterface
    {
        return new ParameterRenderer(
            $this->createParameterSpecificationComponent(),
        );
    }

    public function createParameterSpecificationComponent(): ParameterSpecificationComponentInterface
    {
        return new ParameterSpecificationComponent();
    }

    public function createResourceRelationshipProcessor(): ResourceRelationshipProcessorInterface
    {
        return new ResourceRelationshipProcessor(
            $this->createResourceTransferAnalyzer(),
            $this->createOpenApiSpecificationSchemaBuilder(),
        );
    }

    public function createOpenApiSpecificationSchemaBuilder(): SchemaBuilderInterface
    {
        return new OpenApiSpecificationSchemaBuilder($this->createOpenApiSpecificationSchemaComponentBuilder());
    }

    public function createOpenApiSpecificationSchemaComponentBuilder(): SchemaComponentBuilderInterface
    {
        return new OpenApiSpecificationSchemaComponentBuilder(
            $this->createResourceTransferAnalyzer(),
        );
    }

    public function createSchemaRenderer(): SchemaRendererInterface
    {
        return new SchemaRenderer(
            $this->createSchemaSpecificationComponent(),
            $this->createSchemaPropertySpecificationComponent(),
            $this->createSchemaItemsSpecificationComponent(),
        );
    }

    public function createSchemaPropertySpecificationComponent(): SchemaPropertySpecificationComponentInterface
    {
        return new SchemaPropertySpecificationComponent();
    }

    public function createSchemaItemsSpecificationComponent(): SchemaItemsSpecificationComponentInterface
    {
        return new SchemaItemsSpecificationComponent();
    }

    public function createSchemaSpecificationComponent(): SchemaSpecificationComponentInterface
    {
        return new SchemaSpecificationComponent();
    }

    public function createOpenApiTagGenerator(): OpenApiSchemaFormatterInterface
    {
        return new OpenApiTagGenerator();
    }

    public function createOpenApiPathMethodFormatter(): OpenApiSpecificationPathMethodFormatterInterface
    {
        return new OpenApiSpecificationPathMethodFormatter(
            $this->createResourceTransferAnalyzer(),
            $this->getInflector(),
            $this->createPathResponseSpecificationComponent(),
            $this->createPathRequestSpecificationComponent(),
            $this->createPathParameterSpecificationComponent(),
        );
    }

    public function createPostResourcePathMethodFormatter(): PathMethodFormatterInterface
    {
        return new PostResourcePathMethodFormatter(
            $this->createOpenApiPathMethodFormatter(),
        );
    }

    public function createCustomRoutesPathMethodFormatter(): CustomRoutePathMethodFormatter
    {
        return new CustomRoutePathMethodFormatter(
            $this->createOpenApiPathMethodFormatter(),
        );
    }

    public function createGetResourceByIdPathMethodFormatter(): PathMethodFormatterInterface
    {
        return new GetResourceByIdPathMethodFormatter(
            $this->createOpenApiPathMethodFormatter(),
        );
    }

    public function createGetCollectionResourcePathMethodFormatter(): PathMethodFormatterInterface
    {
        return new GetCollectionResourcePathMethodFormatter(
            $this->createOpenApiPathMethodFormatter(),
        );
    }

    public function createPatchResourcePathMethodFormatter(): PathMethodFormatterInterface
    {
        return new PatchResourcePathMethodFormatter(
            $this->createOpenApiPathMethodFormatter(),
        );
    }

    public function createDeleteResourcePathMethodFormatter(): PathMethodFormatterInterface
    {
        return new DeleteResourcePathMethodFormatter(
            $this->createOpenApiPathMethodFormatter(),
        );
    }

    public function createPathRequestSpecificationComponent(): PathRequestSpecificationComponentInterface
    {
        return new PathRequestSpecificationComponent();
    }

    public function createPathParameterSpecificationComponent(): PathParameterSpecificationComponentInterface
    {
        return new PathParameterSpecificationComponent();
    }

    public function createPathResponseSpecificationComponent(): PathResponseSpecificationComponentInterface
    {
        return new PathResponseSpecificationComponent();
    }

    public function createResourceTransferAnalyzer(): ResourceTransferAnalyzerInterface
    {
        return new ResourceTransferAnalyzer();
    }

    public function createAnnotationAnalyzer(): AnnotationAnalyzerInterface
    {
        return new AnnotationAnalyzer(
            $this->createGlueFileFinder(),
            $this->getUtilEncodingService(),
        );
    }

    public function createGlueFileFinder(): FinderInterface
    {
        return new GlueFileFinder(
            $this->getFinder(),
            $this->getConfig(),
        );
    }

    public function getFinder(): DocumentationGeneratorOpenApiToFinderInterface
    {
        return $this->getProvidedDependency(DocumentationGeneratorOpenApiDependencyProvider::FINDER);
    }

    public function getUtilEncodingService(): DocumentationGeneratorOpenApiToUtilEncodingServiceInterface
    {
        return $this->getProvidedDependency(DocumentationGeneratorOpenApiDependencyProvider::SERVICE_UTIL_ENCODING);
    }

    public function createControllerAnnotationsContextExpander(): ContextExpanderInterface
    {
        return new ControllerAnnotationsContextExpander($this->createAnnotationAnalyzer());
    }

    public function createRelationshipPluginAnnotationsContextExpander(): ContextExpanderInterface
    {
        return new RelationshipPluginAnnotationsContextExpander($this->createAnnotationAnalyzer());
    }

    public function getInflector(): DocumentationGeneratorOpenApiToInflectorInterface
    {
        return $this->getProvidedDependency(DocumentationGeneratorOpenApiDependencyProvider::INFLECTOR);
    }

    public function createCustomRouteControllerAnnotationsContextExpander(): ContextExpanderInterface
    {
        return new CustomRouteControllerAnnotationsContextExpander($this->createAnnotationAnalyzer());
    }
}
