<div class="table-reponsive">
    <table class="table table-hover" id="table-list">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Date added</th>
                <th>Role</th>
                <th class="no-sort"></th>
            </tr>
        </thead>
        <tbody>
        @foreach ($list as $key => $item)
            <tr>
                <th scope="row">{{ $key+1 }}</th>
                <td>{{ $item->name }}</td>
                <td>{{ $item->email }}</td>
                <td>{{$item->created_at}}</td>
                <td>{{ $roles[$item->type] }}</td>
                <td class="table-icons text-right">
                    <form method="GET" action="{{ route($stub.'.edit', [$item->id]) }}">
                        <button type="submit" class="edit-icons"><i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="Edit"></i></button>
                    </form>
                    <?php $index['index'] = 'sales-'.$item->id ?>
                    @if (Auth::user())
                        @if (Auth::user()->id !== $item->id)
                            <button type="submit" class="table-submit" data-toggle="modal" data-target="#delete-confirm-{{ $index['index'] }}"><i class="fas fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i></button>
                            @include('mmlayouts.view.confirm', $index)
                        @else
                            <button type="submit" class="table-submit" data-toggle="modal" data-target="#delete-confirm-{{ $index['index'] }}" disabled><i style="margin-left:15px;" class="fas" data-toggle="tooltip" data-placement="top" title="Delete"></i></button>
                        @endif
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
