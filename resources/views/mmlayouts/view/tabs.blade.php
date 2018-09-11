    <div class="container-fluid mt-5 d-none" id="tabs-container">
        <ul class="nav nav-tabs nav-justified" id="admintabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="domains-tab" data-toggle="tab" href="#domains" role="tab" aria-controls="domains" aria-selected="false">Allowed email domains</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="emails-tab" data-toggle="tab" href="#emails" role="tab" aria-controls="emails" aria-selected="false">Allowed email adresses</a>
            </li>
        @can('unsubscribe-user')
            <li class="nav-item">
                <a class="nav-link" id="removeusers-tab" data-toggle="tab" href="#removeusers" role="tab" aria-controls="removeusers" aria-selected="true">Remove users</a>
            </li>
        @endcan
        @can('hr-users-sales')
            <li class="nav-item">
                <a class="nav-link" id="admins-tab" data-toggle="tab" href="#admins" role="tab" aria-controls="admins" aria-selected="true">Account admins</a>
            </li>
        @endcan
        </ul>
        <div class="tab-content pt-4" id="admintabsContent">
        @can('hr-users-sales')
            <div class="tab-pane fade" id="admins" role="tabpanel" aria-labelledby="home-tab">
                <p><strong>Add or remove administrators on your account.</strong></p>
                {!! $admins !!}
            </div>
        @endcan
            <div class="tab-pane fade show active" id="domains" role="tabpanel" aria-labelledby="profile-tab">
                <p><strong>Entering an allowed email domain will enable anyone with that type of email address to create their own My Possible Self account. The domain is the last part of the email address, and is usually specific to your organisation (e.g. mybusiness.com).</strong></p>
                {!! $domains !!}
            </div>
            <div class="tab-pane fade" id="emails" role="tabpanel" aria-labelledby="profile-tab">
                <p><strong>If some of your users have email addresses from external domains (such as gmail.com), you can give them permission to create a My Possible Self account by entering their individuasl email addresses below.</strong></p>
                {!! $emails !!}
            </div>
         @can('unsubscribe-user')   
            <div class="tab-pane fade" id="removeusers" role="tabpanel" aria-labelledby="profile-tab">
                <p><strong>When an end user is no longer eligible to use the service, for example they have left the organisation, you can remove their subscription below. If their email address has recently changed, please enter both their current and any former address, pressing ‘Submit’ after entering each one.</strong></p>
                {!! $remove_users !!}
            </div>
        @endcan
        </div>
    </div>
