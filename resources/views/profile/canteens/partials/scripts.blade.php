<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        let savedLat = document.getElementById('lat').value;
        let savedLng = document.getElementById('lng').value;

        let initialLat = (savedLat && !isNaN(savedLat)) ? parseFloat(savedLat) : -6.9740;
        let initialLng = (savedLng && !isNaN(savedLng)) ? parseFloat(savedLng) : 107.6305;

        if(document.getElementById('map')) {
            let map = L.map('map').setView([initialLat, initialLng], 18);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            let marker = L.marker([initialLat, initialLng], {draggable: true}).addTo(map);

            marker.on('dragend', function(event) {
                let position = marker.getLatLng();
                document.getElementById('lat').value = position.lat;
                document.getElementById('lng').value = position.lng;
            });

            window.getLocation = function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            let newLat = position.coords.latitude;
                            let newLng = position.coords.longitude;

                            marker.setLatLng([newLat, newLng]);
                            map.setView([newLat, newLng], 18);

                            document.getElementById('lat').value = newLat;
                            document.getElementById('lng').value = newLng;
                        },
                        (error) => {
                            alert("Gagal mendeteksi lokasi: " + error.message);
                        },
                        { enableHighAccuracy: true }
                    );
                } else {
                    alert("Browser Anda tidak mendukung Geolocation.");
                }
            }
            
            setTimeout(() => { map.invalidateSize(); }, 500);
        }
    });


    function showDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function hideDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function previewImage(input, targetId) {
        const preview = document.getElementById(targetId);
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }
</script>