<?php

use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public string $fname = '';
    public string $lname = '';
    public string $email = '';
    public $user = '';
    public string $role = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->user = Auth::user();
        if ($this->user->user_type === 'S') {
            $this->role = 'Super Administator';
        } else {
            $this->role = 'Admin';
        }

        $name = explode(' ', Auth::user()->name);
        $this->fname = $name['0'];
        $this->lname = $name['1'];

        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->fill([
            'name' => $validated['fname'] . ' ' . $validated['lname'],
            'email' => $validated['email'],
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('admin.dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    {{-- <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Admin Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header> --}}

    {{-- <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full" required
                autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" name="email" type="email" class="mt-1 block w-full"
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button wire:click.prevent="sendVerification"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            <x-action-message class="me-3" on="profile-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form> --}}





    <div class="row">
        <div class="col-12 col-xl-8">
            <div class="card rounded-4 border-top border-4 border-primary border-gradient-1">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div class="">
                            <h5 class="mb-0 fw-bold">Edit Profile</h5>
                        </div>
                        {{-- <div class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle-nocaret options dropdown-toggle"
                                data-bs-toggle="dropdown">
                                <span class="material-icons-outlined fs-5">more_vert</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                                <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                                <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                            </ul>
                        </div> --}}
                    </div>
                    <form class="row g-4" wire:submit="updateProfileInformation">
                        <div class="col-md-6">
                            <label for="input1" class="form-label">First Name</label>
                            <input type="text" wire:model="fname" class="form-control" id="input1"
                                placeholder="First Name" required autofocus autocomplete="fname">
                            <x-input-error class="mt-2 text-danger" :messages="$errors->get('fname')" />

                        </div>
                        <div class="col-md-6">
                            <label for="input2" class="form-label">Last Name</label>
                            <input type="text" wire:model="lname" class="form-control" id="input2"
                                placeholder="Last Name" required autofocus autocomplete="lname">
                            <x-input-error class="mt-2 text-danger" :messages="$errors->get('lname')" />

                        </div>

                        <div class="col-md-12">
                            <label for="input4" class="form-label">Email</label>
                            <input type="email" wire:model="email" class="form-control" id="input4" required
                                autocomplete="username">
                            <x-input-error class="mt-2 text-danger" :messages="$errors->get('email')" />

                            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                                <div>
                                    <p class="text-sm mt-2 text-gray-800">
                                        {{ __('Your email address is unverified.') }}

                                        <button wire:click.prevent="sendVerification"
                                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            {{ __('Click here to re-send the verification email.') }}
                                        </button>
                                    </p>

                                    @if (session('status') === 'verification-link-sent')
                                        <p class="mt-2 font-medium text-sm text-green-600">
                                            {{ __('A new verification link has been sent to your email address.') }}
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>
                        @if (!Auth::user()->isAdmin('S'))
                            <div class="col-md-12">
                                <label for="input3" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="input3" placeholder="Phone">
                            </div>
                            {{-- <div class="col-md-12">
                            <label for="input5" class="form-label">Password</label>
                            <input type="password" class="form-control" id="input5">
                        </div> --}}
                            <div class="col-md-12">
                                <label for="input6" class="form-label">DOB</label>
                                <input type="date" class="form-control" id="input6">
                            </div>
                            <div class="col-md-12">
                                <label for="input7" class="form-label">Country</label>
                                <select id="input7" class="form-select">
                                    <option selected="">Choose...</option>
                                    <option>One</option>
                                    <option>Two</option>
                                    <option>Three</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="input8" class="form-label">City</label>
                                <input type="text" class="form-control" id="input8" placeholder="City">
                            </div>
                            {{-- <div class="col-md-4">
                            <label for="input9" class="form-label">State</label>
                            <select id="input9" class="form-select">
                                <option selected="">Choose...</option>
                                <option>One</option>
                                <option>Two</option>
                                <option>Three</option>
                            </select>
                        </div> --}}
                            <div class="col-md-2">
                                <label for="input10" class="form-label">Zip</label>
                                <input type="text" class="form-control" id="input10" placeholder="Zip">
                            </div>
                            <div class="col-md-12">
                                <label for="input11" class="form-label">Address</label>
                                <textarea class="form-control" id="input11" placeholder="Address ..." rows="4" cols="4"></textarea>
                            </div>
                        @endif
                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3">
                                <button type="submit" class="btn btn-grd-primary px-4">Update
                                    Profile</button>
                                <x-action-message class="me-3 text-success" on="profile-updated">
                                    {{ __('Saved.') }}
                                </x-action-message>
                                {{-- <button type="button" class="btn btn-light px-4" wire:click="$refresh">Reset</button> --}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-4">
            <div class="card rounded-4">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div class="">
                            <h5 class="mb-0 fw-bold">About</h5>
                        </div>
                        {{-- <div class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle-nocaret options dropdown-toggle"
                                data-bs-toggle="dropdown">
                                <span class="material-icons-outlined fs-5">more_vert</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                                <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                                <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                            </ul>
                        </div> --}}
                    </div>
                    <div class="full-info">
                        <div class="info-list d-flex flex-column gap-3">
                            <div class="info-list-item d-flex align-items-center gap-3"><span
                                    class="material-icons-outlined">account_circle</span>
                                <p class="mb-0">Full Name:{{ $user->name }} </p>
                            </div>
                            <div class="info-list-item d-flex align-items-center gap-3"><span
                                    class="material-icons-outlined">done</span>
                                <p class="mb-0">Status: active</p>
                            </div>
                            <div class="info-list-item d-flex align-items-center gap-3"><span
                                    class="material-icons-outlined">code</span>
                                <p class="mb-0">Role: {{ $role }}</p>
                            </div>
                            <div class="info-list-item d-flex align-items-center gap-3"><span
                                    class="material-icons-outlined">flag</span>
                                <p class="mb-0">Country: USA</p>
                            </div>
                            <div class="info-list-item d-flex align-items-center gap-3"><span
                                    class="material-icons-outlined">language</span>
                                <p class="mb-0">Language: English</p>
                            </div>
                            <div class="info-list-item d-flex align-items-center gap-3"><span
                                    class="material-icons-outlined">send</span>
                                <p class="mb-0">Email: {{$user->email}}</p>
                            </div>
                            <div class="info-list-item d-flex align-items-center gap-3"><span
                                    class="material-icons-outlined">call</span>
                                <p class="mb-0">Phone: (124) 895-6724</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="card rounded-4">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div class="">
                            <h5 class="mb-0 fw-bold">Accounts</h5>
                        </div>
                        <div class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle-nocaret options dropdown-toggle"
                                data-bs-toggle="dropdown">
                                <span class="material-icons-outlined fs-5">more_vert</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                                <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                                <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="account-list d-flex flex-column gap-4">
                        <div class="account-list-item d-flex align-items-center gap-3">
                            <img src="assets/images/apps/05.png" width="35" alt="">
                            <div class="flex-grow-1">
                                <h6 class="mb-0">Google</h6>
                                <p class="mb-0">Events and Reserch</p>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" checked>
                            </div>
                        </div>
                        <div class="account-list-item d-flex align-items-center gap-3">
                            <img src="assets/images/apps/02.png" width="35" alt="">
                            <div class="flex-grow-1">
                                <h6 class="mb-0">Skype</h6>
                                <p class="mb-0">Events and Reserch</p>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" checked>
                            </div>
                        </div>
                        <div class="account-list-item d-flex align-items-center gap-3">
                            <img src="assets/images/apps/03.png" width="35" alt="">
                            <div class="flex-grow-1">
                                <h6 class="mb-0">Slack</h6>
                                <p class="mb-0">Communication</p>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" checked>
                            </div>
                        </div>
                        <div class="account-list-item d-flex align-items-center gap-3">
                            <img src="assets/images/apps/06.png" width="35" alt="">
                            <div class="flex-grow-1">
                                <h6 class="mb-0">Instagram</h6>
                                <p class="mb-0">Social Network</p>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" checked>
                            </div>
                        </div>
                        <div class="account-list-item d-flex align-items-center gap-3">
                            <img src="assets/images/apps/17.png" width="35" alt="">
                            <div class="flex-grow-1">
                                <h6 class="mb-0">Facebook</h6>
                                <p class="mb-0">Social Network</p>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" checked>
                            </div>
                        </div>
                        <div class="account-list-item d-flex align-items-center gap-3">
                            <img src="assets/images/apps/11.png" width="35" alt="">
                            <div class="flex-grow-1">
                                <h6 class="mb-0">Paypal</h6>
                                <p class="mb-0">Social Network</p>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" checked>
                            </div>
                        </div>
                    </div>



                </div>
            </div> --}}

        </div>
    </div><!--end row-->
</section>
