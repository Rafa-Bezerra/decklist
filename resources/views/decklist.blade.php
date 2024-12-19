<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('convert') }}" enctype="multipart/form-data">
        @csrf

        <!-- Origin -->
        <div>
            <x-input-label for="origin" :value="__('Origin')" />
            
            <select class="block mt-1 w-full" name="origin" required="true">
                <!-- <option value="liga">Liga Magic</option>
                <option value="moxfield">Moxfield</option>
                <option value="goldfish">MTG Goldfish</option> -->
                <option value="delver">Delver</option>
            </select>
            <x-input-error :messages="$errors->get('origin')" class="mt-2" />
        </div>

        <!-- Destiny -->
        <div class="mt-4">
            <x-input-label for="destiny" :value="__('Destiny')" />
            <select class="block mt-1 w-full" name="destiny" required="true">
                <option value="liga">Liga Magic</option>
                <!-- <option value="moxfield">Moxfield</option>
                <option value="goldfish">MTG Goldfish</option>
                <option value="delver">Delver</option> -->
            </select>
            <x-input-error :messages="$errors->get('destiny')" class="mt-2" />
        </div>

        <!-- File -->
        <div class="mt-4">
            <x-input-label for="file" :value="__('File')" />
            <x-text-input id="file" class="block mt-1 w-full" type="file" name="file" :value="old('file')" required autofocus />
            <x-input-error :messages="$errors->get('file')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Convert') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
