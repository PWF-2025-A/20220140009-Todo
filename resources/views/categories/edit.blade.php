<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('categories.update', $category) }}">
                        @csrf
                        @method('PATCH')

                        {{-- Input Title --}}
                        <div class="mb-6">
                            <x-input-label for="title" :value="__('Category Title')" />
                            <x-text-input 
                                id="title" 
                                name="title" 
                                type="text" 
                                class="block mt-1 w-full" 
                                :value="old('title', $category->title)" 
                                required 
                                autofocus 
                                autocomplete="title" 
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        {{-- Form Actions --}}
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                            <x-cancel-button href="{{ route('categories.index') }}" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
