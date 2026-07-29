<div class="rounded-xl border border-warning-300 bg-warning-50 dark:bg-warning-500/10 dark:border-warning-500/30 p-4 w-full">
    <div class="flex items-start gap-3">
        <x-heroicon-o-exclamation-triangle class="h-6 w-6 text-warning-600 shrink-0" />
        <div>
            <p class="font-semibold text-warning-800 dark:text-warning-400">
                Your account has not verified yet
            </p>
            <p class="text-sm text-warning-700 dark:text-warning-300 mt-1">
                All dashboard features will be unlocked once you are already verified. If it takes a long time, please
                contact Administrator. You have registered at: {{ auth()->user()->created_at->format('l, j F Y H:i') }}
            </p>
        </div>
    </div>
</div>
