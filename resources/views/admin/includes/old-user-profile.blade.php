<div class="card card-plain h-100">
    <div class="card-header pb-0 p-3">
        <div class="row">
            <div class="col-md-8 d-flex align-items-center">
                <h6 class="mb-3">Profile Information</h6>
            </div>
        </div>
    </div>
    <div class="card-body p-3">
        @if (session('status'))
        <div class="row">
            <div class="alert alert-success alert-dismissible text-white" role="alert">
                <span class="text-sm">{{ Session::get('status') }}</span>
                <button type="button" class="btn-close text-lg py-3 opacity-10"
                    data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        @endif
        
        <form method='POST' action='{{ route("user-profile") }}'>
            @csrf
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label class="form-label">Email address</label>
                    <input type="email" name="email" class="form-control border border-2 p-2" value='{{ old('email', auth()->user()->email) }}'>
                    @error('email')
                <p class='text-danger inputerror'>{{ $message }} </p>
                @enderror
                </div>
                
                <div class="mb-3 col-md-6">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control border border-2 p-2" value='{{ old('name', auth()->user()->name) }}'>
                    @error('name')
                <p class='text-danger inputerror'>{{ $message }} </p>
                @enderror
                </div>
            </div>
            <button type="submit" class="btn bg-gradient-dark">Submit</button>
        </form>

    </div>
</div>