<x-filament::page>
    <div wire:ignore x-data="{
            editor: null,
            init() {
                document.addEventListener('DOMContentLoaded', () => {
                    editor = ace.edit($refs.editor, {
                        mode: 'ace/mode/ini',
                        readOnly: true,
                        maxLines: {{ config('filament-laravel-log.maxLines') }},
                        minLines: {{ config('filament-laravel-log.minLines') }},
                        fontSize: {{ config('filament-laravel-log.fontSize') }}
                    });
                })

                window.addEventListener('logContentUpdated', (e) => {
                    editor.session.setValue(e.detail.content);
                })
            },
            goToLastLine() {
                editor.gotoLine(editor.session.doc.$lines.length)
            },
            goToFirstLine() {
                editor.gotoLine(0)
            }
        }">

        <div class="flex items-center justify-between gap-6">
            <div class="w-full">
                {{ $this->search }}
            </div>
            <div class="space-x-2 shrink-0">
                <button type="button" x-on:click="goToFirstLine()"
                    class="inline-flex items-center justify-center px-2 font-medium tracking-tight text-gray-800 transition-colors bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset filament-button dark:focus:ring-offset-0 h-9 hover:bg-gray-50 focus:ring-primary-600 focus:text-primary-600 focus:bg-primary-50 focus:border-primary-600 dark:bg-gray-800 dark:border-gray-600 dark:hover:border-gray-500 dark:text-gray-200 dark:focus:text-primary-400 dark:focus:border-primary-400 dark:focus:bg-gray-800 filament-page-button-action"
                    x>
                    <svg class="w-6 h-6 filament-button-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                    </svg>
                    {{-- <span>Jump to Start</span> --}}
                </button>

                <button type="button" wire:loading.attr="disabled" wire:loading.class="cursor-wait opacity-70"
                    wire:target="refreshContent"
                    class="inline-flex items-center justify-center px-2 font-medium tracking-tight text-gray-800 transition-colors bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset filament-button dark:focus:ring-offset-0 h-9 hover:bg-gray-50 focus:ring-primary-600 focus:text-primary-600 focus:bg-primary-50 focus:border-primary-600 dark:bg-gray-800 dark:border-gray-600 dark:hover:border-gray-500 dark:text-gray-200 dark:focus:text-primary-400 dark:focus:border-primary-400 dark:focus:bg-gray-800 filament-page-button-action"
                    wire:click="refreshContent">
                    <svg class="w-6 h-6 filament-button-icon" fill="none" viewBox="0 0 24 24" stroke-width="2"
                         stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                        </path>
                    </svg>
                    {{-- <span>Refresh</span> --}}
                </button>

                <button type="button" x-on:click="goToLastLine()"
                    class="inline-flex items-center justify-center px-2 font-medium tracking-tight text-gray-800 transition-colors bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset filament-button dark:focus:ring-offset-0 h-9 hover:bg-gray-50 focus:ring-primary-600 focus:text-primary-600 focus:bg-primary-50 focus:border-primary-600 dark:bg-gray-800 dark:border-gray-600 dark:hover:border-gray-500 dark:text-gray-200 dark:focus:text-primary-400 dark:focus:border-primary-400 dark:focus:bg-gray-800 filament-page-button-action">
                    <svg class="w-6 h-6 filament-button-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>

                    {{-- <span>Jump to End</span> --}}
                </button>

                <button type="button" wire:loading.attr="disabled" wire:loading.class="cursor-wait opacity-70"
                    x-on:click="window.dispatchEvent(new CustomEvent('open-modal', { detail: { id: 'filament-laravel-log--clear-modal' } }));"
                    class="inline-flex items-center justify-center px-2 font-medium tracking-tight text-gray-800 transition-colors bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset filament-button dark:focus:ring-offset-0 h-9 hover:bg-gray-50 focus:ring-primary-600 focus:text-primary-600 focus:bg-primary-50 focus:border-primary-600 dark:bg-gray-800 dark:border-gray-600 dark:hover:border-gray-500 dark:text-gray-200 dark:focus:text-primary-400 dark:focus:border-primary-400 dark:focus:bg-gray-800 filament-page-button-action">
                    <svg class="w-6 h-6 filament-button-icon" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                        </path>
                    </svg>
                    {{-- <span>Empty</span> --}}
                </button>
            </div>
        </div>

        <div x-ref="editor" class="mt-4 rounded-md ace-forge" />
    </div>

    <x-filament::modal id="filament-laravel-log--clear-modal"
        :heading="__('filament-laravel-log::labels.modals.clear.heading')"
        :subheading="__('filament-laravel-log::labels.modals.clear.subheading')">
        <x-slot name="actions">
            <x-filament::modal.actions fullWidth="true">
                <x-filament::button type="button" x-on:click="isOpen = false" color="secondary" outlined="true"
                    class="filament-page-modal-button-action">
                    {{ __('filament-laravel-log::labels.modals.clear.actions.cancel') }}
                </x-filament::button>
                <x-filament::button wire:click="clearLogs" x-on:click="isOpen = false" type="button" color="primary"
                    class="filament-page-modal-button-action">
                    {{ __('filament-laravel-log::labels.modals.clear.actions.confirm') }}
                </x-filament::button>
            </x-filament::modal.actions>
        </x-slot>
    </x-filament::modal>
</x-filament::page>
