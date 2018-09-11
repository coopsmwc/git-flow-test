<div class="modal fade delete-confirm" id="delete-confirm-{{ $obj->id }}" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Suspend - {{ $obj->name }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to suspend this account?</p>
      </div>
      <div class="modal-footer">
        <form method="POST" id="suspend" action="{{ route('suspend', [$obj->stub]) }}">
            <input type="hidden" name="id" value="{{ $obj->id }}" />
            @csrf
            <button type="submit" class="btn btn-primary btn-custom">Suspend</button>
        </form>
        <button type="button" class="btn btn-secondary btn-custom-secondary cancel" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>