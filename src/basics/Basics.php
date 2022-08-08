<?php

namespace basics;

class Basics implements BasicsInterface
{
    protected $validator;

    public function __construct($validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param int $minute
     * @return string
     * @throws \InvalidArgumentException
     */
    public function getMinuteQuarter(int $minute): string
    {
        if ($minute < 0 || $minute > 60) {
            $this->validator->isMinutesException($minute);
        } else if ($minute > 0 && $minute <= 15) {
            return "first";
        } else if ($minute > 15 && $minute <= 30) {
            return "second";
        } else if ($minute > 30 && $minute <= 45) {
            return "third";
        } else {

            return "fourth";
        }
    }

    /**
     * @param int $year
     * @return boolean
     * @throws \InvalidArgumentException
     */
    public function isLeapYear(int $year): bool
    {
        if ($year < 1900) {
            $this->validator->isYearException($year);
        }

        return ($year % 4 == 0 && $year % 100 != 0 || $year % 400 == 0) ? true : false;
    }

    /**
     * @param string $input
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function isSumEqual(string $input): bool
    {
        if (strlen($input) !== 6) {
            $this->validator->isValidStringException($input);
        }

        return (array_sum(str_split(substr($input, 0, 3))) === array_sum(str_split(substr($input, 3)))) ? true : false;
    }
}