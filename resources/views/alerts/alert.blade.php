{{-- ERRORS MESSAGE --}}
@if ($errors->any())
    <div class="notification-dialog" role="notification">
        <div class="notification-popup">
            <img src="{{ asset('/assets/img/notifications/error.png') }}" alt="success">
            <div class="notification-messages">
                <ul>
                    @php $counter = 0; @endphp
                    @foreach ($errors->all() as $error)
                        @php $counter++; @endphp
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button onclick="closeNotificationPopup()">Okay</button>
        </div>
    </div>
@endif

{{-- session MESSAGE --}}
@if (session()->has('success'))
    <div class="notification-dialog" role="notification">
        <div class="notification-popup">
            <img src="{{ asset('/assets/img/notifications/success.png') }}" alt="success">
            <div class="notification-messages">
                <p class="mt-2">{{ session()->get('success') }}</p>
            </div>
            <button onclick="closeNotificationPopup()">Continue</button>
        </div>
    </div>
@endif

{{-- session MESSAGE --}}
@if (session()->has('info'))
    <div class="notification-dialog" role="notification">
        <div class="notification-popup">
            <img src="{{ asset('/assets/img/notifications/info.png') }}" alt="success">
            <div class="notification-messages">
                <p class="mt-2">{{ session()->get('info') }}</p>
            </div>
            <button onclick="closeNotificationPopup()">Continue</button>
        </div>
    </div>
@endif

{{-- session MESSAGE --}}
@if (session()->has('warning'))
    <div class="notification-dialog" role="notification">
        <div class="notification-popup">
            <img src="{{ asset('/assets/img/notifications/warning.png') }}" alt="success">
            <div class="notification-messages">
                <p class="mt-2">{!! session()->get('warning') !!}</p>
            </div>
            <button onclick="closeNotificationPopup()">Continue</button>
        </div>
    </div>
@endif

{{-- session MESSAGE --}}
@if (session()->has('error'))
    <div class="notification-dialog" role="notification">
        <div class="notification-popup">
            <img src="{{ asset('/assets/img/notifications/error.png') }}" alt="success">
            <div class="notification-messages">
                <p class="mt-2">{{ session()->get('error') }}</p>
            </div>
            <button onclick="closeNotificationPopup()">Continue</button>
        </div>
    </div>
@endif
