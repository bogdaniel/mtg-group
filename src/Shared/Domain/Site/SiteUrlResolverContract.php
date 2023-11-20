<?php
declare(strict_types=1);

namespace App\Shared\Domain\Site;

interface SiteUrlResolverContract
{
    public function siteUrl(?string $path = ''): string;
}
