@extends('layouts.app')

@section('content')

<section class="page-hero" 
style="background-image: url('{{ asset('images/bg-projects.jpg') }}'); 
       background-size: cover; 
       background-position: center;
       background-attachment: fixed;
       padding: 120px 0;">

    <div class="container projects-page slide-up" style="background: rgba(0,0,0,0.45); padding: 25px; border-radius: 10px;">

        <h2 style="color: #fff; margin-bottom: 20px;">Projects</h2>

        <!-- UPLOAD FORM -->
        <div class="upload-area" 
             style="background: rgba(255,255,255,0.15); padding: 20px; border-radius: 10px; margin-bottom: 25px; backdrop-filter: blur(6px); color: #fff;">
            
            <h3 style="color: #fff; margin-bottom: 10px;">Upload a Project</h3>

            <form action="{{ route('projects.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <label style="color:#fff; display:block; margin-bottom:10px;">
                    Title
                    <input type="text" name="title" required 
                           style="width:100%; padding:8px; border-radius:5px; border:none; margin-top:5px;">
                </label>

                <label style="color:#fff; display:block; margin-bottom:10px;">
                    Description
                    <textarea name="description" 
                              style="width:100%; padding:8px; border-radius:5px; border:none; margin-top:5px;"></textarea>
                </label>

                <label style="color:#fff; display:block; margin-bottom:10px;">
                    Project Link
                    <input type="url" name="project_link" placeholder="https://example.com"
                           style="width:100%; padding:8px; border-radius:5px; border:none; margin-top:5px;">
                </label>

                <label style="color:#fff; display:block; margin-bottom:10px;">
                    Project Image
                    <input type="file" name="image" accept="image/*"
                           style="width:100%; padding:8px; border-radius:5px; background:#fff; margin-top:5px;">
                </label>

                <label style="color:#fff; display:block; margin-bottom:10px;">
                    Project Folder (ZIP)
                    <input type="file" name="folder" accept=".zip" id="folderInput"
                           style="width:100%; padding:8px; border-radius:5px; background:#fff; margin-top:5px;">
                    <small id="folderSizeWarning" style="color:#ffd166; display:none; margin-top:5px; display:block;">
                        File size: <span id="folderSizeDisplay">0 MB</span> (Max: 200 MB)
                    </small>
                </label>

                <button type="submit" class="btn"
                        style="padding:10px 18px; background:#0b72b9; color:#fff; border:none; border-radius:6px; cursor:pointer;" id="uploadBtn">
                    Upload Project
                </button>
            </form>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const folderInput = document.getElementById('folderInput');
            const sizeWarning = document.getElementById('folderSizeWarning');
            const sizeDisplay = document.getElementById('folderSizeDisplay');
            const uploadBtn = document.getElementById('uploadBtn');
            const MAX_SIZE_MB = 200;
            const MAX_SIZE_BYTES = MAX_SIZE_MB * 1024 * 1024;

            folderInput.addEventListener('change', function () {
                const file = this.files[0];
                if (!file) {
                    sizeWarning.style.display = 'none';
                    uploadBtn.disabled = false;
                    return;
                }

                const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
                sizeDisplay.textContent = sizeMB + ' MB';

                if (file.size > MAX_SIZE_BYTES) {
                    sizeWarning.style.color = '#ff6b6b';
                    sizeWarning.innerHTML = '⚠️ File too large! Max: 200 MB, Got: ' + sizeMB + ' MB';
                    uploadBtn.disabled = true;
                } else {
                    sizeWarning.style.color = '#a7f3d0';
                    sizeWarning.textContent = '✓ File size OK: ' + sizeMB + ' MB / 200 MB';
                    uploadBtn.disabled = false;
                }
                sizeWarning.style.display = 'block';
            });
        });
        </script>

        <!-- PROJECT LIST -->
        <div class="projects-grid">
            @foreach($projects as $p)
                <div class="project-card zoom-hover" 
                     style="background:#fff; padding:15px; border-radius:8px;">

                    @if($p->image_path)
                        <img src="{{ asset('storage/'.$p->image_path) }}" 
                             alt="{{ $p->title }}"
                             style="width:100%; height:150px; object-fit:cover; border-radius:6px; margin-bottom:10px;">
                    @endif

                    <h4 style="margin-bottom:6px;">{{ $p->title }}</h4>

                    <p style="margin-bottom:10px;">{{ $p->description }}</p>

                    @if($p->project_link)
                        <a href="{{ $p->project_link }}" 
                           target="_blank" 
                           class="btn"
                           style="display:inline-block; padding:8px 12px; background:#0b72b9; color:#fff; border-radius:5px; text-decoration:none; margin-right:5px;">
                           View Project
                        </a>
                    @endif

                    @if($p->file_path)
                        <a href="{{ route('projects.download', $p->id) }}" 
                           class="btn" download
                           style="display:inline-block; padding:8px 12px; background:#10a37f; color:#fff; border-radius:5px; text-decoration:none;">
                           Download Folder
                        </a>
                    @endif
                </div>
            @endforeach
        </div>

    </div>

</section>

@endsection
