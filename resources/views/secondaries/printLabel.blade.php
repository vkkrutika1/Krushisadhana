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
    <br>
      <div class="row">
        <div class="col-lg-12">
          <div class="e-panel card">
            <div class="card-header">{{ __('Add primary') }} <a href="{{ url('/primaries') }}" style="position: absolute;right: 10px;" class="btn btn-primary btn-sm"><i class="fa-brands fa-primaries-hunt"></i>Primary List</a></div>
            <div class="card-body">
              <form method="POST" action="{{ route('primaryprint',$primary->id) }}" enctype="multipart/form-data">
                @csrf               
                  <div class="row">      
                    <div class="col-lg-4 form-group">
                      <label for="">From </label>
                      <input type="text" class="form-control" id=""
                            placeholder="Enter From" name="from" requried>
                        @error('from')
                        <p class='text-danger inputerror'>{{ $message }} </p>
                        @enderror
                    </div>
                    <div class="col-lg-4 form-group">
                      <label for=""> To </label>
                      <input type="text" class="form-control" id=""
                            placeholder="Enter To" name="to" required>
                      @error('to')
                        <p class='text-danger inputerror'>{{ $message }} </p>
                      @enderror
                    </div>
                    <div class="col-lg-4 form-group">
                        <label for=""> Total Primary Labels Available </label>
                        <input type="text" class="form-control" id=""
                            placeholder="Enter To" value="{{ $primary->quantity }}" readonly>
                    </div>                                 
                  </div>
                <button type="submit" formtarget="_blank" class="btn btn-primary">Save</button>
              </form>
            </div>
          </div>
        </div>
      </div> 
  </div>
</div>
@endsection