<x-filament-panels::page.simple>
    <x-filament-panels::form wire:submit="authenticate">
        {{ $this->form }}

        <x-filament-panels::form.actions
            :actions="$this->getCachedFormActions()"
        />

        <div class="mt-4">
            <a
                href="{{ url('/auth/google') }}"
                class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg"
            >
                <svg class="w-5 h-5 mr-2" viewBox="0 0 533.5 544.3">
                    <path fill="#4285F4" d="M533.5 278.4c0-17.4-1.6-34.1-4.6-50.2H272v94.9h146.7c-6.3 34.1-25.1 63-53.5 82.3v68h86.5c50.5-46.6 81.8-115.4 81.8-195z"/>
                    <path fill="#34A853" d="M272 544.3c72.4 0 133.2-23.9 177.6-64.9l-86.5-68c-24.1 16.3-55 25.8-91.1 25.8-70.1 0-129.4-47.2-150.6-110.4H32.6v69.3C76.8 483.2 165.7 544.3 272 544.3z"/>
                    <path fill="#FBBC05" d="M121.4 326.8C116 312.5 112.8 297 112.8 280s3.3-32.5 8.6-46.8v-69.3H32.6C11.8 209.4 0 244 0 280s11.8 70.6 32.6 116.2l88.8-69.4z"/>
                    <path fill="#EA4335" d="M272 112.7c39.4 0 74.9 13.6 102.8 40.3l77.1-77.1C405.3 24.3 344.4 0 272 0 165.7 0 76.8 61.2 32.6 164.7l88.8 69.4c21.2-63.1 80.5-110.4 150.6-110.4z"/>
                </svg>
                Entrar com Google
            </a>
        </div>
    </x-filament-panels::form>
</x-filament-panels::page.simple>
