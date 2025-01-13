const API_BASE_URL = "https://newsapi.org/v2/";
const API_KEY = "3c7d01acaa004949ab327b84d80d3f65";
const newsContainer = document.getElementById("news-container");
const searchInput = document.getElementById("search-input");
const searchBtn = document.getElementById("search-btn");
const categoryNav = document.getElementById("category-nav");
const loadingIndicator = document.getElementById("loading"); // Loading element

// Fetch and display news articles
async function fetchNews(query = "", category = "", pageSize = 100, isInitialLoad = false) {
    let url = `${API_BASE_URL}top-headlines?apiKey=${API_KEY}&country=us&pageSize=${pageSize}`;
    if (query) {
        url = `${API_BASE_URL}everything?q=${encodeURIComponent(query)}&apiKey=${API_KEY}&pageSize=${pageSize}`;
    } else if (category) {
        url += `&category=${category}`;
    }

    if (isInitialLoad) {
        loadingIndicator.style.display = "block"; // Show loader for initial load
    }

    try {
        const response = await fetch(url);
        if (!response.ok) throw new Error("Failed to fetch news");
        const data = await response.json();
        displayNews(data.articles);
    } catch (error) {
        newsContainer.innerHTML = `<p class="error">Error fetching news: ${error.message}</p>`;
    } finally {
        if (isInitialLoad) {
            loadingIndicator.style.display = "none"; // Hide loader after fetching
        }
    }
}

// Display fetched articles
function displayNews(articles) {
    newsContainer.innerHTML = ""; // Clear previous content

    // Filter out articles with placeholder image URL
    const validArticles = articles.filter(article => article.urlToImage && article.urlToImage !== "https://via.placeholder.com/300x150");

    if (validArticles.length === 0) {
        newsContainer.innerHTML = "<p>No articles available at the moment.</p>";
        return;
    }

    validArticles.forEach(article => {
        const articleElement = document.createElement("div");
        articleElement.className = "article";
        articleElement.innerHTML = `
            <img src="${article.urlToImage}" alt="News Image">
            <a href="${article.url}" target="_blank"><h2>${article.title}</h2></a>
            <div class="source-logo-container">
                <img src="https://logo.clearbit.com/${new URL(article.url).hostname}" alt="Source Logo">
                <span>${article.source.name}</span>
                <a href="#" class="bookmark-btn"><img src="image/save-instagram.png" alt="Bookmark"/></a>
            </div>
        `;
        newsContainer.appendChild(articleElement);
		
		
		
		// Add click listener to the bookmark button
    const bookmarkBtn = articleElement.querySelector('.bookmark-btn');
    bookmarkBtn.addEventListener('click', (event) => {
		var email = document.getElementById("user_name").textContent.trim();
		console.log(email);
    event.preventDefault(); // Prevent default anchor behavior

    // Create data object
    const articleData = {
        email: email, // Replace with dynamic email if needed
        thumbnail: article.urlToImage,
        title: article.title,
        newsLink: article.url,
        websiteLogo: `https://logo.clearbit.com/${new URL(article.url).hostname}`,
        websiteName: article.source.name
    };

    // Send data to PHP via AJAX
    fetch('insert.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(articleData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
			alert('Article bookmarked successfully!');
        } else {
            alert('Error bookmarking article: ' + data.error);
        }
    })
    .catch(error => console.error('Fetch error:', error));
});
    });

}


// Fetch and display all data from the local database
function fetchAndDisplayData() {
    fetch('fetchData.php')
        .then(response => response.json())
        .then(data => {
            const listContainer = document.getElementById('dataListContainer');
            listContainer.innerHTML = ""; // Clear previous list content

            if (data.length === 0) {
                listContainer.innerHTML = "<p>No articles found.</p>";
                return;
            }

            data.forEach(item => {
                const listItem = document.createElement('div');
                listItem.className = 'list-item';

                // Create list item content
                listItem.innerHTML = `
                    <img src="${item.thumbnail}" alt="News Image">
                    <div class="details">
                        <a href="${item.newsLink}" target="_blank">
                            <h2>${item.title}</h2>
                        </a>
                        <div class="save-source-logo-container">
                            <img src="${item.websiteLogo}" alt="Source Logo">
                            <span>${item.websiteName}</span>
                            <a href="single_delete.php?deleteid=${encodeURIComponent(item.thumbnail)}" class="remove-bookmark-btn">
                                <img src="image/bookmark.png" alt="Bookmark"/>
                            </a>
                        </div>
                    </div>
                `;

                listContainer.appendChild(listItem);
            });
        })
        .catch(error => console.error('Error fetching data:', error));
}




// Fetch news on page load
fetchNews("", "", 100, true);

// Add search functionality
searchBtn.addEventListener("click", () => {
    const query = searchInput.value.trim();
    fetchNews(query, "", 100, true); // Pass false to avoid showing loader
});

function hideTopNews(){
	document.getElementById("topNews").style.display = "none"; // Hide "dataListContainer"

}


// Add category navigation functionality
categoryNav.addEventListener("click", event => {
    const category = event.target.getAttribute("data-category");
    if(category == "Saved"){
        console.log("saved click");
        fetchAndDisplayData(); // Function to fetch saved articles
        //document.getElementById("news-container").style.display = "none"; // Hide "news-container"
        document.getElementById("dataListContainer").style.display = "block"; // Show "dataListContainer"
    } else {
        document.getElementById("dataListContainer").style.display = "none"; // Hide "dataListContainer"
        //document.getElementById("news-container").style.display = "block"; // Show "news-container"

        fetchNews("", category, 100, true); // Pass false to avoid showing loader
    }
});








