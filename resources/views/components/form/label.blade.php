@props([
    'id' => ''
])
{{-- عنا متغير $slot بياخد القيمة يلي بحطها بين التاق بالفورم --}}
<label for="{{ $id }}">{{ $slot }}</label>