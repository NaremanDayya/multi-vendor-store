<div class="form-group">
    {{-- عنا هان ما حطينا اقواس ال{{ }} حطينا قبل اسم المتغير نقطتين بدالهم --}}
    <x-form.input type="text" label="Category Name" name="name" :value="$product->name" />
</div>

<div class="form-group">
    <label for="">Category</label>
    <select name="category_id" class="form-control form-select">
        <option value="">Primary Category </option>
        {{-- اذا كانت الفاليو فاضية بخليها فاضية بس ما بحدف الاتربيوت عشان يبعتلي null يا اما بياخد النص يلي حطيناه للoption --}}
        @foreach (App\Models\Category::all() as $category)
            <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <x-form.textarea name="description" label="Category Description" :value="$product->description" />
</div>

<div class="form-group">
    <x-form.label id="image">Image</x-form.label>
    {{-- accept عشان يسمحلي اختار بس صور لما بدي اعبي الملف بس عادي لو اختار اشي غير الصور فهادا مش validation مضمونة --}}
    <x-form.input type="file" name="image" accept="image/*" />
    @if ($product->image)
        <img src="{{ asset('storage/' . $product->image) }}" alt="" height="50px">
    @endif
</div>

<div class="form-group">
    <x-form.label id="price">Price</x-form.label>
    <x-form.input type="number" name="price" :value="$product->price"/>
</div>

<div class="form-group">
    <x-form.label id="compare_price">Compare Price</x-form.label>
    <x-form.input type="number" name="ocmpare_price" :value="$product->compare_price" />
</div>

<div class="form-group">
    <x-form.label id="tags">Tags</x-form.label>
    <x-form.input type="text" name="tags"  :value="$tags"/>
</div>


<div class="form-group">
    <div class="form-group">
        <label for="">Status</label>
        <div>
            <x-form.radio name="status" :checked="$product->status" :options="['active' => 'Active', 'draft' => 'Draft', 'archived' => 'Archived']" />
    
        </div>
    </div>

    <div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
    </div>

    {{-- عنا هنا استخدمنا مكتبة للتاجز وحددناها انها بس لحقل التاجز --}}
    {{-- عنااستخدمنا ال asset بعد ما حفظنا الملفات locally لانه اسرع --}}
    @push('styles')
    {{-- <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" /> --}}
    <link href="{{ asset('dist/css/tagify.css') }}" rel="stylesheet" type="text/css"/>

    @endpush

    @push('scripts')
    {{-- <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script> --}}
    <script src="{{ asset('dist/js/tagify.js') }}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script> --}}
    <script src="{{ asset('dist/js/tagify.polyfills.min.js') }}"></script>

    <script>
        var inputElm = document.querySelector('[name=tags]'),
        tagify = new Tagify (inputElm);
    </script>
    @endpush