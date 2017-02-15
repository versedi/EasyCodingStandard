<?php declare(strict_types=1);

namespace Symplify\EasyCodingStandard\Tests\PhpCsFixer\Fixer;

use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Symplify\EasyCodingStandard\DI\ContainerFactory;
use Symplify\EasyCodingStandard\RuleRunner\Fixer\FixerFactory;

final class FixerFactoryTest extends TestCase
{
    /**
     * @var FixerFactory
     */
    private $fixerFactory;

    protected function setUp()
    {
        $container = (new ContainerFactory())->create();
        $this->fixerFactory = $container->getByType(FixerFactory::class);
    }

    public function testRuleConfiguration()
    {
        $rules = $this->fixerFactory->createFromFixerClasses([ArraySyntaxFixer::class], []);

        /** @var ArraySyntaxFixer $arrayRule */
        $arrayRule = $rules[0];
        $this->assertInstanceOf(ArraySyntaxFixer::class, $arrayRule);
        $this->assertSame(
            'long',
            Assert::getObjectAttribute($arrayRule, 'config')
        );

        $rules = $this->fixerFactory->createFromFixerClasses([
            ArraySyntaxFixer::class => [
                'syntax' => 'short'
            ]
        ], []);

        /** @var ArraySyntaxFixer $arrayRule */
        $arrayRule = $rules[0];
        $this->assertInstanceOf(ArraySyntaxFixer::class, $arrayRule);
        $this->assertSame(
            'short',
            Assert::getObjectAttribute($arrayRule, 'config')
        );
    }
}