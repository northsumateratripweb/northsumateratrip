<x-filament-panels::page>
    <form wire:submit="save">
        {{ $this->form }}

        <div class="flex items-center justify-end gap-x-3 mt-4">
            <x-filament::button type="submit" size="lg" color="primary">
                Simpan Perubahan
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
