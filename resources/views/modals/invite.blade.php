<div class="modal fade" id="inviteClientModal" tabindex="-1"
     aria-labelledby="inviteClientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="inviteClientForm" method="POST" action="{{ route('invitations.company') }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="inviteClientModalLabel">
                        Invite New Client
                    </h5>
                    <button type="button" class="btn-close"
                            data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="company_name" class="form-label">
                            Company Name
                        </label>
                        <input type="text" name="company_name"
                               id="company_name" class="form-control" placeholder="Enter company name..."
                               value="{{ old('company_name') }}">
                    </div>

                    <div class="mb-3">
                        <label for="admin_email" class="form-label">
                            Admin Email
                        </label>
                        <input type="email" name="admin_email"
                               id="admin_email" class="form-control" placeholder="Enter admin email..."
                               value="{{ old('admin_email') }}">
                    </div>

                    <div id="inviteMessage"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        Send Invitation
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@push('scripts')
<script>

$(function () {
    $('#inviteClientForm').validate({
        ignore: '',

        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },

        rules: {
            company_name: {
                required: true,
                minlength: 2,
                maxlength: 255
            },

            admin_email: {
                required: true,
                email: true
            }
        },

        messages: {
            company_name: {
                required: 'Please enter company name.',
                minlength: 'Company name must be at least 2 characters.',
                maxlength: 'Company name cannot exceed 255 characters.'
            },

            admin_email: {
                required: 'Please enter an admin email address.',
                email: 'Please enter a valid email address.'
            }
        },

        errorElement: 'div',
        errorClass: 'text-danger small',

        submitHandler: function (form) {
            form.submit();
        }
    });
});
</script>
@endpush