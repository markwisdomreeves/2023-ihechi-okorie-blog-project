
@extends("admin.layout.app")

@section("style")

<link href="{{ asset('admin_dist/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('admin_dist/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />

@endsection
    
@section("main_content")

<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">

        <div class="card">
            <div class="card-body p-4">
                <h5 class="card-title">Create New User</h5>
                <hr/>
                <form action="{{ route('admin.users.store') }}" method='post' enctype='multipart/form-data'>
                    @csrf

                    <div class="form-body mt-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="border border-3 p-4 rounded">

                                    <div class="mb-3">
                                        <label for="input_name" class="form-label">Name</label>
                                        <input name='name' type='text' class="form-control" id="input_name" value='{{ old("name") }}'>
                                    
                                        @error('name')
                                            <p class='text-danger'>{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="input_email" class="form-label">Email</label>
                                        <input name='email' type='email' class="form-control" id="input_email" value='{{ old("email") }}'>
                                    
                                        @error('email')
                                            <p class='text-danger'>{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="input_password" class="form-label">Password</label>
                                        <input name='password' type='password' class="form-control" id="input_password">
                                    
                                        @error('password')
                                            <p class='text-danger'>{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="input_image" class="form-label">Image</label>
                                        <input name='image' type='file' class="form-control" id="input_image">
                                    
                                        @error('image')
                                            <p class='text-danger'>{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="inputProductTitle" class="form-label">User Role</label>
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="rounded">
                                                    <div class="mb-3">
                                                        <select required name='role_id' class="single-select">
                                                            @foreach($roles as $key => $role)
                                                            <option value="{{ $key }}">{{ $role }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('role_id')
                                                            <p class='text-danger'>{{ $message }}</p>
                                                        @enderror

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class='btn btn-primary' type='submit'>Create New User</button>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section("script")

<script src="{{ asset('admin_dist/plugins/select2/js/select2.min.js') }}"></script>

<script>
$(document).ready(function () {
    $('.single-select').select2({
        theme: 'bootstrap4',
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        allowClear: Boolean($(this).data('allow-clear')),
    });

    setTimeout(() => {
        $(".general-message").fadeOut();
    }, 5000);

});
</script>
@endsection