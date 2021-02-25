@extends('layouts/contentLayoutMaster')

@section('title', 'List Users')

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
    <link rel="stylesheet" href="{{ asset(mix('css/plugins/forms/validation/form-validation.css')) }}">
@endsection

@section('content')
    {{-- Data list view starts --}}
    <section id="data-list-view" class="data-list-view-header">

        <div class="action-btns d-none">
            <div class="btn-dropdown mr-1 mb-1">
                <div class="btn-group dropdown actions-dropodown">
                    <button type="button" class="btn btn-white  px-1 py-1 waves-effect waves-light dropdown-toggle"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Actions
                    </button>

                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#"><i class="feather icon-trash"></i>Delete</a>
                        {{-- <a class="dropdown-item" href="#"><i class="feather icon-archive"></i>Archive</a>
                        <a class="dropdown-item" href="#"><i class="feather icon-file"></i>Print</a>
                        <a class="dropdown-item" href="#"><i class="feather icon-save"></i>Another Action</a> --}}
                    </div>

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
                            <td class="product-name">{{ $user['name'] }}</td>
                            <td class="product-category">{{ $user['email'] }}</td>
                            <td class="product-category">{{ $user['status'] }}</td>
                            <td class="product-action">
                                <span class="action-edit" id="{{ $user->id }}"><i class="feather icon-edit"></i></span>
                                <span class="action-delete"><i class="feather icon-trash"></i></span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- DataTable ends --}}

        {{-- Modal --}}
        <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Create New User </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('users.store') }}" id="form_group" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <label>Username: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Username" class="form-control" name="username">
                            </div>

                            <label>Email: </label>
                            <div class="form-group">
                                <input type="text" placeholder="Email Address" class="form-control" name="email">
                            </div>

                            <label>Password: </label>
                            <div class="form-group">
                                <input type="password" placeholder="Password" class="form-control" name="password">
                            </div>

                            <label>Re-type Password: </label>
                            <div class="form-group">
                                <input type="password" placeholder="Confirm Password" class="form-control"
                                    name="confirm-password">
                            </div>

                            <div class="form-group">
                                <fieldset class="form-group">
                                    <label for="basicInputFile">Photo</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="photo">
                                        <label class="custom-file-label" for="photo">Choose file</label>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" class="close"
                                data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" data-dismiss="modal">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

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
    <script src="{{ asset(mix('js/scripts/modal/components-modal.js')) }}"></script>
@endsection
