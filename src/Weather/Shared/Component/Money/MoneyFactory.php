<?php
declare(strict_types=1);

namespace Shared\Component\Money;

use Money\Currencies;
use Money\Currencies\AggregateCurrencies;
use Money\Currencies\CurrencyList;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;
use Money\Parser\DecimalMoneyParser;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
final class MoneyFactory
{
    /**
     * @param mixed  $amount
     * @param string $currency
     *
     * @return Money
     */
    public static function create($amount, string $currency = 'IDR'): Money
    {
        $parser = new DecimalMoneyParser(self::getCurrencies());

        return $parser->parse((string)$amount, new Currency($currency));
    }

    /**
     * @return Currencies
     */
    private static function getCurrencies(): Currencies
    {
        return new AggregateCurrencies(
            [
                new CurrencyList(['IDR' => 2]),
                new ISOCurrencies(),
            ]
        );
    }

    /**
     * @param Money $money
     *
     * @return string
     */
    public static function format(Money $money): string
    {
        $formatter = new DecimalMoneyFormatter(self::getCurrencies());

        return $formatter->format($money);
    }
}
