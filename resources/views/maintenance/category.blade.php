@extends('layout.master')

@section('title')
  Category
@endsection

@section('error')
  @if ($alert = Session::get('alert-success'))
    <div class="alert alert-success">
        <strong>{{ $alert }}</strong>
    </div>
  @endif
@endsection

@section('content')

<h2>maintenance/Category</h2>
<hr size="5">

<button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#create">Add category</button>
<br><br>
<div class="pull-right">
  <label class="checkbox-inline">
			<input type="checkbox" id="show_deleted">
			Show Deleted Items
		</label>
</div>
<br>
<!--<a href="{{ url('/category/create') }}">Add category</a><br><br>-->

<div class="panel panel-default">
  <div class="panel-body">
    <table class="table table-hover" id="tblCategory">
      <thead>
        <tr>
          <th>Category ID</th>
          <th>Category Name</th>
          <th>Category Description</th>
          <th>Created At</th>
          <th>Updated At</th>
          <th>Deleted At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @if(count($categories) === 0)
          <tr>
            <td colspan="7" align="center"><strong>Nothing to show</strong></td>
          </tr>
        @else
          @foreach($categories as $category)
            <tr>
              <td>{{ $category->id }}</td>
              <td>{{ $category->category_name }}</td>
              <td style="word-wrap: break-word;">{{ $category->category_desc }}</td>
              <td>{{ $category->created_at->diffForHumans() }}</td>
              <td>{{ $category->updated_at->diffForHumans() }}</td>
              <td>{{ $category->deleted_at }}</td>
              <td class="btn-group clearfix" align="center" nowrap>
                 <button type="button" value="{{ $category->id }}" class="btn btn-success open-detail"><span class="glyphicon glyphicon-eye-open"></span></button>
                 <a href="#edit{{ $category->id }}" class="btn btn-info edit-detail" onclick="$('#edit{{$category->id}}').modal('show')"><span class="glyphicon glyphicon-pencil"></span></a>
                 @if(is_null($category->deleted_at))
                  <a href="#del{{$category->id}}" class="btn btn-danger" onclick="$('#del{{$category->id}}').modal('show')"><span class="glyphicon glyphicon-trash"></span></button>
                 @else
                  <a href="#restore{{$category->id}}" class="btn btn-warning" onclick="$('#restore{{$category->id}}').modal('show')"><span class="glyphicon glyphicon-repeat"></span></button>
                @endif
              </td>
            </tr>

            <div id="del{{$category->id}}" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Delete category</h4>
                    </div>
                    <div class="modal-body">
                      <h5>Are you sure to delete <strong>{{ $category->category_name }}</strong>?</h5>
                    </div>
                    <div class="modal-footer">

                      {!! Form::open(['url' => '/category/' . $category->id, 'method' => 'delete']) !!}
                  			{{ Form::button('Yes', ['type'=>'submit', 'class'=> 'btn btn-danger']) }}
                  		{!! Form::close() !!}
                      <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </div>
              </div>
            </div>

            <div id="restore{{$category->id}}" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Delete category</h4>
                    </div>
                    <div class="modal-body">
                      <h5>Are you sure to restore <strong>{{ $category->category_name }}</strong>?</h5>
                    </div>
                    <div class="modal-footer">
                      {!! Form::open(['url' => '/category/category_restore']) !!}
                        {{ Form::hidden('category_id', $category->id) }}
                  			{{ Form::button('Yes', ['type'=>'submit', 'class'=> 'btn btn-warning']) }}
                  		{!! Form::close() !!}
                      <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </div>
              </div>
            </div>

            <div id="edit{{$category->id}}" class="modal fade" role="dialog">
              <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update category</h4>
                  </div>
                  <div class="modal-body">
                    {!! Form::open(['url' => '/category/category_update']) !!}
                      {{ Form::hidden('category_id', $category->id) }}
                      <div class="form-group">
                      {{ Form::label('category_name', 'category Name') }}
                      {{ Form::text('category_name', $category->category_name, ['placeholder' => 'Example: Mongol', 'class' => 'form-control', 'id' => 'name']) }}
                      </div>
                      {{ ($errors->has('category_name')) ? $errors->first('category_name') : '' }}
                      <div class="form-group">
                      {{ Form::label('category_desc', 'category Description') }}
                      {{ Form::textarea('category_desc', $category->category_desc, ['placeholder' => 'Type category Description', 'class' => 'form-control', 'id' => 'desc']) }}
                      </div>
                      {{ ($errors->has('category_desc')) ? $errors->first('category_desc') : '' }}
                  </div>
                  <div class="modal-footer">
                    {{ Form::button('Update', ['type' => 'submit', 'class' => 'btn btn-info', 'id' => 'btn-save']) }}
                  {!! Form::close() !!}
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        @endif
      </tbody
    </table>
  </div>
</div>

<!-- Modal -->
<div id="create" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add category</h4>
      </div>
      <div class="modal-body">
        {!! Form::open(['url' => '/category']) !!}
          <div class="form-group">
          {{ Form::label('category_name', 'category Name') }}
          {{ Form::text('category_name', '', ['placeholder' => 'Example: Mongol', 'class' => 'form-control']) }}
          </div>
          {{ ($errors->has('category_name')) ? $errors->first('category_name') : '' }}
          <div class="form-group">
          {{ Form::label('category_desc', 'category Description') }}
          {{ Form::textarea('category_desc', '', ['placeholder' => 'Type category Description', 'class' => 'form-control']) }}
          </div>
          {{ ($errors->has('category_desc')) ? $errors->first('category_desc') : '' }}
      </div>
      <div class="modal-footer">
        {{ Form::button('Submit', ['type' => 'submit', 'class' => 'btn btn-info', 'id' => 'btn-save']) }}
      {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div id="showDetail" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Show Detail</h4>
      </div>
      <div class="modal-body">
          <div class="form-group">
          {{ Form::label('category_name', 'category Name') }}
          {{ Form::text('category_name', '', ['placeholder' => 'Example: Mongol', 'class' => 'form-control', 'id' => 'sname', 'disabled' => 'true']) }}
          </div>
          <div class="form-group">
          {{ Form::label('category_desc', 'category Description') }}
          {{ Form::textarea('category_desc', '', ['placeholder' => 'Type category Description', 'class' => 'form-control', 'id' => 'sdesc', 'disabled' => 'true']) }}
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('js')
  <script>
    $(document).ready( function(){
      setTimeout(function(){
          $('.alert').fadeOut("slow");
      }, 2000);

      var table = $('#tblCategory').DataTable();

      $('#show_deleted').on('change', function () {
				table.draw();
			});

      $.fn.dataTableExt.afnFiltering.push(function (oSettings, aData, iDataIndex) {
				var show_deleted = $('#show_deleted:checked').length;
				if (!show_deleted) return aData[5] == '';
				return true;
			});
			table.draw();

      var url = "/category";
      var bid = 0;

      $('.open-detail').click(function(){
        var id = $(this).val();

        $.get(url + '/' + id, function (data) {
            //success data
            console.log(data);
            $('#sname').val(data.category_name);
            $('#sdesc').val(data.category_desc);
            $('#showDetail').modal('show');
        })
      });
    });
  </script>
@endsection
