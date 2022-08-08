<?php

namespace basics;

class BasicsValidator implements BasicsValidatorInterface
{
    /**
     * @param int $minute
     * @throws \InvalidArgumentException
     */
    public function isMinutesException(int $minute): void
    {
        throw new \InvalidArgumentException();
    }

    /**
     * @param int $year
     * @throws \InvalidArgumentException
     */
    public function isYearException(int $year): void
    {
        throw new \InvalidArgumentException();
    }

    /**
     * @param string $input
     * @throws \InvalidArgumentException
     */
    public function isValidStringException(string $input): void
    {
        throw new \InvalidArgumentException();
    }

}