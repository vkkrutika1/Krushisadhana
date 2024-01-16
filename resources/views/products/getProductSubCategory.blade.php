<select name="SubCategoryID" id="SubCategoryID" class="form-control">
  <option value="">Choose SubCategory</option>
  @if ($subcategories)
  @foreach ($subcategories as $subcategory)
  <option value="{{ $subcategory->SubCategoryID }}">{{ $subcategory->SubCategoryName }}</option>
  @endforeach
  @endif
</select>