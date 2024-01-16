@extends('layouts.defaultAdmin')
@section('content')
<br>
<div class="container">
  <div class="row justify-content-center">
    @if (Session::has('success'))
    <div class="alert alert-success">
      {{ Session::get('success') }}
    </div>
    @endif
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="card">
            
            <div class="card-header">{{ __('Setting Update') }} <a href="{{ url('/settingHome') }}" style="position: absolute;right: 10px;" class="btn btn-primary btn-sm"><i class="fa-brands fa-product-hunt"></i>Setting</a></div>

            <div class="card-body">
              <form method="POST" action="{{ route('settings.update', $setting->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                  <label for="logo" class="col-md-4 col-form-label text-md-end">{{ __('Logo') }}</label>
                    <div class="col-md-6">
                      <img src="{{asset($setting->logo)}}" style="width:100px; height: 100px;">
                      <input id="logo" type="file" class="form-control @error('logo') is-invalid @enderror" name="logo" value="{{ old('logo', $setting->logo) }}">
                        @error('logo')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                  <label for="favicon" class="col-md-4 col-form-label text-md-end">{{ __('Fav Icon') }}</label>
                    <div class="col-md-6">
                      <img src="{{asset($setting->favicon)}}" style="width:100px; height: 100px;">
                      <input id="favicon" type="file" class="form-control @error('favicon') is-invalid @enderror" name="favicon" value="{{ old('favicon', $setting->favicon) }}">
                        @error('favicon')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                  <label for="footer_copyright" class="col-md-4 col-form-label text-md-end">
                    {{ __('Footer Copyright') }}
                  </label>
                  <div class="col-md-6">
                    <input id="footer_copyright" type="text" class="form-control @error('footer_copyright') is-invalid @enderror" name="footer_copyright" value="{{ old('footer_copyright', $setting->footer_copyright) }}" autocomplete="footer_copyright" autofocus>
                    @error('footer_copyright')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                </div>

              <div class="row mb-3">
                  <label for="contact_address" class="col-md-4 col-form-label text-md-end"> 
                    {{ __('Contact Address') }}
                  </label>
                    <div class="col-md-6">
                      <textarea id="contact_address" type="text" class="ckeditor form-control @error('contact_address') is-invalid @enderror" name="contact_address" value="{{ old('contact_address', $setting->contact_address) }}" autocomplete="contact_address" autofocus></textarea>
                        @error('contact_address')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                  <label for="contact_email" class="col-md-4 col-form-label text-md-end"> 
                    {{ __('Contact Email') }}
                  </label>
                    <div class="col-md-6">
                      <input id="contact_email" type="text" class="form-control @error('contact_email') is-invalid @enderror" name="contact_email" value="{{ old('contact_email', $setting->contact_email) }}" autocomplete="contact_email" autofocus>
                        @error('contact_email')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                  <label for="contact_phone" class="col-md-4 col-form-label text-md-end"> 
                    {{ __('Contact Phone') }}
                  </label>
                    <div class="col-md-6">
                      <input id="contact_phone" type="text" class="form-control @error('contact_phone') is-invalid @enderror" name="contact_phone" value="{{ old('contact_phone', $setting->contact_phone) }}" autocomplete="contact_phone" autofocus>
                        @error('contact_phone')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                    </div>
                </div>

               <div class="row mb-3">
                  <label for="contact_fax" class="col-md-4 col-form-label text-md-end"> 
                    {{ __('Contact Fax') }}
                  </label>
                    <div class="col-md-6">
                      <input id="contact_fax" type="text" class="form-control @error('contact_fax') is-invalid @enderror" name="contact_fax" value="{{ old('contact_fax', $setting->contact_fax) }}" autocomplete="contact_fax" autofocus>
                        @error('contact_fax')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                  <label for="contact_map_iframe" class="col-md-4 col-form-label text-md-end"> 
                    {{ __('Contact Map Iframe') }}
                  </label>
                    <div class="col-md-6">
                      <textarea id="contact_map_iframe" type="text" class="ckeditor form-control @error('contact_map_iframe') is-invalid @enderror" name="contact_map_iframe" value="{{ old('contact_map_iframe', $setting->contact_map_iframe) }}" autocomplete="contact_map_iframe" autofocus></textarea>
                        @error('contact_map_iframe')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                  <label for="receive_email" class="col-md-4 col-form-label text-md-end"> 
                    {{ __('Receive Email') }}
                  </label>
                    <div class="col-md-6">
                      <input id="receive_email" type="text" class="form-control @error('receive_email') is-invalid @enderror" name="receive_email" value="{{ old('receive_email', $setting->receive_email) }}" autocomplete="receive_email" autofocus>
                        @error('receive_email')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                  <label for="receive_email_subject" class="col-md-4 col-form-label text-md-end"> 
                    {{ __('Receive Email Subject') }}
                  </label>
                    <div class="col-md-6">
                      <input id="receive_email_subject" type="text" class="form-control @error('receive_email_subject') is-invalid @enderror" name="receive_email_subject" value="{{ old('receive_email_subject', $setting->receive_email_subject) }}" autocomplete="receive_email_subject" autofocus>
                        @error('receive_email_subject')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                  <label for="receive_email_thank_you_message" class="col-md-4 col-form-label text-md-end">
                    {{ __('Receive Email Thank You Message') }}
                  </label>
                    <div class="col-md-6">
                      <textarea id="receive_email_thank_you_message" type="text" class="ckeditor form-control @error('receive_email_thank_you_message') is-invalid @enderror" name="receive_email_thank_you_message" value="{{ old('receive_email_thank_you_message', $setting->receive_email_thank_you_message) }}" autocomplete="receive_email_thank_you_message" autofocus></textarea>
                        @error('receive_email_thank_you_message')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                  <label for="meta_title_home" class="col-md-4 col-form-label text-md-end"> 
                    {{ __('Meta Title Home') }}
                  </label>
                    <div class="col-md-6">
                      <input id="meta_title_home" type="text" class="form-control @error('meta_title_home') is-invalid @enderror" name="meta_title_home" value="{{ old('meta_title_home', $setting->meta_title_home) }}" autocomplete="meta_title_home" autofocus>
                        @error('meta_title_home')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-0">
                  <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                      <i class="fas fa-floppy-disk"></i>
                      {{ __('setting Update') }}
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection