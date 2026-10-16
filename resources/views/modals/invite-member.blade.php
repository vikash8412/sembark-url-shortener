<div class="modal fade" id="inviteMemberModal" tabindex="-1"
     aria-labelledby="inviteMemberModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="inviteMemberForm" method="POST" action="{{ route('invitations.team') }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="inviteMemberModalLabel">
                        Invite New Team Member
                    </h5>
                    <button type="button" class="btn-close"
                            data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="member_name" class="form-label">Name</label>
                        <input type="text" name="name" id="member_name"
                               class="form-control" placeholder="User Name"
                               value="{{ old('name') }}">
                    </div>

                    <div class="mb-3">
                        <label for="member_email" class="form-label">Email</label>
                        <input type="email" name="email" id="member_email"
                               class="form-control" placeholder="ex. sample@example.com"
                               value="{{ old('email') }}">
                    </div>

                    <div class="mb-3">
                        <label for="member_role" class="form-label">Role</label>
                        <select name="role" id="member_role" class="form-select">
                            <option value="member" @selected(old('role') === 'member')>Member</option>
                            <option value="admin" @selected(old('role') === 'admin')>Admin</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-sm"
                            data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-app">
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
    $('#inviteMemberForm').validate({
        rules: {
            name: { required: true, maxlength: 255 },
            email: { required: true, email: true },
            role: { required: true }
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
