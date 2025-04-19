@props([
    'id',
    'name',
    'label',
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'maxlength' => null,
    'datepicker' => false,
])

<div>
    <label for="{{ $id }}"
        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-200">{{ $label }}</label>
    @if ($type === 'text' && !$datepicker)
        <input type="text" id="{{ $id }}" name="{{ $name }}" value="{{ old($name, $value) }}"
            class="bg-gray-50 dark:bg-gray-700 border {{ $errors->has($name) ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} text-gray-900 dark:text-gray-200 dark:placeholder-gray-400 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 block w-full p-2.5 transition-all duration-200"
            placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }}
            {{ $maxlength ? "maxlength=$maxlength" : '' }}>
    @elseif($datepicker)
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                </svg>
            </div>
            <input id="{{ $id }}" name="{{ $name }}" datepicker datepicker-buttons
                datepicker-autoselect-today datepicker-format="dd-mm-yyyy" type="text"
                value="{{ old($name, $value) }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 transition-all duration-200"
                placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }}>
        </div>
    @endif
    @error($name)
        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>
