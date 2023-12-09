<?php
declare(strict_types=1);

namespace Zenchron\SharedBundle\Domain\Site;

interface SiteUrlResolver
{
    public function siteUrl(?string $path = ''): string;
}
