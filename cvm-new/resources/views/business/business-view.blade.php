<div class="modal-body comment-model">
    <form>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-detail">
                            <span>Name</span>
                            <p>{{ $data->name }}</p>
                        </div>
                        <div class="card-detail">
                            <span>Phone Number</span>
                            <p>{{ $data->phone_number }}</p>
                        </div>
                        <div class="card-detail">
                            <span>Address</span>
                            <p>{{ $data->address }}</p>
                        </div>
                        <div class="card-detail">
                            <span>Country</span>
                            <p>{{ $data->country->name }}</p>
                        </div>
                        <div class="card-detail">
                            <span>State</span>
                            <p>{{ $data->state->name }}</p>
                        </div>
                        <div class="card-detail">
                            <span>City</span>
                            <p>{{ $data->city->name }}</p>
                        </div>
                        <div class="card-detail">
                            <span>Pin Code</span>
                            <p>{{ $data->pin_code }}</p>
                        </div>
                        <div class="card-detail">
                            <span>Timezone</span>
                            <p>{{ $data->timezone->timezone }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- ./row -->
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn_style ghost_btn" data-dismiss="modal">
        Close
    </button>
</div>