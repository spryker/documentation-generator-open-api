<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Glue\DocumentationGeneratorOpenApi\Plugin;

use Codeception\Test\Unit;
use Spryker\Glue\DocumentationGeneratorOpenApi\Formatter\Component\PathResponseSpecificationComponent;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Glue
 * @group DocumentationGeneratorOpenApi
 * @group Plugin
 * @group PathResponseSpecificationComponentTest
 * Add your own group annotations below this line
 */
class PathResponseSpecificationComponentTest extends Unit
{
    protected const SCHEMA_REFERENCE = '#/components/schemas/Test';

    protected const KEY_CONTENT = 'content';

    protected const KEY_DEFAULT_RESPONSE_CODE = 'defaultResponseCode';

    protected const KEY_RESPONSES = 'responses';

    public function testDoesNotAddDefaultSuccessCodeWhenAnnotationAlreadyDefines2xxResponse(): void
    {
        $component = new PathResponseSpecificationComponent();

        $pathMethodData = [
            static::KEY_DEFAULT_RESPONSE_CODE => Response::HTTP_CREATED,
            static::KEY_RESPONSES => [
                '204' => 'No content.',
                '400' => 'Bad Request.',
                '403' => 'Forbidden.',
            ],
        ];

        $result = $component->getSpecificationComponentData($pathMethodData, static::SCHEMA_REFERENCE);

        $this->assertArrayHasKey('204', $result, 'Expected 204 response to be present.');
        $this->assertArrayNotHasKey('201', $result, 'Expected 201 not to be added when 204 is already defined.');
    }

    public function testNoContentResponseDoesNotHaveContentBlock(): void
    {
        $component = new PathResponseSpecificationComponent();

        $pathMethodData = [
            static::KEY_DEFAULT_RESPONSE_CODE => Response::HTTP_CREATED,
            static::KEY_RESPONSES => [
                '204' => 'No content.',
                '400' => 'Bad Request.',
            ],
        ];

        $result = $component->getSpecificationComponentData($pathMethodData, static::SCHEMA_REFERENCE);

        $this->assertArrayNotHasKey(static::KEY_CONTENT, $result['204'], 'Expected 204 response to have no content block.');
    }

    public function testAddsDefaultSuccessCodeWhenNoAnnotatedSuccessResponseExists(): void
    {
        $component = new PathResponseSpecificationComponent();

        $pathMethodData = [
            static::KEY_DEFAULT_RESPONSE_CODE => Response::HTTP_CREATED,
            static::KEY_RESPONSES => [
                '400' => 'Bad Request.',
                '403' => 'Forbidden.',
            ],
        ];

        $result = $component->getSpecificationComponentData($pathMethodData, static::SCHEMA_REFERENCE);

        $this->assertArrayHasKey('201', $result, 'Expected 201 to be added when no success response is defined.');
        $this->assertArrayHasKey(static::KEY_CONTENT, $result['201'], 'Expected 201 response to have content block.');
    }

    public function testSuccessResponseWithBodyHasContentBlock(): void
    {
        $component = new PathResponseSpecificationComponent();

        $pathMethodData = [
            static::KEY_DEFAULT_RESPONSE_CODE => Response::HTTP_CREATED,
            static::KEY_RESPONSES => [
                '201' => 'Resource created.',
                '400' => 'Bad Request.',
            ],
        ];

        $result = $component->getSpecificationComponentData($pathMethodData, static::SCHEMA_REFERENCE);

        $this->assertArrayHasKey('201', $result, 'Expected 201 response to be present.');
        $this->assertArrayHasKey(static::KEY_CONTENT, $result['201'], 'Expected 201 response to have content block.');
    }
}
