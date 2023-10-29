// Initialize variables
let cursor;
var responseData = [];
var country = "";
var keywords = "";
let favData = {};
var isAuthenticated;

//passes user authentification status from twig
document.addEventListener("DOMContentLoaded", function () {
  isAuthenticated = $(".js-user-rating").data("isAuthenticated");
});

// Retrieve form and handle submission

const form = document.getElementsByClassName("film_search")[0];

form.addEventListener("submit", function (event) {
  event.preventDefault();
  noResults.classList.add("hidden");
  const countrySelection = document.getElementById("film_search_country");
  const country = countrySelection.value;
  const checkboxes = document.getElementsByName(
    "film_search[streamingServices][]"
  );
  const selectedCheckboxes = [];
  for (let i = 0; i < checkboxes.length; i++) {
    const checkbox = checkboxes[i];
    if (checkbox.checked) {
      selectedCheckboxes.push(checkbox.value);
    }
  }
  if (country == "" || selectedCheckboxes.length === 0) {
    const error = document.getElementById("error");
    error.classList.remove("hidden");
    form.focus();
    return false;
  } else {
    $(".card").remove();
    error.classList.add("hidden");
    cursor = "";
    connectAPI();
  }
});

// ----------------------------------------------

// API Connection

function connectAPI() {
  // Get User Services
  const checkboxes = document.getElementsByName(
    "film_search[streamingServices][]"
  );
  const selectedCheckboxes = [];
  for (let i = 0; i < checkboxes.length; i++) {
    const checkbox = checkboxes[i];
    if (checkbox.checked) {
      selectedCheckboxes.push(checkbox.value);
    }
  }

  // Get User Country
  const countrySelection = document.getElementById("film_search_country");
  country = countrySelection.value;

  // Get Original Language
  const languageSelection = document.getElementById("film_search_language");
  const originalLanguage = languageSelection.value;

  // Get User Genres
  const genreSelection = document.querySelector("#film_search_genre");
  const selectedOptions = [];
  const options = genreSelection.options;
  for (let i = 0; i < options.length; i++) {
    const option = options[i];
    if (option.selected) {
      selectedOptions.push(option.value);
    }
  }

  // Get User Keywords
  keywords = document.getElementById("film_search_keywords").value;

  // ----------------------------------------------------------------

  //HTTP REQUEST

  const data = null;

  const xhr = new XMLHttpRequest();
  xhr.withCredentials = true;
  // create the query parameter string
  let params =
    "services=" +
    encodeURIComponent(selectedCheckboxes.join(",")) +
    "&country=" +
    encodeURIComponent(country) +
    "&show_original_language=" +
    encodeURIComponent(originalLanguage) +
    "&show_type=" +
    encodeURIComponent("movie") +
    "&keyword=" +
    encodeURIComponent(keywords) +
    "&genre=" +
    encodeURIComponent(selectedOptions);

  // create parameter necessary for pagination
  if (cursor !== "") {
    params += "&cursor=" + encodeURIComponent(cursor);
  }

  // specify the API endpoint URL
  const url = "https://streaming-availability.p.rapidapi.com/v2/search/basic";

  // specify the HTTP request method and URL with query parameters
  xhr.open("GET", url + "?" + params, true);

  // set the content type of the request
  xhr.setRequestHeader("Content-type", "application/octet-stream");

  // set the RapidAPI headers
  xhr.setRequestHeader(
    "x-rapidapi-host",
    "streaming-availability.p.rapidapi.com"
  );
  xhr.setRequestHeader(
    "x-rapidapi-key",
    "8d0b2a5100msh66455e428ed9568p197a01jsnb5d4ac778dbc"
  );

  // listen for the response
  xhr.addEventListener("load", function () {
    // check the status of the response
    if (xhr.status === 200) {
      // parse the response data
      responseData = JSON.parse(xhr.responseText);
      // pass response data to the function to create visual display
      generateCards(responseData);
    } else {
      // handle errors
      console.error("Error: " + xhr.status);
    }
  });
  // send the request
  xhr.send();
}

