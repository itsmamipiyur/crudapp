@extends('layout.master')

@section('title')
  Product
@endsection

@section('error')
  @if ($alert = Session::get('alert-success'))
    <div class="alert alert-success">
        <strong>{{ $alert }}</strong>
    </div>
  @endif
@endsection

@section('content')

<h2>maintenance/Product</h2>
<hr size="5">

<button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#create">Add Product</button>
<br><br>
<div class="pull-right">
  <label class="checkbox-inline">
			<input type="checkbox" id="show_deleted">
			Show Deleted Items
		</label>
</div>
<br>
<!--<a href="{{ url('/product/create') }}">Add product</a><br><br>-->

<div class="panel panel-default">
  <div class="panel-body">
    <table class="table table-hover" id="tblProduct">
      <thead>
        <tr>
          <th>Product ID</th>
          <th>Product Name</th>
          <th>Product Description</th>
          <th>Category</th>
          <th>Created At</th>
          <th>Updated At</th>
          <th>Deleted At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @if(count($products) === 0)
          <tr>
            <td colspan="7" align="center"><strong>Nothing to show</strong></td>
          </tr>
        @else
          @foreach($products as $product)
            <tr>
              <td>{{ $product->id }}</td>
              <td>{{ $product->product_name }}</td>
              <td style="word-wrap: break-word;">{{ $product->product_desc }}</td>
              <td>{{ $product->category->category_name }}</td>
              <td>{{ $product->created_at->diffForHumans() }}</td>
              <td>{{ $product->updated_at->diffForHumans() }}</td>
              <td>{{ $product->deleted_at }}</td>
              <td class="btn-group clearfix" align="center" nowrap>
                 <button type="button" value="{{ $product->id }}" class="btn btn-success open-detail"><span class="glyphicon glyphicon-eye-open"></span></button>
                 <a href="#edit{{ $product->id }}" class="btn btn-info edit-detail" onclick="$('#edit{{$product->id}}').modal('show')"><span class="glyphicon glyphicon-pencil"></span></a>
                 @if(is_null($product->deleted_at))
                  <a href="#del{{$product->id}}" class="btn btn-danger" onclick="$('#del{{$product->id}}').modal('show')"><span class="glyphicon glyphicon-trash"></span></button>
                 @else
                  <a href="#restore{{$product->id}}" class="btn btn-warning" onclick="$('#restore{{$product->id}}').modal('show')"><span class="glyphicon glyphicon-repeat"></span></button>
                @endif
              </td>
            </tr>

            <div id="del{{$product->id}}" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Delete product</h4>
                    </div>
                    <div class="modal-body">
                      <h5>Are you sure to delete <strong>{{ $product->product_name }}</strong>?</h5>
                    </div>
                    <div class="modal-footer">

                      {!! Form::open(['url' => '/product/' . $product->id, 'method' => 'delete']) !!}
                  			{{ Form::button('Yes', ['type'=>'submit', 'class'=> 'btn btn-danger']) }}
                  		{!! Form::close() !!}
                      <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </div>
              </div>
            </div>

            <div id="restore{{$product->id}}" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Delete product</h4>
                    </div>
                    <div class="modal-body">
                      <h5>Are you sure to restore <strong>{{ $product->product_name }}</strong>?</h5>
                    </div>
                    <div class="modal-footer">
                      {!! Form::open(['url' => '/product/product_restore']) !!}
                        {{ Form::hidden('product_id', $product->id) }}
                  			{{ Form::button('Yes', ['type'=>'submit', 'class'=> 'btn btn-warning']) }}
                  		{!! Form::close() !!}
                      <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </div>
              </div>
            </div>

            <div id="edit{{$product->id}}" class="modal fade" role="dialog">
              <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update product</h4>
                  </div>
                  <div class="modal-body">
                    {!! Form::open(['url' => 'product/product_update/']) !!}
                      {{ Form::hidden('product_id', $product->id) }}
                      <div class="form-group">
                      {{ Form::label('product_name', 'product Name') }}
                      {{ Form::text('product_name', $product->product_name, ['placeholder' => 'Example: Mongol', 'class' => 'form-control', 'id' => 'name']) }}
                      </div>
                      {{ ($errors->has('product_name')) ? $errors->first('product_name') : '' }}
                      <div class="form-group">
                      {{ Form::label('product_desc', 'product Description') }}
                      {{ Form::textarea('product_desc', $product->product_desc, ['placeholder' => 'Type product Description', 'class' => 'form-control', 'id' => 'desc']) }}
                      </div>
                      {{ ($errors->has('product_desc')) ? $errors->first('product_desc') : '' }}
                      <div class="form-group">
                      {{ Form::label('product_category', 'Category') }}
                      {{ Form::select('product_category', $categories, $product->category_id, ['placeholder' => 'Type product Description', 'class' => 'form-control', 'id' => 'category']) }}
                      </div>
                      {{ ($errors->has('product_category')) ? $errors->first('product_category') : '' }}
                      <div class="form-group">
                      {{ Form::label('product_brand', 'Brand') }}
                      {{ Form::select('product_brand', $brands, $product->brand_id, ['placeholder' => 'Choose Product Brand', 'class' => 'form-control', 'id' => 'category']) }}
                      </div>
                      {{ ($errors->has('product_category')) ? $errors->first('product_category') : '' }}
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
        <h4 class="modal-title">Add product</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
        {!! Form::open(['url' => '/#', 'class' => 'validateForm']) !!}
          <div class="control-group">
          {{ Form::label('product_name', 'product Name', ['class' => 'control-label']) }}
          {{ Form::text('product_name', '', ['placeholder' => 'Example: Mongol', 'class' => 'form-control validateProdName', 'title' => 'Opps', 'data-content' => '']) }}
          </div>
          {{ ($errors->has('product_name')) ? $errors->first('product_name') : '' }}
          <div class="control-group">
          {{ Form::label('product_desc', 'product Description', ['class' => 'control-label']) }}
          {{ Form::textarea('product_desc', '', ['placeholder' => 'Type product Description', 'class' => 'form-control']) }}
          </div>
          {{ ($errors->has('product_desc')) ? $errors->first('product_desc') : '' }}
          <div class="control-group">
          {{ Form::label('product_category', 'Category', ['class' => 'control-label']) }}
          {{ Form::select('product_category', $categories, null, ['placeholder' => 'Choose product Description', 'class' => 'form-control', 'id' => 'category']) }}
          </div>
          {{ ($errors->has('product_category')) ? $errors->first('product_category') : '' }}
          <div class="control-group">
          {{ Form::label('product_brand', 'Brand', ['class' => 'control-label']) }}
          {{ Form::select('product_brand', $brands, null, ['placeholder' => 'Choose Product Brand', 'class' => 'form-control', 'id' => 'category']) }}
          </div>
          {{ ($errors->has('product_category')) ? $errors->first('product_category') : '' }}
        </div>
      </div>
      </div>
      <div class="modal-footer">
        <div class="row">
          <div class="col-md-12">
            {{ Form::button('Submit', ['type' => 'submit', 'class' => 'btn btn-info', 'id' => 'btn-save']) }}
          {!! Form::close() !!}
          </div>
        </div>
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
          <div class="control-group">
          {{ Form::label('product_name', 'product Name') }}
          {{ Form::text('product_name', '', ['placeholder' => 'Example: Mongol', 'class' => 'form-control', 'id' => 'sname', 'disabled' => 'true']) }}
          </div>
          <div class="control-group">
          {{ Form::label('product_desc', 'product Description') }}
          {{ Form::textarea('product_desc', '', ['placeholder' => 'Type product Description', 'class' => 'form-control', 'id' => 'sdesc', 'disabled' => 'true']) }}
          </div>
          <div class="control-group">
          {{ Form::label('product_category', 'product Category') }}
          {{ Form::text('product_category', '', ['placeholder' => 'Type product Description', 'class' => 'form-control', 'id' => 'scategory', 'disabled' => 'true']) }}
          </div>
          <div class="control-group">
          {{ Form::label('product_brand', 'product Brand') }}
          {{ Form::text('product_brand', '', ['placeholder' => 'Type product Description', 'class' => 'form-control', 'id' => 'sbrand', 'disabled' => 'true']) }}
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
  $('.open-detail').on("click", function(){
    var id = $(this).val();
    var url = "/product";

    $.get(url + '/' + id, function (data) {
        //success data
        console.log(data);
        $('#sname').val(data.product_name);
        $('#sdesc').val(data.product_desc);
        $('#scategory').val(data.category_name);
        $('#sbrand').val(data.brand_name);
        $('#showDetail').modal('show');
    })
  });

    $(document).ready( function(){
      setTimeout(function(){
          $('.alert').fadeOut("slow");
      }, 2000);

      var table = $('#tblProduct').DataTable();

      $('#show_deleted').on('change', function () {
				table.draw();
			});

      $.fn.dataTableExt.afnFiltering.push(function (oSettings, aData, iDataIndex) {
				var show_deleted = $('#show_deleted:checked').length;
				if (!show_deleted) return aData[6] == '';
				return true;
			});
			table.draw();
    });
  </script>
@endsection
