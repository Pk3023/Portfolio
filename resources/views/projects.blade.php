@extends('layouts.app')

@section('content')
<section class="page-hero" style="background-image: url('{{ asset('images/bg-projects.jpg') }}');">
    <div class="container projects-page projects-page-panel slide-up">
        <h2 class="animate-slide-in-text">Projects</h2>

        <div class="upload-area animate-slide-in-text">
            <h3>Upload a Project</h3>

            <form action="{{ route('projects.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <label>
                    Title
                    <input type="text" name="title" required>
                </label>

                <label>
                    Description
                    <textarea name="description"></textarea>
                </label>

                <label>
                    Project Link
                    <input type="url" name="project_link" placeholder="https://example.com">
                </label>

                <label>
                    Project Image
                    <input type="file" name="image" accept="image/*">
                </label>

                <label>
                    Project Folder (ZIP)
                    <input type="file" name="folder" accept=".zip" id="folderInput">
                    <small id="folderSizeWarning">
                        File size: <span id="folderSizeDisplay">0 MB</span> (Max: 200 MB)
                    </small>
                </label>

                <button type="submit" class="btn" id="uploadBtn">Upload Project</button>
            </form>
        </div>

        <div class="projects-grid">
            @forelse($projects as $p)
                <div class="project-card zoom-hover animate-slide-in-text">
                    @if($p->image_path)
                        <img src="{{ asset('storage/'.$p->image_path) }}" alt="{{ $p->title }}">
                    @endif

                    <h4>{{ $p->title }}</h4>
                    <p>{{ $p->description }}</p>

                    @if($p->project_link)
                        <a href="{{ $p->project_link }}" target="_blank" class="btn">View Project</a>
                    @endif

                    @if($p->file_path)
                        <a href="{{ route('projects.download', $p->id) }}" class="btn" download>Download Folder</a>
                    @endif
                </div>
            @empty
                <p class="empty-state">No projects uploaded yet.</p>
            @endforelse
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const folderInput = document.getElementById('folderInput');
    const sizeWarning = document.getElementById('folderSizeWarning');
    const sizeDisplay = document.getElementById('folderSizeDisplay');
    const uploadBtn = document.getElementById('uploadBtn');
    const maxSizeMb = 200;
    const maxSizeBytes = maxSizeMb * 1024 * 1024;

    if (!folderInput || !sizeWarning || !sizeDisplay || !uploadBtn) return;

    sizeWarning.style.display = 'none';

    folderInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) {
            sizeWarning.style.display = 'none';
            uploadBtn.disabled = false;
            return;
        }

        const sizeMb = (file.size / (1024 * 1024)).toFixed(2);
        sizeDisplay.textContent = sizeMb + ' MB';

        if (file.size > maxSizeBytes) {
            sizeWarning.style.color = '#ff6b6b';
            sizeWarning.innerHTML = 'File too large. Max: 200 MB, got: ' + sizeMb + ' MB';
            uploadBtn.disabled = true;
        } else {
            sizeWarning.style.color = '#a7f3d0';
            sizeWarning.textContent = 'File size OK: ' + sizeMb + ' MB / 200 MB';
            uploadBtn.disabled = false;
        }

        sizeWarning.style.display = 'block';
    });
});
</script>
@endsection
