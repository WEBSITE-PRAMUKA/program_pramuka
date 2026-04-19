<!-- gallery.php -->
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gallery Management</title>
<link rel="stylesheet" href="style/gallery-style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="dashboard">

    <?php include 'sidebar.php'; ?>

    <!-- Main -->
    <main class="main-content">

        <!-- Topbar -->
        <header class="topbar">
            <div class="search-box">
                <i class="fa fa-search"></i>
                <input type="text" placeholder="Search Members or Events...">
            </div>

            <div class="profile">
                <img src="https://i.pravatar.cc/40" alt="">
                <div>
                    <h4>Admin Pramuka</h4>
                    <span>Super Admin</span>
                </div>
            </div>
        </header>

        <!-- Title -->
        <section class="title">
            <h1>Gallery Management</h1>
            <p>Organize and manage scout activity photos</p>
        </section>

        <!-- Upload Form -->
        <section class="upload-section">

            <h3>Create New Album</h3>

            <form id="uploadForm">

                <label class="upload-box">
                    <input type="file" id="imageInput" accept="image/*" hidden>
                    <i class="fa fa-upload"></i>
                    <h4>Upload Media</h4>
                    <p>Drag and drop your photos here, or click to browse</p>
                    <span>Browse Files</span>
                </label>

                <div class="grid2">
                    <div>
                        <label>Gallery Title</label>
                        <input type="text" id="titleInput" placeholder="e.g. Camping Gunung Pancar 2026">
                    </div>

                    <div>
                        <label>Event Category</label>
                        <select id="categoryInput">
                            <option>Training</option>
                            <option>Camping</option>
                            <option>Ceremony</option>
                            <option>Community Service</option>
                        </select>
                    </div>
                </div>

                <button type="button" onclick="addPhoto()" class="btn-green">
                    Create Album
                </button>

            </form>

        </section>

        <!-- Gallery -->
        <section class="gallery-section">
            <h3>Photo Albums</h3>

            <div class="gallery-grid" id="galleryGrid">

                <div class="card">
                    <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?w=500">
                    <div class="card-body">
                        <h4>Camping Gunung Pancar 2026</h4>
                        <small>Camping • 45 photos</small>

                        <div class="btn-row">
                            <button><i class="fa fa-edit"></i> Edit</button>
                            <button class="delete"><i class="fa fa-trash"></i> Delete</button>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <img src="https://images.unsplash.com/photo-1513258496099-48168024aec0?w=500">
                    <div class="card-body">
                        <h4>Latihan PBB</h4>
                        <small>Training • 28 photos</small>

                        <div class="btn-row">
                            <button><i class="fa fa-edit"></i> Edit</button>
                            <button class="delete"><i class="fa fa-trash"></i> Delete</button>
                        </div>
                    </div>
                </div>

            </div>

        </section>

    </main>
</div>

<script>
function addPhoto(){

    let file = document.getElementById("imageInput").files[0];
    let title = document.getElementById("titleInput").value;
    let category = document.getElementById("categoryInput").value;

    if(!file || title==""){
        alert("Lengkapi foto dan judul album!");
        return;
    }

    let reader = new FileReader();

    reader.onload = function(e){

        let html = `
        <div class="card">
            <img src="${e.target.result}">
            <div class="card-body">
                <h4>${title}</h4>
                <small>${category} • 1 photo</small>

                <div class="btn-row">
                    <button><i class="fa fa-edit"></i> Edit</button>
                    <button class="delete" onclick="this.closest('.card').remove()">
                    <i class="fa fa-trash"></i> Delete
                    </button>
                </div>
            </div>
        </div>`;

        document.getElementById("galleryGrid").innerHTML += html;

        document.getElementById("uploadForm").reset();
    }

    reader.readAsDataURL(file);
}
</script>

</body>
</html>