
@extends("admin.layout.app")

@section('style')

<style>
    .permission {
        background-color: white;
        padding: 5px 10px;
        display: inline-block;
        font-size: 15px;
        margin: 10px 10px;
        cursor: pointer;
    }
</style>

@endsection
@section("main_content")

<div class="page-wrapper">

    <div class="page-content">

        <div class="card">
            <div class="card-body p-4">
                <h5 class="card-title">Create New Role</h5>
                <hr/>

                <form action="{{ route('admin.roles.store') }}" method='post'>
                    @csrf

                    <div class="form-body mt-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="border border-3 p-4 rounded">
                                    <div class="mb-3">
                                        <label for="inputProductTitle" class="form-label">Role Name</label>
                                        <input type="text" value='{{ old("name") }}' name='name' required class="form-control" id="inputProductTitle">
                                        @error('name')
                                            <p class='text-danger'>{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="inputProductTitle" class="form-label">Role Permissions</label>
                                        <div class='row'>
                                            @php 
                                                $the_count = count($permissions); 
                                                $start = 0;
                                            @endphp
                                            
                                            @for($j = 1; $j <= 3; $j++)
                                            @php 
                                                $end = round($the_count * ( $j / 3 ));
                                            @endphp
                                            
                                            <div class='col-md-4'>
                                                @for($i = $start; $i < $end; $i++)
                                                    <label class="permission">
                                                       <input type="checkbox" name='permissions[]' value='{{ $permissions[$i]->id }}'> {{ $permissions[$i]->name }}
                                                    </label>    
                                                @endfor
                                            </div>
                                            @php 
                                                $start = $end;
                                            @endphp
                                            @endfor
                                        </div>
                                    </div>
                                    <button class='btn btn-primary' type='submit'>Create Role</button>
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
<script>
    $(document).ready(function () {
        setTimeout(() => {
            $(".general-message").fadeOut();
        }, 5000);
    });
</script>
@endsection