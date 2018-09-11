<div class="modal fade delete-confirm" id="delete-confirm-{{ $index }}" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p style="white-space: initial; overflow-wrap: break-word; word-wrap: break-word">{{ $item->name }}</p>
        <p>Are you sure you want to delete this entry?</p>
      </div>
      <div class="modal-footer">
        @if (isset($company))
            <form method="POST" action="{{ route($stub.'.destroy', [$company, $item->id]) }}">
        @elseif (in_array(Request::route()->getName(), ['sales-admins']))
            <form method="POST" action="{{ route($stub.'.destroy', [$item->id]) }}">
        @else
            <form method="POST" action="{{ route($stub.'.destroy', [$item->stub, $item->id]) }}">
        @endif
            @method('DELETE')
            @csrf
            <button type="submit" class="btn btn-primary btn-custom">Delete</button>
        </form>
        <button type="button" class="btn btn-secondary btn-custom-secondary cancel" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>