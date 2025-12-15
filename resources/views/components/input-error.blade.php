@props(['for'])

@error($for)
    <p {{ $attributes->merge(['class' => 'text-sm text-purple-600 dark:text-purple-400']) }}>{{ $message }}</p>
@enderror
