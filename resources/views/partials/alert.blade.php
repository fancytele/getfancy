<div class="container-fluid">
    <div class="alert alert-{{ $alert['type'] }} alert-dismissible fade show"
         role="alert">
        <h4 class="alert-heading font-weight-normal m-0">
            <i class="fe fe-{{ $alert['icon'] ?? 'check-circle' }} h2 mr-2"></i>
            <span class="align-text-top">
                <strong class="text-capitalize">
                    @lang($alert['title'] ?? $alert['type'])!
                </strong>
                {!! $alert['message'] !!}
            </span>
        </h4>
        <button type="button" class="close" data-dismiss="alert"
                aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
