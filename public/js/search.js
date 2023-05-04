let cursor = "";
var responseData = [];

// Submit form

const form = document.getElementsByClassName("film_search")[0];
form.addEventListener("submit", function (event) {
  event.preventDefault();
  $(".card").remove();
  connectAPI();
});

// // API Connection

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
  const country = countrySelection.value;

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
  var keywords = document.getElementById("film_search_keywords").value;

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
  for (let i = 0; i < numResults; i++) {
    try {
      // create a new card element
      const card = $("<div>").addClass("card");

      // create a card header element
      const cardHeader = $("<div>")
        .addClass("card-header")
        .text(responseData.result[i].title);

      // create a card body element
      const cardBody = $("<div>")
        .addClass("card-body")
        .text(responseData.result[i].overview);

      // append the header and body elements to the card element
      card.append(cardHeader, cardBody);

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
      }
    } catch (err) {
      console.error("Error creating card:", err);
    }
  }

  // create the pagination element

  $(document).on("click", "#pagination", function () {
    if (responseData.hasMore) {
      cursor = responseData.nextCursor;
      console.log(cursor);
      // Call the connectAPI() function to load more results
      connectAPI();
    } else {
      $("#pagination").addClass("hidden");
    }
  });
}
