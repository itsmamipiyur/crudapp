@extends('layout.master')

@section('title')
  Branch
@endsection

@section('error')
  @if ($alert = Session::get('alert-success'))
    <div class="alert alert-success">
        <strong>{{ $alert }}</strong>
    </div>
  @endif
@endsection

@section('content')

<h2>maintenance/Branch</h2>
<hr size="5">

<button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#create">Add Branch</button>
<br><br>
<div class="pull-right">
  <label class="checkbox-inline">
			<input type="checkbox" id="show_deleted">
			Show Deleted Items
		</label>
</div>
<br>
<!--<a href="{{ url('/branch/create') }}">Add Branch</a><br><br>-->

<div class="panel panel-default">
  <div class="panel-body">
    <table class="table table-hover" id="tblBranch">
      <thead>
        <tr>
          <th>Branch ID</th>
          <th>Branch Name</th>
          <th>Branch Description</th>
          <th>Created At</th>
          <th>Updated At</th>
          <th>Deleted At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @if(count($branches) === 0)
          <tr>
            <td colspan="7" align="center"><strong>Nothing to show</strong></td>
          </tr>
        @else
          @foreach($branches as $branch)
            <tr>
              <td>{{ $branch->id }}</td>
              <td>{{ $branch->branch_name }}</td>
              <td style="word-wrap: break-word;">{{ $branch->branch_desc }}</td>
              <td>{{ $branch->created_at->diffForHumans() }}</td>
              <td>{{ $branch->updated_at->diffForHumans() }}</td>
              <td>{{ $branch->deleted_at }}</td>
              <td class="btn-group clearfix" align="center" nowrap>
                 <button type="button" value="{{ $branch->id }}" class="btn btn-success open-detail"><span class="glyphicon glyphicon-eye-open"></span></button>
                 <a href="#edit{{ $branch->id }}" class="btn btn-info edit-detail" onclick="$('#edit{{$branch->id}}').modal('show')"><span class="glyphicon glyphicon-pencil"></span></a>
                 @if(is_null($branch->deleted_at))
                  <a href="#del{{$branch->id}}" class="btn btn-danger" onclick="$('#del{{$branch->id}}').modal('show')"><span class="glyphicon glyphicon-trash"></span></button>
                 @else
                  <a href="#restore{{$branch->id}}" class="btn btn-warning" onclick="$('#restore{{$branch->id}}').modal('show')"><span class="glyphicon glyphicon-repeat"></span></button>
                @endif
              </td>
            </tr>

            <div id="del{{$branch->id}}" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Delete Branch</h4>
                    </div>
                    <div class="modal-body">
                      <h5>Are you sure to delete <strong>{{ $branch->branch_name }}</strong>?</h5>
                    </div>
                    <div class="modal-footer">

                      {!! Form::open(['url' => '/branch/' . $branch->id, 'method' => 'delete']) !!}
                  			{{ Form::button('Yes', ['type'=>'submit', 'class'=> 'btn btn-danger']) }}
                  		{!! Form::close() !!}
                      <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </div>
              </div>
            </div>

            <div id="restore{{$branch->id}}" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Delete Branch</h4>
                    </div>
                    <div class="modal-body">
                      <h5>Are you sure to restore <strong>{{ $branch->branch_name }}</strong>?</h5>
                    </div>
                    <div class="modal-footer">
                      {!! Form::open(['url' => '/branch/branch_restore']) !!}
                        {{ Form::hidden('branch_id', $branch->id) }}
                  			{{ Form::button('Yes', ['type'=>'submit', 'class'=> 'btn btn-warning']) }}
                  		{!! Form::close() !!}
                      <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </div>
              </div>
            </div>

            <div id="edit{{$branch->id}}" class="modal fade" role="dialog">
              <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update Branch</h4>
                  </div>
                  <div class="modal-body">
                    {!! Form::open(['url' => 'branch/branch_update/']) !!}
                      {{ Form::hidden('branch_id', $branch->id) }}
                      <div class="form-group">
                      {{ Form::label('branch_name', 'Branch Name') }}
                      {{ Form::text('branch_name', $branch->branch_name, ['placeholder' => 'Example: Mongol', 'class' => 'form-control', 'id' => 'name']) }}
                      </div>
                      {{ ($errors->has('branch_name')) ? $errors->first('branch_name') : '' }}
                      <div class="form-group">
                      {{ Form::label('branch_desc', 'Branch Description') }}
                      {{ Form::textarea('branch_desc', $branch->branch_desc, ['placeholder' => 'Type Branch Description', 'class' => 'form-control', 'id' => 'desc']) }}
                      </div>
                      {{ ($errors->has('branch_desc')) ? $errors->first('branch_desc') : '' }}
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
        <h4 class="modal-title">Add Branch</h4>
      </div>
      <div class="modal-body">
        {!! Form::open(['url' => '/branch']) !!}
          <div class="form-group">
          {{ Form::label('branch_name', 'Branch Name') }}
          {{ Form::text('branch_name', '', ['placeholder' => 'Example: Mongol', 'class' => 'form-control']) }}
          </div>
          {{ ($errors->has('branch_name')) ? $errors->first('branch_name') : '' }}
          <div class="form-group">
          {{ Form::label('branch_desc', 'Branch Description') }}
          {{ Form::textarea('branch_desc', '', ['placeholder' => 'Type Branch Description', 'class' => 'form-control']) }}
          </div>
          {{ ($errors->has('branch_desc')) ? $errors->first('branch_desc') : '' }}
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
          {{ Form::label('branch_name', 'Branch Name') }}
          {{ Form::text('branch_name', '', ['placeholder' => 'Example: Mongol', 'class' => 'form-control', 'id' => 'sname', 'disabled' => 'true']) }}
          </div>
          <div class="form-group">
          {{ Form::label('branch_desc', 'Branch Description') }}
          {{ Form::textarea('branch_desc', '', ['placeholder' => 'Type Branch Description', 'class' => 'form-control', 'id' => 'sdesc', 'disabled' => 'true']) }}
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

      var table = $('#tblBranch').DataTable();

      $('#show_deleted').on('change', function () {
				table.draw();
			});

      $.fn.dataTableExt.afnFiltering.push(function (oSettings, aData, iDataIndex) {
				var show_deleted = $('#show_deleted:checked').length;
				if (!show_deleted) return aData[5] == '';
				return true;
			});
			table.draw();

      var url = "{{ url('/branch') }}";
      var bid = 0;

      $('.open-detail').click(function(){
        var id = $(this).val();

        $.get(url + '/' + id, function (data) {
            //success data
            console.log(data);
            $('#sname').val(data.branch_name);
            $('#sdesc').val(data.branch_desc);
            $('#showDetail').modal('show');
        })
      });
    });
  </script>
@endsection
