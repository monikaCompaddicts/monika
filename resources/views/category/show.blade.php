

<!-- Modal -->
<div id="sub-cat-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Sub Category</h4>
      </div>
      <div class="modal-body">
        {!! Form::open(['id' => 'saveNewCategory', 'method' => 'POST', 'url' => '/saveNewCategory', 'files' => true]) !!}
            {!! Form::hidden('parent_category', '', ['class' => 'form-control']); !!}
            <div class="form-group">
                {!! Form::label('name', 'Category Name') !!}
                {!! Form::text('category_name', '', ['class' => 'form-control']); !!}
            </div>
            <div class="form-group">
                {!! Form::label('image', 'Category Image') !!}
                {!! Form::file('image', array('class' => 'form-control', 'id' => 'cat-image')) !!}
            </div>
            {!! Form::submit('SUBMIT', ['class' => 'btn btn-primary', 'onclick' => 'return validateCategoryForm();']); !!}
        {!! Form::close() !!}
      </div>
      <!--div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div-->
    </div>

  </div>
</div>


<!-- Modal -->
<div id="edit-cat-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Category</h4>
      </div>
      <div class="modal-body">
        {!! Form::open(['id' => 'saveNewCategory', 'method' => 'POST', 'url' => '/saveNewCategory', 'files' => true]) !!}
            {!! Form::hidden('parent_category', '', ['class' => 'form-control']); !!}
            <div class="form-group">
                {!! Form::label('name', 'Category Name') !!}
                {!! Form::text('category_name', '', ['class' => 'form-control']); !!}
            </div>
            <div class="form-group">
                {!! Form::label('image', 'Category Image') !!}
                {!! Form::file('image', array('class' => 'form-control', 'id' => 'cat-image')) !!}
            </div>
            {!! Form::submit('SUBMIT', ['class' => 'btn btn-primary', 'onclick' => 'return validateCategoryForm();']); !!}
        {!! Form::close() !!}
      </div>
      <!--div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div-->
    </div>

  </div>
</div>
    <section class="content-header">
        <h1 class="pull-left">
            Categories
        </h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right add-parent-category add-sub-category" data-toggle="modal" data-target="#sub-cat-modal" title="Add Parent Category" data-id="0" href="#">Add New Category</a>
        </h1>
    </section>
    <div class="content" style="margin-top: 13px;">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px; padding-right: 20px">
                   <?php //echo "<pre>";print_r($categories); ?>
                   @foreach($categories as $category)
                        <?php $count_child_category = DB::table('categories')->where('parent_category', $category->id)->count(); ?>
                        @if($count_child_category > 0)
                            <?php $cursor = 'pointer'; ?>
                        @else
                            <?php $cursor = ''; ?>
                        @endif
                        <div id="category_{{ $category->id }}" class="parentDiv" data-child="{{ $count_child_category }}" data-id="{{ $category->id }}">
                            {{ $category->name }}
                            @if($count_child_category > 0)
                            <span style="float: right;cursor: {{ $cursor }}" class="parentDivChildren" data-child="{{ $count_child_category }}" data-id="{{ $category->id }}"><i class="fas fa-sort-down"></i></span>
                            @endif
                            <span class="add-sub-category" data-toggle="modal" data-target="#sub-cat-modal" title="Add Sub Category" data-id="{{ $category->id }}"><i class="fas fa-plus"></i></span>
                            <span class="edit-category" data-toggle="modal" data-target="#edit-cat-modal" title="Edit Category" data-attr="{{ json_encode($category) }}"><i class="fas fa-edit"></i></span>
                            <span class="delete-this-category" title="Delete Category" data-id="{{ $category->id }}"><i class="fas fa-trash-alt"></i></span>
                        </div>
                   @endforeach
                    <a href="{!! route('tests.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>

