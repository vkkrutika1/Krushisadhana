<select name="ItemCategoryID" class="form-control" id="ItemCategoryID">
  <option value="">Choose Category</option>
  @if ($categories)
  @foreach ($categories as $category)
  <option value="{{ $category->ItemCategoryID }}">{{ $category->ItemCategoryName }}</option>
  @endforeach
  @endif
</select>