// ___________________________________________
function generateCards(responseData) {
  const numResults = responseData.result.length;

  // Tell user if there are no results
  if (numResults < 1) {
    const noResults = document.getElementById("noResults");
    noResults.classList.remove("hidden");
    form.focus();
  }

  for (let i = 0; i < numResults; i++) {
    try {
      // create a new card element
      const card = $("<div>").addClass("card");

      // create a card header element
      const cardHeader = $("<h2>")
        .addClass("card-title")
        .text(responseData.result[i].title);

      card.append(cardHeader);

      // establish urls for each necessary image (all hosted at the base url)
      const BASE_IMAGE_URL = "https://image.tmdb.org/t/p/original/";

      const netflixLogo = "9A1JSVmSxsyaBK4SUFsYVqbAYfW.jpg";
      const primeLogo = "68MNrwlkpF7WnmNPXLah69CR5cb.jpg";
      const disneyLogo = "dgPueyEdOwpQ10fjuhL2WYFQwQs.jpg";
      const huluLogo = "giwM8XX4V2AQb9vsoN7yti82tKK.jpg";
      const hboLogo = "aS2zvJWn9mwiCOeaaCkIh4wleZS.jpg";
      const mubiLogo = "kXQQbZ6ZvTwojzMPivQF9sX0V4y.jpg";

      const cardImage = $("<img>")
        .addClass("card-img-top")
        .attr("src", BASE_IMAGE_URL + responseData.result[i].posterPath)
        .attr("alt", "Poster for" + responseData.result[i].title);

      card.append(cardImage);

      let streamingServices = [];

      // filter through reponse object to determine services' availability in selected country

      for (const key in responseData.result[i].streamingInfo) {
        const streamingCountry = responseData.result[i].streamingInfo[key];
        for (const serviceKey in streamingCountry) {
          const serviceValue = streamingCountry[serviceKey];
          if (serviceValue !== null) {
            streamingServices.push(serviceKey);
          }
        }
      }

      // associate each service with its logo
      function getLogoSrc(service) {
        switch (service) {
          case "netflix":
            return netflixLogo;
          case "prime":
            return primeLogo;
          case "disney":
            return disneyLogo;
          case "hulu":
            return huluLogo;
          case "hbo":
            return hboLogo;
          case "mubi":
            return mubiLogo;
          default:
            return "";
        }
      }

      var logoSrc;
      var iconsDiv = $("<div>").addClass("d-flex justify-content-between");
      var streamingLogos = $("<div>").addClass(
        "streaming-logos d-flex justify-content-between"
      );

      // display logos for each service that exists in the response data
      streamingServices.forEach(function (service) {
        logoSrc = getLogoSrc(service);
        if (logoSrc) {
          var logo = $("<img>")
            .addClass("card-logo rounded-circle img-fluid")
            .attr("src", BASE_IMAGE_URL + logoSrc);
          streamingLogos.append(logo);
        }
      });

      //attach streaming logos div to div shared with favorite icon
      iconsDiv.append(streamingLogos);

      // create a card body element
      const cardBody = $("<div>").addClass("card-body");
      const cardFooter = $("<div>").addClass("card-footer mt-2");

      const cardYear = $("<small>")
        .addClass("text-body-secondary")
        .text(responseData.result[i].year);

      const cardDirectors = $("<small>")
        .addClass("text-body-secondary")
        .text("Director: " + responseData.result[i].directors);

      const cardRuntime = $("<small>")
        .addClass("text-body-secondary")
        .text(responseData.result[i].runtime + " minutes");

      cardFooter.append(cardRuntime);

      // shorten text length to regularize card size
      function limit(string = "", limit = 300) {
        return string.substring(0, limit);
      }

      const cardOverview = $("<p>")
        .addClass("card-text")
        .text(responseData.result[i].overview);

      if (responseData.result[i].overview.length > 300) {
        cardOverview.text(limit(responseData.result[i].overview) + "...");
      }

      const cardFavorite = $("<a>")
        .addClass("bi bi-heart col-1 align-self-end me-3")
        .attr("aria-label", "Add to Watchlist");

      iconsDiv.append(cardFavorite);

      function checkSavedFilms(savedFilms, cardFavorite) {
        savedFilms.forEach((savedFilm) => {
          if (responseData.result[i].title == savedFilm.title) {
            cardFavorite.toggleClass("bi-heart bi-heart-fill");
            return; // Exit the loop if a match is found
          }
        });
      }

      fetch("get-saved-films", {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
        },
      })
        .then((response) => {
          response.json();
          // window.location.href = "/"; // Redirect to the home page
        })
        .then((savedFilms) => {
          // Inside the loop:
          checkSavedFilms(savedFilms, cardFavorite);
        })
        .catch((error) => {
          // Handle any errors
        });

      cardFavorite.on("click", function () {
        //ensure user is logged in by checking for presence of account icon in the nav bar
        if (isAuthenticated === true) {
          $(this).toggleClass("bi-heart");
          $(this).toggleClass("bi-heart-fill");

          // create variables to pass data to SQL server when a user saves a film to their watchlist
          favData.title = responseData.result[i].title;
          favData.overview = responseData.result[i].overview;
          favData.posterPath =
            BASE_IMAGE_URL + responseData.result[i].posterPath;
          favData.directors = responseData.result[i].directors;
          favData.runtime = responseData.result[i].runtime;
          favData.year = responseData.result[i].year;
          favData.streamingServices = streamingServices;
          favData.streamingLogos = streamingServices.map(
            (service) => BASE_IMAGE_URL + getLogoSrc(service)
          );

          fetch("update-saved-films", {
            method: "POST",
            body: JSON.stringify(favData), // Pass the retrieved JSON data
            headers: {
              "Content-Type": "application/json",
            },
          })
            .then((response) => {})
            .catch((error) => {});
        } else {
          //show user error if they are not logged in
          alert(
            "Please login or create an account to save a film to your watchlist"
          );
        }
      });

      cardBody.append(cardHeader, cardOverview);

      // append the header and body elements to the card element
      card.append(cardBody, cardYear, cardDirectors, iconsDiv, cardFooter);

      // append the card element to the container
      $("#card-container").append(card);

      // assign the correct value to 'cursor'
      if (i === numResults - 1) {
        cursor = responseData.nextCursor;
      }

      if (responseData.nextCursor !== "") {
        $("#pagination").removeClass("hidden");
        $("#endResults").addClass("hidden");
      } else {
        $("#endResults").removeClass("hidden");
        $("#pagination").addClass("hidden");
      }
    } catch (err) {
      console.error("Error creating card:", err);
    }
  }
}

// create the pagination element

$(document).on("click", "#pagination", function () {
  if (responseData.hasMore) {
    cursor = responseData.nextCursor;

    // Call the connectAPI() function to load more results
    connectAPI();
  }
});
