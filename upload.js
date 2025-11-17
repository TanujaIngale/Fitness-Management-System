document.getElementById('uploadNew').addEventListener('change', function() {
    const file = this.files[0];

    if (!file) {
        alert("Please select an image file.");
        return;
    }

    let trainerName = prompt("Enter Trainer's Name:");
    if (!trainerName) {
        alert("Trainer name cannot be empty.");
        return;
    }

    let formData = new FormData();
    formData.append('image', file);
    formData.append('name', trainerName);

    fetch('upload.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            addTrainerToPage(trainerName, data.imageUrl);
            alert("Trainer added successfully!");
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(error => {
        console.error('Upload error:', error);
        alert("Something went wrong while uploading.");
    });
});

// Function to add new trainer dynamically
function addTrainerToPage(name, imageUrl) {
    let trainerContainer = document.getElementById('trainerContainer');

    let newTrainer = document.createElement('div');
    newTrainer.classList.add('col-lg-4', 'col-md-6', 'mx-auto');

    newTrainer.innerHTML = `
        <div class="box">
            <h5>${name}</h5>
            <div class="img-box">
                <img src="${imageUrl}" alt="${name}" onclick="selectImage(this)">
            </div>
        </div>
    `;

    trainerContainer.appendChild(newTrainer);
}
