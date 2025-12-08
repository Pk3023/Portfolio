@extends('layouts.app')

@section('content')
<section class="hero fade-in" style="background-image: url('{{ file_exists(public_path('images/bg-home.jpg')) ? asset('images/bg-home.jpg') : '' }}');">
    <div class="container hero-inner">
        <div class="hero-left slide-up">
            <h1 class="animate-slide-in-text">Hi, Myself <span class="name">Linkon Mondol</span></h1>
            <p class="subtitle animate-slide-in-text" style="animation-delay: 0.2s;">BSc in Computer Science & Engineering — Daffodil International University</p>
            <p class="subtitle animate-slide-in-text" style="animation-delay: 0.4s;">Web Developer • Laravel • PHP • MySQL</p>
            <a class="btn animate-slide-in-text" href="{{ route('projects') }}" style="animation-delay: 0.6s;">Explore My Projects</a>
        </div>

        <div class="hero-right fade-in">
            <img src="{{ asset('images/profile.jpg') }}" class="profile-photo animate-scale-up" alt="Linkon">
        </div>
    </div>
</section>

<section class="projects-preview container">
    <h2>Recent Projects</h2>
    <div class="projects-grid">
        @forelse($projects ?? [] as $p)
            @if($p->file_path)
                <div class="project-card zoom-hover animate-slide-in-text">
                    @if($p->image_path)
                        <img src="{{ asset('storage/'.$p->image_path) }}" alt="{{ $p->title }}">
                    @endif
                    <h4>{{ $p->title }}</h4>
                    <p>{{ \Illuminate\Support\Str::limit($p->description, 120) }}</p>
                    @if($p->project_link)<a href="{{ $p->project_link }}" target="_blank">Open</a>@endif
                    @if($p->file_path)
                        <a href="{{ route('projects.download', $p->id) }}" class="btn" download>Download File</a>
                    @endif
                </div>
            @endif
        @empty
            <p style="color: #ddd; text-align: center; grid-column: 1/-1;">No projects with files uploaded yet.</p>
        @endforelse
    </div>
</section>
@endsection
