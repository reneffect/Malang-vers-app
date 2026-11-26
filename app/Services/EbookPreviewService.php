<?php

namespace App\Services;

use App\Models\Ebook;
use Illuminate\Support\Facades\Storage;
use OutOfBoundsException;
use RuntimeException;
use setasign\Fpdi\Tcpdf\Fpdi;

class EbookPreviewService
{
    private const MAX_PREVIEW_PAGES = 5;

    public function renderPage(Ebook $ebook, int $page): string
    {
        if ($page < 1 || $page > self::MAX_PREVIEW_PAGES) {
            throw new OutOfBoundsException('Halaman berada di luar batas pratinjau.');
        }

        $path = $ebook->lokasi_berkas;
        $disk = Storage::disk('local');

        if (! $path || ! $disk->exists($path)) {
            throw new RuntimeException('File PDF E-Book tidak ditemukan di penyimpanan privat.');
        }

        $modifiedAt = $disk->lastModified($path);
        $cachedPath = "ebooks/previews/{$ebook->getKey()}/{$modifiedAt}/{$page}.pdf";

        if ($disk->exists($cachedPath)) {
            $cachedContent = $disk->get($cachedPath);

            if (! is_string($cachedContent)) {
                throw new RuntimeException('Gagal membaca halaman pratinjau E-Book dari cache.');
            }

            return $cachedContent;
        }

        $pdf = new Fpdi;
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(0, 0, 0);
        $pdf->SetAutoPageBreak(false, 0);

        $pageCount = $pdf->setSourceFile($disk->path($path));

        if ($page > $pageCount) {
            throw new OutOfBoundsException('Halaman tidak tersedia pada E-Book ini.');
        }

        $template = $pdf->importPage($page);
        $size = $pdf->getTemplateSize($template);
        $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
        $pdf->useTemplate($template, 0, 0, $size['width'], $size['height']);

        $content = $pdf->Output("ebook-{$ebook->getKey()}-page-{$page}.pdf", 'S');

        if (! is_string($content)) {
            throw new RuntimeException('Gagal membuat halaman pratinjau E-Book.');
        }

        if (! $disk->put($cachedPath, $content)) {
            throw new RuntimeException('Gagal menyimpan cache halaman pratinjau E-Book.');
        }

        return $content;
    }
}
