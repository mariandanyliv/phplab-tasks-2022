<?php

namespace basics;
use InvalidArgumentException;

class Basics implements BasicsInterface
{
    protected $validatorBasics;

    protected const FIRST = 'first';

    protected const SECOND = 'second';

    protected const THIRD = 'third';

    protected const FOURTH = 'fourth';

    public function __construct(private BasicsValidatorInterface $validator)
    {
        $this->validatorBasics = $validator;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getMinuteQuarter(int $minute): string
    {
        $this->validatorBasics->isMinutesException($minute);


        $minuteQuarter = match (true) {
            $minute > 0 && $minute <= 15 => self::FIRST,
            $minute > 15 && $minute <= 30 => self::SECOND,
            $minute > 30 && $minute <= 45 => self::THIRD,
            default => self::FOURTH,
        };

        return $minuteQuarter;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function isLeapYear(int $year): bool
    {

        $this->validatorBasics->isYearException($year);

        return ($year % 4 == 0 && $year % 100 != 0) || ($year % 400 == 0);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function isSumEqual(string $input): bool
    {

        $this->validatorBasics->isValidStringException($input);

        return (array_sum(str_split(substr($input, 0, 3))) === array_sum(str_split(substr($input, 3)))) ? true : false;
    }
}
