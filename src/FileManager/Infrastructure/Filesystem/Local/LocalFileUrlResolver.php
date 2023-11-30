<?php
declare(strict_types=1);

namespace App\FileManager\Infrastructure\Filesystem\Local;

use App\FileManager\Domain\Contract\FileUrlResolverInterface;
use App\FileManager\Domain\Enum\Breakpoint;
use App\Shared\Domain\Site\SiteUrlResolverContract;


final class LocalFileUrlResolver implements FileUrlResolverInterface
{

    public function __construct(
        private readonly SiteUrlResolverContract $siteUrlResolver,
        private readonly string $uploadUrl
    ) {
    }

    public function resolve(string $path, bool $absolute = false): string
    {
        $uploadUrl = $this->uploadUrl;
        $siteUrl   = $this->siteUrlResolver->siteUrl();
        if (\str_contains($uploadUrl, 'http')) {
            $uploadUrl = (string) \parse_url($uploadUrl, \PHP_URL_PATH);
            $siteUrl   = \str_replace($uploadUrl, '', $siteUrl);
        }
        if (\str_contains($path, $uploadUrl)) {
            $path = \str_replace($uploadUrl, '', $path);
        }

        $relative = \sprintf(
            '/%s/%s',
            \trim($uploadUrl, '/'),
            \trim($path, '/')
        );

        if (false === $absolute) {
            return $relative;
        }


        return \sprintf('%s%s', \rtrim($siteUrl, '/'), $relative);
    }

    public function resolveFromBreakpoint(string $breakpoint, string $path, bool $absolute = false): string
    {
        if (!Breakpoint::tryFrom($breakpoint)) {
            throw new \RuntimeException(\sprintf('%s is not a valid value for Breakpoint enum', $breakpoint));
        }

        $uploadUrl = $this->uploadUrl;
        $siteUrl   = $this->siteUrlResolver->siteUrl();
        if (str_contains($uploadUrl, 'http')) {
            $uploadUrl = (string) parse_url($uploadUrl, \PHP_URL_PATH);
            $siteUrl   = str_replace($uploadUrl, '', $siteUrl);
        }
        if (\str_contains($path, $uploadUrl)) {
            $path = \str_replace(sprintf('%s/%s', $uploadUrl, $breakpoint), '', $path);
        }


        $relative = \sprintf(
            '/%s/%s/%s',
            \trim($uploadUrl, '/'),
            $breakpoint,
            \trim($path, '/')
        );

        if (false === $absolute) {
            return $relative;
        }

        return \sprintf('%s%s', \rtrim($siteUrl, '/'), $relative);
    }

    public function resolvePathFromBreakpoint(string $breakpoint, string $path): string
    {
        if (!Breakpoint::tryFrom($breakpoint)) {
            throw new \RuntimeException(\sprintf('%s is not a valid value for Breakpoint enum', $breakpoint));
        }

        if (\str_contains($path, $this->uploadUrl)) {
            $path = \str_replace($this->uploadUrl, '', $path);
        }
        if (\str_contains($path, '/'.$breakpoint)) {
            $path = \str_replace('/'.$breakpoint, '', $path);
        }

        return sprintf('/%s/%s', $breakpoint, trim($path, '/'));
    }


}