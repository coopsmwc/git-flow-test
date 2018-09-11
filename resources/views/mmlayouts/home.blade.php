@extends('mmlayouts.app')

@section('content')
<div class="content">
                <h2>{{ ucfirst($stub). ' list' }}</h2>
                <div class="create-btn-holder">
                    <button id="btn-create-company" class="btn btn-custom btn-lg btn-block">New organisation</button>
                </div>
                <div class="table-reponsive">
                    <table class="table table-hover" id="table-list">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Organisation</th>
                                <th>Stub</th>
                                <th>Licenses</th>
                                <th >Licenses<br>in use (%)</th>
                                <th>Date added</th>
                                <th>Alert Status</th>
                                <th class="no-sort"></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($list as $item)
                            <tr>
                                <th scope="row">1</th>
                                <td><a href="#">{{$item->name}}</a></td>
                                <td>{{$item->stub}}</td>
                                <td>{{$item->licences}}</td>
                                <td class="l-percent">24</td>
                                <td>{{$item->created_at}}</td>
                                <td>Ready</td>
                                <td class="table-icons">
                                @if (isset($buttons))
                                    @foreach ($buttons as $button => $values)
                                    <form method="GET" action="{{ route($button, $item->{$values['column']}) }}">
                                        <button type="submit"><i class="fas fa-{{ $values['button'] }}" data-toggle="tooltip" data-placement="top" title="{{ __($values['text']) }}"></i></button>
                                    </form>
                                    @endforeach
                                @endif
                                    <form method="GET" action="{{ route($stub.'.edit', [$item->id]) }}">
                                        <button type="submit"><i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="Edit"></i></button>
                                    </form>
                                    <form method="GET" action="{{ route($stub.'.edit', [$item->id]) }}">
                                        <button type="submit"><i class="fas fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="create-btn-holder">
                    <button id="btn-create-company" class="btn btn-custom btn-lg btn-block">New organisation</button>
                </div>
@endsection
