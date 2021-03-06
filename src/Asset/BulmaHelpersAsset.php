<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bulma\Asset;

use Yiisoft\Assets\AssetBundle;

final class BulmaHelpersAsset extends AssetBundle
{
    public ?string $basePath = '@assets';
    public ?string $baseUrl = '@assetsUrl';
    public ?string $sourcePath = '@npm/bulma-helpers/css';

    /** @psalm-suppress NonInvariantDocblockPropertyType */
    public array $css = [
        'bulma-helpers.css',
    ];

    /** @psalm-suppress NonInvariantDocblockPropertyType */
    public array $publishOptions = [
        'only' => [
            'bulma-helpers.css',
        ],
    ];
}
