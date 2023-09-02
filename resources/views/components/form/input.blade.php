{{-- عنا هنا لما حددنا مين هما ،لو في عندي غيرهم وما عرفتهم ما حيطلعلي ايرور --}}
{{-- عنا هنا اعطينا قيم لو ما تم تعريفها عنداستدعاء الcomponent --}}
@props([
    'type'=>'text',
    'name', 
    'value'=>"",
    'label'=>false
])
@if ($label)
    <label for="">{{ $label }}</label>
@endif
    
    <input
    type="{{ $type }}" 
    name="{{ $name }}"
    value="{{ old($name, $value) }}"
    {{ $attributes->class([
        'form-control',
        'is-invalid' => $errors->has($name)
    ]) }}
    >
    {{-- عنا هادي الاتربيوتس بتطبعلي باقي الاتربيوتس يلي ما عرفناها في داخل ال props فما بيصير عنا تكرار--}}
    
    {{-- وقفنا الكلاس واعتبرناها خلص من الاتربيوتس يلي ما عرفتها--}}
     {{-- @class([
        //ع اساس انه احنا نحط خصائص للكلاس حسب شروط معينة
        'form-control',
        'is-invalid' => $errors->has('{{ $name }}')
    ])  --}}
    {{-- عشان احتفظ بالبيانات يلي كنت معبيها قبل الايرور --}} {{-- وعشان لو عملنا ايديت يكون في بيانات موجودة يعدلها --}}
    {{-- عنا هان لو ما لقى قيمة قديمة رح يطبع يلي بال value يلي عرفتها لما استدعيت ال component داخل الفورم     --}}
    
    @error($name)
        <div class="invalid-feedback">
            {{-- لو بدي اعرض اول ايرور للحقل بستخدم first --}}
            {{-- {{ $errors->first('name') }} --}}
            {{-- لو بدي اعرض كل اخطاء الحقل بستخدم get --}}
            @foreach ($errors->get('{{ $name }}') as $name_errors)
                {{ $name_errors }}
        @endforeach
     </div>
     @enderror
