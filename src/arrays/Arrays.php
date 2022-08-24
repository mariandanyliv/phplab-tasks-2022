<?php

namespace arrays;

class Arrays implements ArraysInterface
{
    /**
     * @param  array $input array of digits
     * @return array
     */
    public function repeatArrayValues(array $input): array
    {
        $result = [];
        foreach ($input as $elem) {
            for ($i = 0; $i < $elem; $i++) {
                $result[] = $elem;
            }
        }

        return $result;
    }

    /**
     * @param  array $input array of digits
     * @return int
     */
    public function getUniqueValue(array $input): int
    {
        $arrCount = array_count_values($input);
        $uniqArr = array_keys(array_filter($arrCount, function ($itemCount) {
            return $itemCount == 1;
        }));

        return !empty($uniqArr) ? min($uniqArr) : 0;
    }

    /**
     * @param  array $input Array of arrays
     * @return array
     */
    public function groupByTag(array $input): array
    {
        asort($input);
        $output = [];
        foreach ($input as $val) {
            foreach ($val['tags'] as $tag) {
                $output[$tag][] = $val['name'];
            }
        }
        ksort($output);

        return $output;
    }
}
