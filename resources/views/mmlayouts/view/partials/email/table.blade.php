<div class="table-reponsive">
    <table class="table table-hover" id="table-list-emails">
        <thead>
            <tr>
                <th>#</th>
                <th>Email Address</th>
                <th>Description</th>
                <th>Date added</th>
                <th class="no-sort"></th>
            </tr>
        </thead>
        <tbody>
        @foreach ($list as $key => $item)
        <?php $item->name = $item->email ?>
            <tr>
                <th scope="row">{{ $key+1 }}</th>
                <td>{{$item->email}}</td>
                <td>{{$item->description}}</td>
                <td>{{$item->created_at}}</td>
                <td class="table-icons  text-right">
                    <form method="GET" action="{{ route($stub.'.edit', [$company, $item->id]) }}">
                        <button type="submit" class="edit-icons"><i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="Edit"></i></button>
                    </form>
                    <?php $index['index'] = 'email-'.$item->id ?>
                    <button type="submit" class="table-submit" data-toggle="modal" data-target="#delete-confirm-{{ $index['index'] }}"><i class="fas fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i></button>
                    @include('mmlayouts.view.confirm', $index)
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>