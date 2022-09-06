<?php

namespace App\Console\Commands;

use App\Documentation\Documentation;
use App\Documentation\Loader;
use App\Documentation\Models\PathInfo;
use App\Enums\Locale;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

final class DocsCacheCommand extends Command
{
    protected $signature = 'docs:cache';

    protected $description = 'Cache compiled markdown command';

    public function handle(): int
    {
        $docset = Documentation::get($docsetKey = 'laravel');
        throw_if($docset === null, \RuntimeException::class, 'Expected "laravel" docset to be present');

        foreach ($docset->locales as $localeKey => $locale) {
            foreach ($docset->versions as $versionKey => $version) {
                $glob = resource_path('docs/' . str_replace(['{{version}}', '{{page}}'], [$versionKey, '*'], $locale->path));
                $suffix = Str::afterLast($glob, '.');
                $basePath = Str::beforeLast($glob, '*');

                $files = File::glob($glob);

                $progress = $this->output->createProgressBar(count($files));

                $progress->setFormat('  %current%/%max% [%bar%] %percent:3s%% - %message%');
                $progress->setMessage(sprintf('[%s] %s/%s...', $localeKey, 'laravel', $versionKey));

                $progress->start();

                foreach ($files as $file) {
                    $filename = Str::between($file, $basePath, '.' . $suffix);

                    $progress->setMessage(sprintf('[%s] %s/%s/%s...', $localeKey, $docsetKey, $versionKey, $filename));

                    $this->parsePage(
                        Locale::from($localeKey),
                        'laravel',
                        $versionKey,
                        $filename,
                    );

                    $progress->advance();
                }

                $progress->setMessage(sprintf('[%s] %s/%s...', $localeKey, $docsetKey, $versionKey));

                $progress->finish();
                $this->output->newLine();
            }
        }

        return self::SUCCESS;
    }

    /**
     * @noinspection PhpSameParameterValueInspection
     * @noinspection PhpReturnValueOfMethodIsNeverUsedInspection
     */
    private function parsePage(Locale $locale, string $doc, string $version, string $page): HtmlString
    {
        return retry(3, function () use ($locale, $doc, $version, $page) {
            $loader = new Loader(
                new PathInfo(
                    doc: $doc,
                    locale: $locale,
                    version: $version,
                    page: $page,
                )
            );

            return $loader->getContent();
        });
    }
}
