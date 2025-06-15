<?php

declare(strict_types=1);

namespace App\Feature\RandomMetric;

use App\Infrastructure\MessageBus\Message;

/**
 * @implements Message<void>
 */
final readonly class SetRandomMetric implements Message
{
}
