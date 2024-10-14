document.addEventListener("DOMContentLoaded", () => {
    const mapsContainer = document.querySelector(".maps-css");
    const mapElements = Array.from(mapsContainer.querySelectorAll("div[id]"));

    function sortMaps(criteria) {
        let sortedMaps;
        
        if (criteria === "alphabetical") {
            sortedMaps = mapElements.sort((a, b) => {
                const titleA = a.dataset.title.toLowerCase();
                const titleB = b.dataset.title.toLowerCase();
                return titleA.localeCompare(titleB);
            });
        } else if (criteria === "most_likes") {
            sortedMaps = mapElements.sort((a, b) => {
                const likesA = parseInt(a.dataset.likes, 10);
                const likesB = parseInt(b.dataset.likes, 10);
                return likesB - likesA; // Sort by most likes
            });
        } else if (criteria === "date") {
            sortedMaps = mapElements.sort((a, b) => {
                const dateA = new Date(a.dataset.date);
                const dateB = new Date(b.dataset.date);
                return dateB - dateA; // Sort by latest date
            });
        }

        // Append sorted elements back to the container
        sortedMaps.forEach(map => mapsContainer.appendChild(map));
    }

    // Expose sortMaps function to global scope
    window.sortMaps = sortMaps;
});