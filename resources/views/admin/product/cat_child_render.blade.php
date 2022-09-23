<div id="" class="cat-filter-section">
    <fieldset class="form-group position-relative has-icon-left">
        <input type="text" class="form-control form-control-sm input-sm filter_category" id="" placeholder="Keyword">
        <div class="form-control-position">
            <i class="la la-search"></i>
        </div>
    </fieldset>
    <ul>
        @foreach ($categories as $category)
        <li data-cat_pk="{{ $category->SUBCATEGORY_ID }}" data-cat_name="{{ $category->SUBCATEGORY_NAME }}" title="{{ $category->SUBCATEGORY_NAME }}" class="{{ isset($selected) && $selected == $category->SUBCATEGORY_ID ? 'cat_li_active clicked' : '' }}">
            <p class="m-0">{{ $category->SUBCATEGORY_NAME }}</p>@if($category->HAS_CHILD == 1)<i class="la la-angle-right" style="float:right;line-height: inherit;"></i>@endif
        </li>
        @endforeach
    </ul>
</div>
