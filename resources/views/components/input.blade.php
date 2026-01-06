@props(['type' => 'text', 'label', 'name', 'required' => false, 'placeholder' => '', 'value' => ''])

<div>
    @if(isset($label))
        <label class="block text-sm font-medium text-gray-700 mb-2">{{ $label }}</label>
    @endif
    
    <input 
        type="{{ $type }}" 
        name="{{ $name }}" 
        {{ $required ? 'required' : '' }}
        placeholder="{{ $placeholder }}"
        value="{{ old($name, $value) }}"
        {{ $attributes->merge(['class' => 'w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent']) }}
    >
    
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>