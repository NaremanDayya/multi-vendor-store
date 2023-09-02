{{-- {{ $errors }}//object contain every errors --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <h3>Error Occured!</h3>
        <ul>
            @foreach ($errors->all() as $error)
                <li>
                    {{ $error }}
                </li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-group">
    {{-- عنا هان ما حطينا اقواس ال{{ }} حطينا قبل اسم المتغير نقطتين بدالهم --}}
    <x-form.input type="text" label="Category Name" name="name" :value="$category->name" />
</div>

<div class="form-group">
    <label for="">Category Parent</label>
    <select name="parent_id" class="form-control form-select">
        <option value="">Primary Category </option>
        {{-- اذا كانت الفاليو فاضية بخليها فاضية بس ما بحدف الاتربيوت عشان يبعتلي null يا اما بياخد النص يلي حطيناه للoption --}}
        @foreach ($parents as $parent)
            <option value="{{ $parent->id }}" @selected(old('parent_id', $category->parent_id) == $parent->id)>{{ $parent->name }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <x-form.textarea name="description" label="Category Description" :value="$category->description" />
</div>

<div class="form-group">
    <x-form.label id="image">Image</x-form.label>
    {{-- accept عشان يسمحلي اختار بس صور لما بدي اعبي الملف بس عادي لو اختار اشي غير الصور فهادا مش validation مضمونة --}}
    <x-form.input type="file" name="image" accept="image/*" />
    @if ($category->image)
        <img src="{{ asset('storage/' . $category->image) }}" alt="" height="50px">
    @endif
</div>

<div class="form-group">
    <div class="form-group">
        <label for="">Status</label>
        <div>
            <x-form.radio name="status" :checked="$category->status" :options="['active' => 'Active', 'archived' => 'Archived']" />
    
        </div>
    </div>
    <div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
    </div>