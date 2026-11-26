<?php

namespace App\Console\Commands;

use App\Models\Ebook;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

#[Signature('app:secure-ebook-storage')]
#[Description('Move legacy ebook PDFs from public to private storage')]
class SecureEbookStorage extends Command
{
    public function handle(): int
    {
        $publicDisk = Storage::disk('public');
        $privateDisk = Storage::disk('local');
        $paths = Ebook::query()
            ->get(['lokasi_berkas', 'lokasi_pratinjau'])
            ->flatMap(fn (Ebook $ebook): array => [$ebook->lokasi_berkas, $ebook->lokasi_pratinjau])
            ->filter(fn (?string $path): bool => filled($path)
                && strtolower(pathinfo($path, PATHINFO_EXTENSION)) === 'pdf')
            ->merge(collect($publicDisk->allFiles('ebooks'))
                ->filter(fn (string $path): bool => strtolower(pathinfo($path, PATHINFO_EXTENSION)) === 'pdf'))
            ->unique()
            ->values();
        $migrated = 0;
        $missing = 0;

        foreach ($paths as $path) {
            if ($privateDisk->exists($path)) {
                if ($publicDisk->exists($path) && ! $publicDisk->delete($path)) {
                    throw new RuntimeException("Unable to remove public ebook file: {$path}");
                }

                continue;
            }

            if (! $publicDisk->exists($path)) {
                $this->warn("PDF not found on either disk: {$path}");
                $missing++;

                continue;
            }

            $stream = $publicDisk->readStream($path);

            if (! is_resource($stream)) {
                throw new RuntimeException("Unable to read public ebook file: {$path}");
            }

            try {
                if (! $privateDisk->put($path, $stream)) {
                    throw new RuntimeException("Unable to copy ebook file to private storage: {$path}");
                }
            } finally {
                fclose($stream);
            }

            if (! $publicDisk->delete($path)) {
                throw new RuntimeException("Unable to remove public ebook file after migration: {$path}");
            }

            $migrated++;
        }

        $this->info("Moved {$migrated} PDF file(s) to private storage.");

        return $missing > 0 ? self::FAILURE : self::SUCCESS;
    }
}
