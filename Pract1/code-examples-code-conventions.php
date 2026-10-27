<?php

declare(strict_types=1);

// Рекомендація 1: Дотримуйтесь стандартної структури файлу
namespace App\Service;

use App\Entity\Order;
use InvalidArgumentException;

final class OrderValidator
{
    // ...
}



// Рекомендація 2: Вмикайте строгу типізацію та вказуйте типи скрізь

namespace App\Entity;

final class Product
{
    private string $name;
    private float $price;

    public function __construct(string $name, float $price)
    {
        $this->name = $name;
        $this->price = $price;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}


// Рекомендація 3: Використовуйте осмислені назви

// Приклад поганого оформлення:
public function calc(float $a, float $b): float
{
    return $a * (1 - $b / 100);
}

// Приклад, що відповідає стандарту:
public function applyDiscount(float $price, float $percent): float
{
    return $price * (1 - $percent / 100);
}


// Рекомендація 4: Відступи, довжина рядка, фігурні дужки

// Приклад (сигнатура вміщається в один рядок, тому її не переносять):
namespace App\Service;

final class PriceCalculator
{
    public function applyDiscount(float $price, float $percent): float
    {
        return $price * (1 - $percent / 100);
    }
}

// Приклад багаторядкової сигнатури (коли параметрів багато):
public function createInvoice(
    Customer $customer,
    array $items,
    float $discountPercent,
    string $currency
): Invoice {
    // ...
}


// Рекомендація 5: Оголошуйте класи як final

final class PriceCalculator
{
    // ...
}


// Рекомендація 6: Керуючі конструкції

public function applyDiscount(float $price, float $percent): float
{
    if ($percent < 0.0 || $percent > 100.0) {
        throw new InvalidArgumentException('Percent must be between 0 and 100.');
    }

    return $price * (1 - $percent / 100);
}


// Рекомендація 7: PHPDoc без дублювання очевидного

// Приклад поганого оформлення:
/**
 * Повертає ім'я.
 * @return string
 */
public function getName(): string
{
    return $this->name;
}

// Приклад, що відповідає стандарту:
/**
 * Розраховує підсумкову вартість замовлення з урахуванням знижки.
 *
 * @param OrderItem[] $items   Позиції замовлення (не порожній масив)
 * @param float       $percent Відсоток знижки від 0 до 100
 *
 * @return float Підсумкова сума в гривнях
 *
 * @throws InvalidArgumentException Якщо знижка виходить за межі 0-100
 *
 * @see PriceCalculator::applyDiscount()
 */
public function calculateTotal(array $items, float $percent = 0.0): float
{
    // ...
}


// Рекомендація 8: Модульні тести за схемою Arrange-Act-Assert

namespace App\Tests\Service;

use App\Service\PriceCalculator;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class PriceCalculatorTest extends TestCase
{
    public function testApplyDiscountReducesPriceByGivenPercent(): void
    {
        // Arrange
        $calculator = new PriceCalculator();

        // Act
        $result = $calculator->applyDiscount(200.0, 10.0);

        // Assert
        $this->assertEqualsWithDelta(180.0, $result, 0.001);
    }

    public function testApplyDiscountThrowsExceptionForNegativePercent(): void
    {
        $this->expectException(InvalidArgumentException::class);

        (new PriceCalculator())->applyDiscount(200.0, -5.0);
    }
}


// 3.3 Програмні інструменти (приклади конфігурацій і команд, у коментарях)

/*
 * --- PHP_CodeSniffer (phpcs, phpcbf) ---
 *
 * vendor/bin/phpcs --standard=PSR12 src tests
 * vendor/bin/phpcbf --standard=PSR12 src tests
 */

/*
 * --- PHP-CS-Fixer: файл .php-cs-fixer.dist.php ---
 *
 * <?php
 *
 * declare(strict_types=1);
 *
 * $finder = PhpCsFixer\Finder::create()
 *     ->in([__DIR__ . '/src', __DIR__ . '/tests']);
 *
 * return (new PhpCsFixer\Config())
 *     ->setRiskyAllowed(true)
 *     ->setRules([
 *         '@PSR12' => true,
 *         'declare_strict_types' => true,
 *     ])
 *     ->setFinder($finder);
 *
 * Запуск: vendor/bin/php-cs-fixer fix
 */

/*
 * --- PHPStan ---
 *
 * vendor/bin/phpstan analyse src tests --level=8
 */

/*
 * --- PHPUnit ---
 *
 * vendor/bin/phpunit
 */

/*
 * --- Composer scripts: розділ "scripts" у composer.json ---
 *
 * {
 *     "scripts": {
 *         "cs:check": "phpcs --standard=PSR12 src tests",
 *         "cs:fix": "phpcbf --standard=PSR12 src tests",
 *         "stan": "phpstan analyse src tests --level=8",
 *         "test": "phpunit"
 *     }
 * }
 *
 * Запуск: composer cs:check, composer stan, composer test
 */
