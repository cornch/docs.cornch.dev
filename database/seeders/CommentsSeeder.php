<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\CommentReaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;

final class CommentsSeeder extends Seeder
{
    public function run(): void
    {
        foreach (config('docs.docsets') as $doc => $config) {
            foreach (array_keys($config['versions']) as $version) {
                foreach ($config['locales'] as $locale => $localeConfig) {
                    $path = Str::of($localeConfig['path'])
                        ->replace('{{version}}', $version)
                        ->replace('{{page}}', '*')
                        ->dirname()
                        ->__toString();

                    $files = (new Finder)
                        ->in(resource_path('docs/' . $path))
                        ->files();

                    $this->seedCommentsForFiles($files, $locale, $doc, $version);
                }
            }
        }

        $this->command->newLine();
        $this->command->getOutput()->write('  ' . self::class . ' ');
    }

    private function seedCommentsForFiles(Finder $files, string $locale, string $doc, string $version): void
    {
        $this->command->newLine();

        $progress = $this->command->getOutput()->createProgressBar($files->count());

        $progress->setFormat('  %current%/%max% [%bar%] %percent:3s%% - %message%');
        $progress->setMessage(sprintf('[%s] %s/%s...', $locale, $doc, $version));

        $progress->start();

        foreach ($files as $file) {
            $page = $file->getBasename('.' . $file->getExtension());

            $progress->setMessage(sprintf('[%s] %s/%s/%s...', $locale, $doc, $version, $page));

            Comment
                ::factory()
                    ->has(CommentReaction::factory()->count(random_int(0, 10)), 'reactions')
                    ->state([
                        'locale' => $locale,
                        'doc' => $doc,
                        'version' => $version,
                        'page' => $page,
                    ])
                    ->count(random_int(1, 10))
                    ->create();

            $progress->advance();
        }

        $progress->setMessage(sprintf('[%s] %s/%s...', $locale, $doc, $version));
        $progress->finish();
    }
}
