<?php

declare(strict_types=1);

namespace Otis22\VetmanagerRestApi\Query\Filter;

use Otis22\VetmanagerRestApi\Query\Filter;
use Otis22\VetmanagerRestApi\Model\Property;
use Otis22\VetmanagerRestApi\Query\Filter\Value\StringValue;

final class Like implements Filter
{
    /**
     * @var string
     */
    private $operator = 'like';
    /**
     * @var Property
     */
    private $property;
    /**
     * @var StringValue
     */
    private $value;

    /**
     * EqualTo constructor.
     * @param Property $property
     * @param StringValue $value
     */
    public function __construct(Property $property, StringValue $value)
    {
        $this->property = $property;
        $this->value = $value;
    }

    /**
     * @inheritDoc
     */
    public function asKeyValue(): array
    {
        $filterSettings['property'] = $this->property->asString();
        $filterSettings['value'] = $this->value->asString();
        $filterSettings['operator'] = $this->operator;
        return $filterSettings;
    }
}
