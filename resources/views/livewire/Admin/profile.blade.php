<?php

use App\Livewire\Admin\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public string $password = '';
    public $DeleteModel = false;

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);
        dd(1);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>


<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:admin.profile.update-profile-information-form />
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <livewire:admin.profile.delete-user-form />
                </div>
            </div>
        </div>
    </div> --}}



    <!--start main wrapper-->
    <main class="main-wrapper">
        <div class="main-content position-relative">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Components</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">User Profile</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary">Settings</button>
                        <button type="button"
                            class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split"
                            data-bs-toggle="dropdown"> <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end"> <a class="dropdown-item"
                                href="javascript:;">Action</a>
                            <a class="dropdown-item" href="javascript:;">Another action</a>
                            <a class="dropdown-item" href="javascript:;">Something else here</a>
                            <div class="dropdown-divider"></div> <a class="dropdown-item" href="javascript:;">Separated
                                link</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--end breadcrumb-->


            <div class="card rounded-4">
                <div class="card-body p-4">
                    <div class="position-relative mb-5">
                        <img src="https://codervent.com/maxton/demo/vertical-menu/assets/images/gallery/profile-cover.png"
                            class="img-fluid rounded-4 shadow" alt="">
                        <div class="profile-avatar position-absolute top-100 start-50 translate-middle">
                            <img src="assets/images/avatars/01.png"
                                class="img-fluid rounded-circle p-1 bg-grd-danger shadow" width="170" height="170"
                                alt="">
                        </div>
                    </div>
                    <div class="profile-info pt-5 d-flex align-items-center justify-content-between">
                        <div class="">
                            <h3>Jhon Deo</h3>
                            <p class="mb-0">Engineer at BB Agency Industry<br>
                                New York, United States</p>
                        </div>
                        <div class="">
                            <a href="javascript:;" class="btn btn-grd-primary rounded-5 px-4"><i
                                    class="bi bi-chat me-2"></i>Send Message</a>
                        </div>
                    </div>
                    <div class="kewords d-flex align-items-center gap-3 mt-4 overflow-x-auto">
                        <button type="button" class="btn btn-sm btn-light rounded-5 px-4">UX Research</button>
                        <button type="button" class="btn btn-sm btn-light rounded-5 px-4">CX Strategy</button>
                        <button type="button" class="btn btn-sm btn-light rounded-5 px-4">Management</button>
                    </div>
                </div>
            </div>


            <livewire:admin.profile.update-profile-information-form />

            <livewire:admin.profile.delete-user-form />

        </div>
    </main>
    <!--end main wrapper-->
</x-app-layout>
