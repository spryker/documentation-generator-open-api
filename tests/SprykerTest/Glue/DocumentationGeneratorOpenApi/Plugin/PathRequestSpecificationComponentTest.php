<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Glue\DocumentationGeneratorOpenApi\Plugin;

use Codeception\Test\Unit;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Component\PathRequestSpecificationComponent;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Glue
 * @group DocumentationGeneratorOpenApi
 * @group Plugin
 * @group PathRequestSpecificationComponentTest
 * Add your own group annotations below this line
 */
class PathRequestSpecificationComponentTest extends Unit
{
    protected const SCHEMA_REFERENCE = '#/components/schemas/TestRequest';

    protected const KEY_CONTENT = 'content';

    protected const KEY_DESCRIPTION = 'description';

    protected const KEY_REQUIRED = 'required';

    public function testReturnsDescriptionKey(): void
    {
        $component = new PathRequestSpecificationComponent();

        $result = $component->getSpecificationComponentData([], static::SCHEMA_REFERENCE);

        $this->assertArrayHasKey(static::KEY_DESCRIPTION, $result, 'Expected description key to be present.');
    }

    public function testReturnsRequiredTrue(): void
    {
        $component = new PathRequestSpecificationComponent();

        $result = $component->getSpecificationComponentData([], static::SCHEMA_REFERENCE);

        $this->assertArrayHasKey(static::KEY_REQUIRED, $result, 'Expected required key to be present.');
        $this->assertTrue($result[static::KEY_REQUIRED], 'Expected required to be true.');
    }

    public function testReturnsContentWithSchemaReference(): void
    {
        $component = new PathRequestSpecificationComponent();

        $result = $component->getSpecificationComponentData([], static::SCHEMA_REFERENCE);

        $this->assertArrayHasKey(static::KEY_CONTENT, $result, 'Expected content key to be present.');
        $this->assertSame(
            static::SCHEMA_REFERENCE,
            $result[static::KEY_CONTENT]['application/json']['schema']['$ref'],
            'Expected schema reference to match.',
        );
    }

    public function testPathMethodDataIsNotMutatedIntoOutput(): void
    {
        $component = new PathRequestSpecificationComponent();

        $pathMethodData = ['someExistingKey' => 'someValue'];
        $result = $component->getSpecificationComponentData($pathMethodData, static::SCHEMA_REFERENCE);

        $this->assertArrayNotHasKey('someExistingKey', $result, 'Expected path method data not to be merged into output.');
    }
}
