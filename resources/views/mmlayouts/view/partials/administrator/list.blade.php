@extends('mmlayouts.app')
@section('content')    
    <div class="container-fluid mt-4" id="tabs-container">
        <ul class="nav nav-tabs" id="admintabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="admins-tab" data-toggle="tab" href="#admins" role="tab" aria-controls="admins" aria-selected="true">Account admins</a>
            </li>
        </ul>
        <div class="tab-content pt-4" id="admintabsContent">
            <div class="tab-pane fade show active" id="admins" role="tabpanel" aria-labelledby="home-tab">
                <p><strong>Add or remove administrators on your account.</strong></p>
                {!! $admins !!}
            </div>
        </div>
    </div>
@endsection
