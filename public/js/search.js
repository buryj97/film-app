// Submit form

const form = document.getElementsByClassName("film_search")[0];
form.addEventListener("submit", function (event) {
  event.preventDefault();
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
  console.log(selectedCheckboxes);

  // Get User Country
  const countrySelection = document.getElementById("film_search_country");
  const country = countrySelection.value;
  console.log(country);

  // Get Original Language
  const languageSelection = document.getElementById("film_search_language");
  const originalLanguage = languageSelection.value;
  console.log(originalLanguage);

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
  console.log(selectedOptions);

  // Get User Keywords
  var keywords = document.getElementById("film_search_keywords").value;

  console.log(keywords);

  //HTTP REQUEST

  const data = null;

  const xhr = new XMLHttpRequest();
  xhr.withCredentials = true;

  // create the query parameter string
  const params =
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
  const responseData = [];
  // listen for the response
  xhr.addEventListener("load", function () {
    // check the status of the response
    if (xhr.status === 200) {
      // parse the response data
      responseData = JSON.parse(xhr.responseText);

      // do something with the response data
      console.log(responseData);
      // generateCards(responseData);
    } else {
      // handle errors
      console.error("Error: " + xhr.status);
    }
  });

  // function generateCards(data) {
  //   const numResults = responseData.length;

  //   // loop through the data and create a card for each item
  //   for (let i = 0; i < numResults; i++) {
  //     // create a new card element
  //     const card = $("<div>").addClass("card");

  //     // create a card header element
  //     const cardHeader = $("<div>")
  //       .addClass("card-header")
  //       .text(responseData[i].header);

  //     // create a card body element
  //     const cardBody = $("<div>")
  //       .addClass("card-body")
  //       .text(responseData[i].body);

  //     // append the header and body elements to the card element
  //     card.append(cardHeader, cardBody);

  //     // append the card element to the container
  //     $(".card-container").append(card);
  //   }
  // }

  // send the request
  xhr.send();
}
