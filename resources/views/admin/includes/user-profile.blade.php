<div class="card card-plain h-100">
    <div class="card-header pb-0 p-3">
        <div class="row">
            <div class="col-md-8 d-flex align-items-center">
                <h6 class="mb-3">Profile</h6>
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
        
        <form method='POST' action='{{ route('users.update',$user->id) }}'>
            @csrf
            @method('put')
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
                <div class="mb-3 col-md-6">
                    <label class="form-label">Company Name</label>
                    <input type="text" name="company_name" class="form-control border border-2 p-2" value='{{ old('comapany_name', auth()->user()->UserProfile->company_name) }}'>
                    @error('company_name')
                <p class='text-danger inputerror'>{{ $message }} </p>
                @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control border border-2 p-2" value='{{ old('phone', auth()->user()->UserProfile->phone) }}'>
                    @error('phone')
                <p class='text-danger inputerror'>{{ $message }} </p>
                @enderror
                </div>
                <div class="mb-3 col-md-12">
                    <label for="floatingTextarea2">Address</label>
                    <textarea class="form-control border border-2 p-2"
                        placeholder="Company Address" id="floatingTextarea2" name="company_address"
                        rows="4" cols="50">{{ old('company_address', auth()->user()->UserProfile->company_address) }}</textarea>
                        @error('company_address')
                        <p class='text-danger inputerror'>{{ $message }} </p>
                        @enderror
                </div>
                
               
                <div class="mb-3 col-md-6">
                    <label class="form-label">State</label>
                    <input type="text" name="company_state" class="form-control border border-2 p-2" value='{{ old('company_state', auth()->user()->UserProfile->company_state) }}'>
                    @error('company_state')
                    <p class='text-danger inputerror'>{{ $message }} </p>
                    @enderror
                </div>

                
                <div class="mb-3 col-md-6">
                    <label class="form-label">PinCode</label>
                    <input type="text" name="company_pincode" class="form-control border border-2 p-2" value='{{ old('company_pincode', auth()->user()->UserProfile->company_pincode) }}'>
                    @error('company_pincode')
                    <p class='text-danger inputerror'>{{ $message }} </p>
                    @enderror
                </div>

                <div class="mb-3 col-md-6">
                    <label class="form-label">License Number</label>
                    <input type="LicenseNumber" name="LicenseNumber" class="form-control border border-2 p-2" value='{{ old('phone', auth()->user()->UserProfile->LicenseNumber) }}'>
                    @error('LicenseNumber')
                    <p class='text-danger inputerror'>{{ $message }} </p>
                    @enderror
                </div>

                
                <div class="mb-3 col-md-6">
                    <label class="form-label">CIBRegistrationCertificate</label>
                    <input type="text" name="CIBRegistrationCertificate" class="form-control border border-2 p-2" value='{{ old('location', auth()->user()->UserProfile->CIBRegistrationCertificate) }}'>
                    @error('CIBRegistrationCertificate')
                    <p class='text-danger inputerror'>{{ $message }} </p>
                    @enderror
                </div>
                
                
            </div>
            <button type="submit" class="btn bg-gradient-dark">Submit</button>
        </form>

    </div>
</div>