@extends('layouts.app')

@section('content')
<section class="page-hero" style="background-image: url('{{ file_exists(public_path('images/bg-about.jpg')) ? asset('images/bg-about.jpg') : '' }}');">
    <div class="container about-inner slide-up">
        <div class="about-left">
            <img src="{{ asset('images/profile.jpg') }}" alt="Linkon" class="profile-photo about-photo animate-slide-in-text">
        </div>
        <div class="about-right">
            <h2 class="animate-slide-in-text">About Me</h2>
            <p class="animate-slide-in-text"><strong>Name:</strong> Linkon Mondol</p>
            <p class="animate-slide-in-text"><strong>Education:</strong> BSc in Computer Science & Engineering, Daffodil International University</p>
            <p class="animate-slide-in-text"><strong>Location:</strong> Hometown: Faridpur - Current: Dhaka</p>
            <p class="animate-slide-in-text"><strong>Short Bio:</strong> I am a CSE student who likes coding and building web applications using Laravel and PHP. I enjoy solving problems and learning new technologies.</p>

            <h3 class="animate-slide-in-text">Skills</h3>
            <ul class="skills">
                <li class="animate-slide-in-text">Laravel</li>
                <li class="animate-slide-in-text">PHP</li>
                <li class="animate-slide-in-text">MySQL</li>
                <li class="animate-slide-in-text">HTML</li>
                <li class="animate-slide-in-text">CSS</li>
                <li class="animate-slide-in-text">JavaScript</li>
            </ul>
        </div>
    </div>
</section>
@endsection
