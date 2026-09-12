<?php

namespace App\Filament\Student\Widgets;

use App\Models\Unit;
use Filament\Widgets\Widget;

class LearningUnitsWidget extends Widget
{
    protected string $view = 'filament.student.widgets.learning-units-widget';

    protected int|string|array $columnSpan = 'full';

    protected function getUnits()
    {
        return Unit::query()
            ->published()
            ->with('bloom')
            ->orderBy('order')
            ->get()
            ->map(function (Unit $unit) {
                $unit->is_locked = $this->isLockedForCurrentUser($unit);
                $unit->progress_percent = $this->getProgressPercentForCurrentUser($unit);

                return $unit;
            });
    }

    /**
     * TODO: ganti dengan logic asli begitu tabel `submissions` sudah ada.
     * Aturan sementara: unit pertama selalu terbuka, sisanya mengikuti
     * apakah unit SEBELUMNYA sudah 100% selesai (lihat getProgressPercentForCurrentUser).
     * Saat ini karena belum ada data submission, progress semua unit = 0%,
     * jadi hasilnya: Unit 1 terbuka, Unit 2-7 semua "terkunci".
     * Ganti method ini kalau aturan unlock-nya beda dari asumsi ini.
     */
    protected function isLockedForCurrentUser(Unit $unit): bool
    {
        if ($unit->order <= 1) {
            return false;
        }

        $previousUnit = Unit::query()
            ->published()
            ->where('order', '<', $unit->order)
            ->orderByDesc('order')
            ->first();

        if (! $previousUnit) {
            return false;
        }

        return $this->getProgressPercentForCurrentUser($previousUnit) < 100;
    }

    /**
     * TODO: hitung dari tabel `submissions` (jumlah task yang sudah dikerjakan
     * dibagi total task dalam unit ini). Untuk sekarang selalu return 0.
     */
    protected function getProgressPercentForCurrentUser(Unit $unit): int
    {
        return 0;
    }
}
