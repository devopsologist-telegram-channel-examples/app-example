<?php

declare(strict_types=1);

namespace App\Feature\StringFromDb;

use App\Infrastructure\MessageBus\Message;

/**
 * @implements Message<StringFromDb>
 */
final readonly class GetStringFromDb implements Message
{
}
