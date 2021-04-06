<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

final class ViewClearCommand extends Command
{
    protected $name = 'view:clear';
    protected $description = 'Clear all compiled view files';

    public function __construct(
        private Filesystem $files
    ) {
        parent::__construct();
    }

    public function handle()
    {
        $path = realpath(storage_path('framework/views'));
        foreach ($this->files->glob("{$path}/*") as $file) {
            $this->files->delete($file);
        }
        return 0;
    }
}
