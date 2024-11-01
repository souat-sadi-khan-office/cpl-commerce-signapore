@extends('frontend.layouts.app')
@section('title', 'Login ', get_settings('system_name'))
@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/toastr.min.css') }}">
@endpush
@push('breadcrumb')
<div class="breadcrumb_section page-title-mini">
    <div class="custom-container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">
                            <i class="linearicons-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">
                            Account
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        Phone Book
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endpush

@section('content')
<div class="section bg_gray">
	<div class="custom-container">
        <div class="row">
            @include('frontend.customer.partials.sidebar')
            <div class="col-lg-9 col-md-8 dashboard_content">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        @include('frontend.customer.partials.header')
                    </div>

                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h1 style="margin-top: 10px;" class="h5">Phone Book</h1>
                                    </div>
                                    <div class="col-md-4 text-end">  
                                        <a href="{{ route('account.phone-book.create') }}" class="btn btn-sm px-3 py-2 btn-fill-out">
                                            Add New
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <p>You can add multiple phone number from here</p>
                                <ul class="list-group custom-list">
                                    @if ($models)
                                        @foreach ($models as $key => $model)
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <div class="list-text">
                                                            {{ $model->phone_number }}
                                                            @if ($model->is_default)
                                                                <span class="badge bg-success">Success</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        @if ($model->is_verified)
                                                            <span class="badge bg-success">Varified</span>
                                                        @else
                                                            <span class="badge bg-danger">Not Varified</span>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-5 text-end">
                                                        @if (!$model->is_verified)
                                                            <a href="#" class="btn btn-fill-line btn-sm">
                                                                Verify
                                                            </a>
                                                        @endif
                                                        
                                                        <a href="{{ route('account.phone-book.edit', $model->id) }}" class="btn btn-fill-line btn-sm">
                                                            Edit
                                                        </a>

                                                        @if ($key != (count($models) - 1))
                                                            <a id="delete_item" href="javascript:;" data-url="{{ route('account.phone-book.destroy', $model->id) }}" class="btn btn-fill-out btn-sm">
                                                                <i class="ti-trash"></i>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </li>
                                            
                                        @endforeach
                                    @else   
                                        <p>You don't have any phone number</p>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('scripts')
    <script src="{{ asset('backend/assets/js/toastr.min.js') }}"></script>
    <script>
        $(document).on('click', '#delete_item', function(e) {
            e.preventDefault();
            var url = $(this).data('url');
            
            $.ajax({
                url: url,
                method: 'Delete',
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'JSON',
                success: function(data) {

                    if (data.status) {

                        toastr.success(data.message);
                        if (data.load) {
                            setTimeout(function() {
                                window.location.href = "";
                            }, 1000);
                        }

                    } else {
                        toastr.warning(data.message);
                    }
                },
                error: function(data) {
                    var jsonValue = $.parseJSON(data.responseText);
                    const errors = jsonValue.errors
                    var i = 0;
                    $.each(errors, function(key, value) {
                        toastr.error(value);
                        i++;
                    });
                }
            });
        });
    </script>
@endpush