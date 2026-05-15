@extends('layouts.app')

@section('content')
<section class="page-hero" style="background-image: url('{{ file_exists(public_path('images/bg-about.jpg')) ? asset('images/bg-about.jpg') : '' }}');">
    <div class="container contact-container slide-up">
        <h2>Contact Me</h2>

        @if(session('success'))
            <div class="alert success">Message sent successfully.</div>
        @endif

        <form action="{{ route('contact.store') }}" method="post" class="contact-form" id="contactForm">
            @csrf
            <label>Name <input type="text" name="name" required value="{{ old('name') }}"></label>
            <label>Email <input type="email" name="email" required value="{{ old('email') }}"></label>
            <label>Subject <input type="text" name="subject" value="{{ old('subject') }}"></label>
            <label>Message <textarea name="message" required>{{ old('message') }}</textarea></label>
            <button type="submit" class="btn" id="contactSubmit">Send Message</button>
        </form>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('contactForm');
    if (!form) return;

    const btn = document.getElementById('contactSubmit');
    form.addEventListener('submit', function () {
        if (btn) {
            btn.classList.add('sending');
            btn.disabled = true;
        }
    });
});
</script>
@endsection
