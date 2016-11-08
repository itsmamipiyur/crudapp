@extends('layout.master')

@section('title')
  Brand
@endsection

@section('error')
  @if ($alert = Session::get('alert-success'))
    <div class="alert alert-success">
        <strong>{{ $alert }}</strong>
    </div>
  @endif
@endsection

@section('content')

<h2>maintenance/Brand</h2>
<hr size="5">

<button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#create">Add Brand</button>
<br><br>
<div class="pull-right">
  <label class="checkbox-inline">
			<input type="checkbox" id="show_deleted">
			Show Deleted Items
		</label>
</div>
<br>
<!--<a href="{{ url('/brand/create') }}">Add Brand</a><br><br>-->

<div class="panel panel-default">
  <div class="panel-body">
    <table class="table table-hover" id="tblBrand">
      <thead>
        <tr>
          <th>Brand ID</th>
          <th>Brand Name</th>
          <th>Brand Description</th>
          <th>Created At</th>
          <th>Updated At</th>
          <th>Deleted At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @if(count($brands) === 0)
          <tr>
            <td colspan="7" align="center"><strong>Nothing to show</strong></td>
          </tr>
        @else
          @foreach($brands as $brand)
            <tr>
              <td>{{ $brand->id }}</td>
              <td>{{ $brand->brand_name }}</td>
              <td style="word-wrap: break-word;">{{ $brand->brand_desc }}</td>
              <td>{{ $brand->created_at->diffForHumans() }}</td>
              <td>{{ $brand->updated_at->diffForHumans() }}</td>
              <td>{{ $brand->deleted_at }}</td>
              <td class="btn-group clearfix" align="center" nowrap>
                 <button type="button" value="{{ $brand->id }}" class="btn btn-success open-detail"><span class="glyphicon glyphicon-eye-open"></span></button>
                 <a href="#edit{{ $brand->id }}" class="btn btn-info edit-detail" onclick="$('#edit{{$brand->id}}').modal('show')"><span class="glyphicon glyphicon-pencil"></span></a>
                 @if(is_null($brand->deleted_at))
                  <a href="#del{{$brand->id}}" class="btn btn-danger" onclick="$('#del{{$brand->id}}').modal('show')"><span class="glyphicon glyphicon-trash"></span></button>
                 @else
                  <a href="#restore{{$brand->id}}" class="btn btn-warning" onclick="$('#restore{{$brand->id}}').modal('show')"><span class="glyphicon glyphicon-repeat"></span></button>
                @endif
              </td>
            </tr>

            <div id="del{{$brand->id}}" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Delete Brand</h4>
                    </div>
                    <div class="modal-body">
                      <h5>Are you sure to delete <strong>{{ $brand->brand_name }}</strong>?</h5>
                    </div>
                    <div class="modal-footer">

                      {!! Form::open(['url' => '/brand/' . $brand->id, 'method' => 'delete']) !!}
                  			{{ Form::button('Yes', ['type'=>'submit', 'class'=> 'btn btn-danger']) }}
                  		{!! Form::close() !!}
                      <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </div>
              </div>
            </div>

            <div id="restore{{$brand->id}}" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Delete Brand</h4>
                    </div>
                    <div class="modal-body">
                      <h5>Are you sure to restore <strong>{{ $brand->brand_name }}</strong>?</h5>
                    </div>
                    <div class="modal-footer">
                      {!! Form::open(['url' => '/brand/brand_restore']) !!}
                        {{ Form::hidden('brand_id', $brand->id) }}
                  			{{ Form::button('Yes', ['type'=>'submit', 'class'=> 'btn btn-warning']) }}
                  		{!! Form::close() !!}
                      <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </div>
              </div>
            </div>

            <div id="edit{{$brand->id}}" class="modal fade" role="dialog">
              <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update Brand</h4>
                  </div>
                  <div class="modal-body">
                    {!! Form::open(['url' => 'brand/brand_update/']) !!}
                      {{ Form::hidden('brand_id', $brand->id) }}
                      <div class="form-group">
                      {{ Form::label('brand_name', 'Brand Name') }}
                      {{ Form::text('brand_name', $brand->brand_name, ['placeholder' => 'Example: Mongol', 'class' => 'form-control', 'id' => 'name']) }}
                      </div>
                      {{ ($errors->has('brand_name')) ? $errors->first('brand_name') : '' }}
                      <div class="form-group">
                      {{ Form::label('brand_desc', 'Brand Description') }}
                      {{ Form::textarea('brand_desc', $brand->brand_desc, ['placeholder' => 'Type Brand Description', 'class' => 'form-control', 'id' => 'desc']) }}
                      </div>
                      {{ ($errors->has('brand_desc')) ? $errors->first('brand_desc') : '' }}
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
        <h4 class="modal-title">Add Brand</h4>
      </div>
      <div class="modal-body">
        {!! Form::open(['url' => '/brand']) !!}
          <div class="form-group">
          {{ Form::label('brand_name', 'Brand Name') }}
          {{ Form::text('brand_name', '', ['placeholder' => 'Example: Mongol', 'class' => 'form-control']) }}
          </div>
          {{ ($errors->has('brand_name')) ? $errors->first('brand_name') : '' }}
          <div class="form-group">
          {{ Form::label('brand_desc', 'Brand Description') }}
          {{ Form::textarea('brand_desc', '', ['placeholder' => 'Type Brand Description', 'class' => 'form-control']) }}
          </div>
          {{ ($errors->has('brand_desc')) ? $errors->first('brand_desc') : '' }}
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
          {{ Form::label('brand_name', 'Brand Name') }}
          {{ Form::text('brand_name', '', ['placeholder' => 'Example: Mongol', 'class' => 'form-control', 'id' => 'sname', 'disabled' => 'true']) }}
          </div>
          <div class="form-group">
          {{ Form::label('brand_desc', 'Brand Description') }}
          {{ Form::textarea('brand_desc', '', ['placeholder' => 'Type Brand Description', 'class' => 'form-control', 'id' => 'sdesc', 'disabled' => 'true']) }}
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

      var table = $('#tblBrand').DataTable();

      $('#show_deleted').on('change', function () {
				table.draw();
			});

      $.fn.dataTableExt.afnFiltering.push(function (oSettings, aData, iDataIndex) {
				var show_deleted = $('#show_deleted:checked').length;
				if (!show_deleted) return aData[5] == '';
				return true;
			});
			table.draw();

      var url = "/brand";
      var bid = 0;

      $('.open-detail').click(function(){
        var id = $(this).val();

        $.get(url + '/' + id, function (data) {
            //success data
            console.log(data);
            $('#sname').val(data.brand_name);
            $('#sdesc').val(data.brand_desc);
            $('#showDetail').modal('show');
        })
      });
    });
  </script>
@endsection
