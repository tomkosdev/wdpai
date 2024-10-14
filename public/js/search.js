const search = document.querySelector('input[placeholder="Search"]');
const mapContainer = document.querySelector(".maps-css");

search.addEventListener("keyup", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();

        const query = this.value;

        if (!mapContainer) {
            window.location.href = "/maps?search=" + encodeURIComponent(query);
        } else {
            searchMaps(query);
        }
    }
});

function searchMaps(query) {
    const data = { search: query };

    fetch("/search", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        return response.json();
    }).then(function (maps) {
        mapContainer.innerHTML = "";
        loadMaps(maps);
    });
}

function loadMaps(maps) {
    maps.forEach(map => {
        console.log(map);
        createMap(map);
    });
}

function createMap(map) {
    const template = document.querySelector("#map-template");

    const clone = template.content.cloneNode(true);
    const div = clone.querySelector("div");
    div.id = map.id;

    const a = clone.querySelector("a");
    a.href = "map_info?id=" + div.id;

    const image = clone.querySelector("img");
    image.src = `/public/uploads/${map.image}`;

    const name = clone.querySelector("h2");
    name.innerHTML = map.name;

    const likes = clone.querySelector(".map-likes");
    likes.innerText =  " " + map.likes;

    const uploader = clone.querySelector(".map-uploader");
    uploader.innerText =  " " + map.uploader;

    mapContainer.appendChild(clone);
}

document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const searchQuery = urlParams.get("search");
    
    if (searchQuery) {
        search.value = searchQuery; 
        searchMaps(searchQuery); 
    }
});
