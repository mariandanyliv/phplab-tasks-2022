<?php

namespace src\oop\app\src\Models;

use BadMethodCallException;

abstract class Model
{
    public function __construct(array $rawData)
    {
        $this->call($rawData);
    }

    /**
     * @throws BadMethodCallException
     */
    private function call(array $rawData): void
    {
        foreach ($rawData as $key => $data) {
            $setter = 'set' . ucfirst($key);

            if (!method_exists($this, $setter)) {
                throw new BadMethodCallException(
                    'Setter [' . $setter . '()] not found in model [' . static::class . ']'
                );
            }

            $this->$setter($data);
        }
    }
}
