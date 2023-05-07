let cursor = "";
var responseData = [];
var country = "";
var keywords = "";

// Submit form

const form = document.getElementsByClassName("film_search")[0];
form.addEventListener("submit", function (event) {
  event.preventDefault();
  $(".card").remove();
  cursor = "";
  connectAPI();
});

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

  if (numResults < 1) {
    alert(
      "No results for" +
        ' "' +
        keywords +
        '".' +
        "\n" +
        "Try a different keyword and assure that your selected streaming services are available in your country."
    );
  }
  for (let i = 0; i < numResults; i++) {
    try {
      // const column = $("<div>").addClass("col");
      // create a new card element
      const card = $("<div>").addClass("card");
      // column.append(card);

      // create a card header element
      const cardHeader = $("<h2>")
        .addClass("card-title")
        .text(responseData.result[i].title);

      card.append(cardHeader);

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

      for (const key in responseData.result[i].streamingInfo) {
        const streamingCountry = responseData.result[i].streamingInfo[key];
        for (const serviceKey in streamingCountry) {
          const serviceValue = streamingCountry[serviceKey];
          if (serviceValue !== null) {
            streamingServices.push(serviceKey);
          }
        }
      }

      var streamingLogos = $("<div>").addClass("streaming-logos");

      streamingServices.forEach(function (service) {
        var logoSrc;
        switch (service) {
          case "netflix":
            logoSrc = netflixLogo;
            break;
          case "prime":
            logoSrc = primeLogo;
            break;
          case "disney":
            logoSrc = disneyLogo;
            break;
          case "hulu":
            logoSrc = huluLogo;
            break;
          case "hbo":
            logoSrc = hboLogo;
            break;
          case "mubi":
            logoSrc = mubiLogo;
            break;
          default:
            return;
        }
        var logo = $("<img>")
          .addClass("card-logo img-thumbnail")
          .attr("src", BASE_IMAGE_URL + logoSrc);
        streamingLogos.append(logo);
      });

      // create a card body element
      const cardBody = $("<div>").addClass("card-body");
      const cardFooter = $("<div>").addClass("card-footer");

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

      function limit(string = "", limit = 300) {
        return string.substring(0, limit);
      }

      const cardOverview = $("<p>")
        .addClass("card-text")
        .text(responseData.result[i].overview);

      if (responseData.result[i].overview.length > 300) {
        cardOverview.text(limit(responseData.result[i].overview) + "...");
      }

      const cardButton = $("<a>").addClass("btn btn-primary").text("Read more");

      const cardFavorite = $("<i>").addClass("bi bi-heart");

      cardFavorite.on("click", function () {
        toggleClass("bi-heart");
        toggleClass("bi-heart-fill");
      });

      cardBody.append(cardHeader, cardOverview);
      // append the header and body elements to the card element
      card.append(
        cardBody,
        cardYear,
        cardDirectors,
        streamingLogos,
        cardButton,
        cardFavorite,
        cardFooter
      );

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
