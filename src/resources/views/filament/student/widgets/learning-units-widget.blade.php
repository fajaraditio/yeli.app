<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Learning Units
        </x-slot>

        <x-slot name="description">
            Seven units, progressing from foundational analysis to solution creation (Bloom's Taxonomy).
        </x-slot>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-2">
            @foreach ($this->getUnits() as $unit)
                @php
                    $isLocked = $unit->is_locked;
                    $progress = $unit->progress_percent;
                    $barColor = $unit->bloom->color ?? '#9CA3AF';
                @endphp

                <div @class([
                    'rounded-xl border bg-white dark:bg-gray-900 overflow-hidden transition',
                    'opacity-60' => $isLocked,
                ]) style="border-top: 4px solid {{ $isLocked ? '#D1D5DB' : $barColor }};">
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-semibold tracking-wide text-gray-500 uppercase">
                                Unit {{ $unit->order }}
                            </span>

                            @if ($isLocked)
                                <x-heroicon-o-lock-closed class="w-4 h-4 text-gray-400" />
                            @endif
                        </div>

                        <h3 @class([
                            'font-bold text-base mb-3',
                            'text-gray-900 dark:text-white' => !$isLocked,
                            'text-gray-400' => $isLocked,
                        ])>
                            {{ $unit->title }}
                        </h3>

                        @if ($unit->bloom)
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold text-white mb-4"
                                style="background-color: {{ $isLocked ? '#D1D5DB' : $barColor }};">
                                {{ $unit->bloom->name }}
                            </span>
                        @endif

                        <div class="w-full h-1.5 rounded-full bg-gray-100 dark:bg-gray-800 overflow-hidden">
                            <div class="h-full rounded-full"
                                style="width: {{ $progress }}%; background-color: {{ $isLocked ? '#D1D5DB' : $barColor }};">
                            </div>
                        </div>
                    </div>

                    @unless ($isLocked)
                        <a href="#"
                            class="block px-4 py-2 text-xs font-semibold text-center bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            Continue Learning
                        </a>
                    @endunless
                </div>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
