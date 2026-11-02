@extends('layouts.app')

@section('title', 'My Profile')
@section('page_heading', 'My Profile')
@section('page_subtitle', 'Manage your personal information and account security.')

@section('content')

<div class="profile-page">

    {{-- Personal Information --}}
    <div class="content-card profile-card mb-4">

        <div class="profile-card-header">
            <div class="profile-section-icon">
                <i class="bi bi-person-lines-fill"></i>
            </div>

            <div>
                <h5 class="profile-card-title">Personal Information</h5>
                <p class="profile-card-description">
                    Update your name, email address, and view your account role.
                </p>
            </div>
        </div>

        <div class="profile-divider"></div>

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="profile-form-group">
                <label for="name" class="profile-label">
                    Full Name <span class="required-mark">*</span>
                </label>

                <input
                    type="text"
                    name="name"
                    id="name"
                    class="form-control profile-input @error('name') is-invalid @enderror"
                    value="{{ old('name', $user->name) }}"
                    placeholder="Enter your full name"
                    maxlength="255"
                    autocomplete="name"
                    required
                >

                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="profile-form-group">
                <label for="email" class="profile-label">
                    Email Address <span class="required-mark">*</span>
                </label>

                <input
                    type="email"
                    name="email"
                    id="email"
                    class="form-control profile-input @error('email') is-invalid @enderror"
                    value="{{ old('email', $user->email) }}"
                    placeholder="Enter your email address"
                    maxlength="255"
                    autocomplete="email"
                    required
                >

                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="profile-card-footer">
                <button type="submit" class="btn profile-save-btn">
                    <i class="bi bi-check2-circle me-2"></i>
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    {{-- Change Password --}}
    <div class="content-card profile-card">

        <div class="profile-card-header">
            <div class="profile-section-icon password-icon">
                <i class="bi bi-shield-lock"></i>
            </div>

            <div>
                <h5 class="profile-card-title">Change Password</h5>
                <p class="profile-card-description">
                    Update your password to help keep your account secure.
                </p>
            </div>
        </div>

        <div class="profile-divider"></div>

        <div class="password-security-note">
            <i class="bi bi-info-circle-fill"></i>
            <span>
                Enter your current password before setting a new password.
                Your new password must contain at least 8 characters.
            </span>
        </div>

        <form
            action="{{ route('profile.password.update') }}"
            method="POST"
            class="mt-4"
        >
            @csrf
            @method('PUT')

            <div class="profile-form-group">
                <label for="current_password" class="profile-label">
                    Current Password <span class="required-mark">*</span>
                </label>

                <input
                    type="password"
                    name="current_password"
                    id="current_password"
                    class="form-control profile-input @error('current_password') is-invalid @enderror"
                    placeholder="Enter your current password"
                    autocomplete="current-password"
                    required
                >

                @error('current_password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="profile-form-group">
                <label for="password" class="profile-label">
                    New Password <span class="required-mark">*</span>
                </label>

                <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control profile-input @error('password') is-invalid @enderror"
                    placeholder="Enter your new password"
                    minlength="8"
                    autocomplete="new-password"
                    required
                >

                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                <small class="profile-help-text">
                    Use at least 8 characters.
                </small>
            </div>

            <div class="profile-form-group">
                <label for="password_confirmation" class="profile-label">
                    Confirm New Password <span class="required-mark">*</span>
                </label>

                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    class="form-control profile-input"
                    placeholder="Re-enter your new password"
                    minlength="8"
                    autocomplete="new-password"
                    required
                >
            </div>

            <div class="profile-card-footer">
                <button type="submit" class="btn profile-save-btn">
                    <i class="bi bi-key me-2"></i>
                    Update Password
                </button>
            </div>
        </form>
    </div>

</div>

@endsection


@push('styles')
<style>
    /* Main Profile Page */
    .profile-page {
        width: 100%;
        max-width: 850px;
        margin: 0 auto;
        padding: 6px 10px 30px;
        color: var(--orderly-text, #211b35);
    }

    /* Profile Header */
    .profile-welcome-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 22px 24px;
        overflow: hidden;
        border: 1px solid #e9e2fb;
        border-radius: 16px;
        background: linear-gradient(120deg, #ffffff 0%, #f4efff 100%);
    }

    .profile-welcome-content {
        display: flex;
        align-items: center;
        gap: 16px;
        min-width: 0;
    }

    

    .profile-eyebrow {
        display: block;
        margin-bottom: 6px;
        color: #7253cc;
        font-size: 9px;
        font-weight: 800;
        letter-spacing: 1.4px;
    }

    .profile-welcome-text h4 {
        margin-bottom: 5px;
        color: #211b35;
        font-size: 19px;
        font-weight: 750;
        overflow-wrap: anywhere;
    }

    .profile-welcome-text p {
        margin-bottom: 9px;
        color: #858096;
        font-size: 12px;
        overflow-wrap: anywhere;
    }

    .profile-role-badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 10px;
        border: 1px solid #e3d9ff;
        border-radius: 30px;
        background: #ffffff;
        color: #6242bd;
        font-size: 10px;
        font-weight: 700;
    }

    .profile-welcome-icon {
        flex-shrink: 0;
        padding-right: 8px;
        color: #d7caf9;
        font-size: 48px;
    }

    /* Profile Cards */
    .profile-card {
        width: 100%;
        padding: 22px 24px;
        border: 1px solid var(--orderly-border, #eeeaf5);
        border-radius: 15px;
        background: #ffffff;
        box-shadow: 0 3px 12px rgba(38, 24, 75, 0.025);
    }

    .profile-card-header {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .profile-section-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        flex-shrink: 0;
        border-radius: 12px;
        background: #f0eaff;
        color: #7138e5;
        font-size: 19px;
    }

    .password-icon {
        background: #e7f7ef;
        color: #198754;
    }

    .profile-card-title {
        margin: 0 0 5px;
        color: #211b35;
        font-size: 14px;
        font-weight: 750;
    }

    .profile-card-description {
        margin: 0;
        color: #858096;
        font-size: 11px;
        line-height: 1.6;
    }

    .profile-divider {
        height: 1px;
        margin: 18px 0;
        background: #f0edf6;
    }

    /* Compact Form Layout */
    .profile-form-group {
        width: 100%;
        max-width: 480px;
        margin-bottom: 18px;
    }

    .profile-label {
        display: block;
        margin-bottom: 7px;
        color: #39324d;
        font-size: 12px;
        font-weight: 700;
    }

    .required-mark {
        color: #dc3545;
    }

    .profile-input {
        width: 100%;
        min-height: 42px;
        padding: 10px 12px;
        border: 1px solid #e6e2ef;
        border-radius: 8px;
        background: #ffffff;
        color: #211b35;
        font-size: 12px;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .profile-input::placeholder {
        color: #aaa5b8;
        font-size: 11px;
    }

    .profile-input:focus {
        border-color: #9274e8;
        box-shadow: 0 0 0 3px rgba(113, 56, 229, 0.09);
    }

    .profile-input.is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.08);
    }

    .profile-help-text {
        display: block;
        margin-top: 7px;
        color: #8b859b;
        font-size: 10px;
        line-height: 1.6;
    }

    /* Password Notice */
    .password-security-note {
        display: flex;
        align-items: flex-start;
        gap: 9px;
        width: 100%;
        max-width: 480px;
        padding: 11px 13px;
        border: 1px solid #e5ddff;
        border-radius: 9px;
        background: #f8f5ff;
        color: #66558e;
        font-size: 11px;
        line-height: 1.7;
    }

    .password-security-note i {
        margin-top: 2px;
        color: #7955d8;
        font-size: 14px;
    }

    /* Form Footer */
    .profile-card-footer {
        display: flex;
        justify-content: flex-start;
        margin-top: 18px;
        padding-top: 16px;
        border-top: 1px solid #f0edf6;
    }

    .profile-save-btn {
        min-height: 39px;
        padding: 10px 16px;
        border: 1px solid #7138e5;
        border-radius: 8px;
        background: #7138e5;
        color: #ffffff;
        font-size: 11px;
        font-weight: 700;
        transition: background 0.2s, transform 0.2s;
    }

    .profile-save-btn:hover {
        border-color: #5926c4;
        background: #5926c4;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .profile-save-btn:focus-visible {
        outline: 3px solid rgba(113, 56, 229, 0.25);
        outline-offset: 2px;
    }

    .profile-alert {
        border-radius: 9px;
        font-size: 12px;
    }

    /* Mobile Responsive */
    @media (max-width: 767.98px) {
        .profile-page {
            padding: 0 4px 20px;
        }

        .profile-welcome-card {
            padding: 18px;
        }

        .profile-welcome-content {
            gap: 13px;
        }

        .profile-avatar {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            font-size: 21px;
        }

        .profile-welcome-text h4 {
            font-size: 16px;
        }

        .profile-welcome-icon {
            display: none;
        }

        .profile-card {
            padding: 18px;
        }

        .profile-form-group,
        .password-security-note {
            max-width: 100%;
        }

        .profile-card-footer {
            justify-content: stretch;
        }

        .profile-save-btn {
            width: 100%;
        }
    }

    @media (max-width: 420px) {
        .profile-welcome-card {
            padding: 15px;
        }

        .profile-welcome-content {
            align-items: flex-start;
            gap: 11px;
        }

        .profile-avatar {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            font-size: 19px;
        }

        .profile-welcome-text h4 {
            font-size: 15px;
        }

        .profile-welcome-text p {
            font-size: 11px;
        }

        .profile-card {
            padding: 15px;
        }

        .profile-section-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            font-size: 17px;
        }

        .profile-card-header {
            gap: 10px;
        }

        .profile-card-title {
            font-size: 13px;
        }
    }
</style>
@endpush
