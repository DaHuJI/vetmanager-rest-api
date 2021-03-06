<?php

declare(strict_types=1);

namespace Otis22\VetmanagerRestApi\Query;

use ElegantBro\Arrayee\Just;
use ElegantBro\Arrayee\Merged;
use Otis22\PhpInterfaces\KeyValue;
use ElegantBro\Arrayee\Aggregation\Reduced;

final class Query implements KeyValue
{
    /**
     * @var array<KeyValue>
     */
    private $queries;

    /**
     * Query constructor.
     * @param KeyValue ...$queries
     */
    public function __construct(KeyValue ...$queries)
    {
        $this->queries = $queries;
    }

    /**
     * @inheritDoc
     */
    public function asKeyValue(): array
    {
        return Reduced::initialEmpty(
            new Just($this->queries),
            function (array $carry, KeyValue $current): array {
                return (
                    new Merged(
                        new Just($carry),
                        new Just($current->asKeyValue())
                    )
                )->asArray();
            }
        )->asArray();
    }
}
