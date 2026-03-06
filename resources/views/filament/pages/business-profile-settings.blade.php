<x-filament::page>
    {{-- Action Buttons Section --}}
    <div class="flex flex-wrap gap-3 mb-6 p-4 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <a href="{{ \App\Filament\Resources\SettingResource::getUrl('create') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg transition-colors shadow-sm">
            <x-heroicon-o-plus-circle class="w-5 h-5" />
            Tambah Pengaturan Baru
        </a>
        <a href="{{ \App\Filament\Resources\SettingResource::getUrl('index') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors shadow-sm">
            <x-heroicon-o-pencil-square class="w-5 h-5" />
            Edit Semua Pengaturan
        </a>
        <a href="{{ \App\Filament\Resources\SettingResource::getUrl('index') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors shadow-sm">
            <x-heroicon-o-trash class="w-5 h-5" />
            Hapus Pengaturan
        </a>
    </div>

    <form wire:submit="save" class="space-y-6">
        {{ $this->form }}

        <div class="flex flex-wrap items-center gap-4 justify-start">
            <x-filament::button type="submit">
                Simpan Perubahan
            </x-filament::button>
        </div>
    </form>
</x-filament::page>
