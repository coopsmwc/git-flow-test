<div class="table-reponsive">
    <table class="table table-hover" id="table-list">
        <thead>
            <tr>
                <th>#</th>
                <th>Organisation</th>
                <th>Link</th>
                <th>Licenses</th>
                <th >Licenses<br>used</th>
                <th >Days left</th>
                <th>Date added</th>
                <th>Alert Status</th>
                <th class="no-sort"></th>
            </tr>
        </thead>
        <tbody>
        @foreach ($list as $key => $item)
            <tr>
                <th scope="row">{{ $key+1 }}</th>
                <td><a href="{{ route('company-company-dashboard', [$item->stub]) }}">{{$item->name}}</a></td>
                <td>{{ $item->stub }}</td>
                <td>{{ $item->licences }}</td>
                <td class="l-percent" id="td-licence-usage"><span>{{ $item->usage() }}</span>&#37;</td>
                <td class="l-percent">{{ $item->licence_status === 'ACTIVE' ? $item->getLicenceDaysLeft() : '--' }}</td>
                <td>{{ $item->created_at }}</td>
                <td>{{ $item->getListStatus() }}</td>
                <td class="table-icons  text-right">
                @if (isset($buttons))
                    @foreach ($buttons as $button => $values)
                    <form method="GET" action="{{ route($button, $item->{$values['column']}) }}">
                        <button type="submit" class="edit-icons" data-toggle="tooltip" data-placement="top" title="{{ __($values['text']) }}"><i class="fas fa-{{ $values['button'] }}" ></i></button>
                    </form>
                    @endforeach
                @endif
                    <form method="GET" action="{{ route($stub.'.edit', [$item->stub, $item->id]) }}">
                        <button type="submit" class="edit-icons"  data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-edit"></i></button>
                    </form>
                    <?php $index['index'] = 'org-'.$item->id ?>
                    @can('delete-company')
                        <span class="tooltip-holder" data-toggle="tooltip" data-placement="top" title="Delete"><button type="submit" class="table-submit" data-toggle="modal" data-target="#delete-confirm-{{ $index['index'] }}"><i class="fas fa-trash"></i></button></span>
                        @include('mmlayouts.view.confirm', $index)
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>