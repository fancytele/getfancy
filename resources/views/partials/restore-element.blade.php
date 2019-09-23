<div class="modal fade" id="restore-element" tabindex="-1" role="dialog"
     aria-labelledby="restore-element-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <button type="button" class="close mr-3 mt-3"
                        data-dismiss="modal" aria-label="Close">
                    <i class="fe fe-x-circle"></i>
                </button>
                <form action="/" method="POST" class="mb-0">
                    @csrf

                    <div class="d-flex my-3 pl-4 pt-4">
                        <i
                           class="display-4 fe fe-alert-circle mr-3 mt-n2 mt-n3 "></i>
                        <div>
                            <h3 class="mb-0">
                                @lang('Restore')
                                <span
                                      class="element-name text-lowercase"></span>?
                            </h3>
                            <p class="element-detail text-black-50"></p>
                        </div>
                    </div>

                    <div class="d-flex overflow-hidden rounded-bottom">
                        <button type="button"
                                class="btn btn-lg btn-outline-light rounded-0 text-body w-50"
                                data-dismiss="modal">
                            @lang('Cancel')
                        </button>
                        <button type="submit"
                                class="btn btn-lg btn-success ladda-button rounded-0 w-50"
                                data-style="zoom-out">
                            @lang('Restore')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
