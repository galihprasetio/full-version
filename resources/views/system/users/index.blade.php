@extends('layouts/contentLayoutMaster')

@section('title', 'List View')

@section('vendor-style')
{{-- vendor files --}}
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/datatables.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/file-uploaders/dropzone.min.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/extensions/dataTables.checkboxes.css')) }}">
@endsection
@section('page-style')
{{-- Page css files --}}
<link rel="stylesheet" href="{{ asset(mix('css/plugins/file-uploaders/dropzone.css')) }}">
<link rel="stylesheet" href="{{ asset(mix('css/pages/data-list-view.css')) }}">
@endsection

@section('content')
{{-- Data list view starts --}}
<section id="data-list-view" class="data-list-view-header">
  <div class="action-btns d-none">
    <div class="btn-dropdown mr-1 mb-1">
      <div class="btn-group dropdown actions-dropodown">
        <button type="button" class="btn btn-white px-1 py-1 dropdown-toggle waves-effect waves-light"
          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Actions
        </button>

      </div>
    </div>
  </div>

  {{-- DataTable starts --}}
  <div class="table-responsive">
    <table class="table data-list-view">
      <thead>
        <tr>
          <th></th>
          <th>Name</th>
          <th>Email</th>
          <th>Status</th>
          <th>Action</th>

        </tr>
      </thead>
      <tbody>
        @foreach ($users as $user)
        <tr>
          <td></td>
          <td class="product-name">{{ $user["name"] }}</td>
          <td class="product-category">{{ $user["email"] }}</td>
          <td class="product-category">{{ $user["status"] }}</td>
          <td class="product-action">
            <span class="action-edit" id="{{$user->id}}"><i class="feather icon-edit"></i></span>
            <span class="action-delete"><i class="feather icon-trash"></i></span>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  {{-- DataTable ends --}}

  {{-- add new sidebar starts --}}
  <div class="add-new-data-sidebar">
    <div class="overlay-bg"></div>
    <div class="add-new-data">
      <form id="user-form"  enctype="multipart/form-data">
        @csrf
        <div class="div mt-2 px-2 d-flex new-data-title justify-content-between">
          <div>
            <h4 class="text-uppercase">Data User</h4>
          </div>
          <div class="hide-data-sidebar">
            <i class="feather icon-x"></i>
          </div>
        </div>
        <div class="data-items pb-3">
          <div class="data-fields px-2 mt-1">
            <div class="row">
              <div class="col-sm-12 data-field-col">
                <label for="data-name">Name</label>
                <input type="text" class="form-control" name="name" id="data-name">
              </div>
              <div class="col-sm-12 data-field-col">
                <label for="data-name">Email Address</label>
                <input type="text" class="form-control" name="email" id="data-email">
                @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <div class="col-sm-12 data-field-col">
                <label for="data-name">Password</label>
                <input type="text" class="form-control" name="password" id="data-password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <div class="col-sm-12 data-field-col">
                <label for="data-name">Confirm Password</label>
                <input type="text" class="form-control" name="password_confirmation" id="data-password-confirm">
              </div>
              <div class="col-sm-12 data-field-col">
                <label for="data-status">Status</label>
                <select class="form-control" id="data-status" name="status">
                  <option value="true">Active</option>
                  <option value="false">Non Active</option>
                </select>
              </div>
              <div class="col-sm-12 data-field-col data-list-upload">
                <fieldset class="form-group">
                  <label for="basicInputFile">Photo</label>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="photo" name="photo">
                    <label class="custom-file-label" for="photo">Choose file</label>
                  </div>
                </fieldset>
              </div>
            </div>
          </div>
        </div>
        <div class="add-data-footer d-flex justify-content-around px-3 mt-2">
          <div class="add-data-btn">
            <input type="submit" class="btn btn-primary" value="Add Data">
          </div>
          <div class="cancel-data-btn">
            <input type="reset" class="btn btn-outline-danger" value="Cancel">
          </div>
        </div>

      </form>
    </div>
  </div>
  {{-- add new sidebar ends --}}
</section>
{{-- Data list view end --}}
@endsection
@section('vendor-script')
{{-- vendor js files --}}
<script src="{{ asset(mix('vendors/js/extensions/dropzone.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/buttons.bootstrap.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.select.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.checkboxes.min.js')) }}"></script>
@endsection
@section('page-script')
{{-- Page js files --}}
<script src="{{ asset(mix('js/scripts/system/user-list-view.js')) }}"></script>
<script type="text/javascript">
  // this is the id of the form
    $("#user-form").submit(function(e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.
    var form = $(this);
    var url = form.attr('users.store');

    $.ajax({
          type: "POST",
          url: url,
          data: form.serialize(), // serializes the form's elements.
          dataType: 'json',
          success: function(data)
          {
            // Swal.fire({
            //   title: 'Error!',
            //   text: 'Do you want to continue',
            //   icon: 'error',
            //   confirmButtonText: 'Cool'
            // })
            // $(".add-new-data").removeClass("show")
            // $(".overlay-bg").removeClass("show")
            alert(data);
          },
          error: function(jqXHR, exception)
          {
            alert('error');
          }
         
        });


    });
</script>
@endsection
