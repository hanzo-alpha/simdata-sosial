<div class="fi-wi-multi-widget col-span-full w-full max-w-none flex flex-col gap-y-6" style="grid-column: 1 / -1;">
    @if ($visibleWidgets)
        <div class="fi-wi-multi-widget-tabs overflow-x-auto rounded-xl bg-white p-2 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <nav class="flex items-center gap-x-1" aria-label="Tabs">
                @foreach ($visibleWidgets as $index => $widget)
                    @php
                        $isActive = $currentWidget === $index;
                        $displayName = $this->getWidgetDisplayName($widget);
                    @endphp
                    <button
                        type="button"
                        wire:click="selectWidget({{ $index }})"
                        @class([
                            'flex items-center justify-center gap-x-2 rounded-lg px-4 py-2 text-sm font-semibold transition-all duration-200 ease-in-out whitespace-nowrap',
                            'bg-primary-500 text-white shadow-md shadow-primary-500/20' => $isActive,
                            'text-gray-500 hover:bg-gray-50 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-200' => ! $isActive,
                        ])
                    >
                        <span>{{ $displayName }}</span>
                    </button>
                @endforeach
            </nav>
        </div>

        <div class="fi-wi-multi-widget-content w-full transition-opacity duration-300" wire:loading.class="opacity-50">
            {!! $this->widgetHTML !!}
        </div>
    @endif
</div>
