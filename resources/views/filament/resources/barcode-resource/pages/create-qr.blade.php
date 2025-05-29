<x-filament-panels::page>
    {{-- Menampilkan form --}}
    {{ $this->form }}

    {{-- Menampilkan QR Code --}}
    <div class="mt-6 flex justify-center">
        @php
            $tableNumber = $formData['table_number'] ?? null;
        @endphp

        @if ($tableNumber)
            <div class="text-center">
                <p class="text-lg font-semibold mb-2">QR untuk meja: {{ $tableNumber }}</p>
                {!! QrCode::size(200)->margin(1)->generate(request()->getSchemeAndHttpHost() . '/' . $tableNumber) !!}
            </div>
        @endif
    </div>

    {{-- Tombol Simpan --}}
    <div class="mt-6 flex justify-center">
        <x-filament::button wire:click="save" color="primary">
            Generate & Save
        </x-filament::button>
    </div>
</x-filament-panels::page>
