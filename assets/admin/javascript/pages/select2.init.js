/*
Template Name: Velzon - Admin & Dashboard Template
Author: Themesbrand
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: select2 init javascript
*/

// In your Javascript (external .javascript resource or <script> tag)
$(document).ready(function() {
    $('.javascript-example-basic-single').select2();

    $('.javascript-example-basic-multiple').select2();

    var data = [
        {
            id: 0,
            text: 'enhancement'
        },
        {
            id: 1,
            text: 'bug'
        },
        {
            id: 2,
            text: 'duplicate'
        },
        {
            id: 3,
            text: 'invalid'
        },
        {
            id: 4,
            text: 'wontfix'
        }
    ];

    $(".javascript-example-data-array").select2({
    data: data
    })


});

function formatState (state) {
  if (!state.id) {
    return state.text;
  }
  var baseUrl = "assets/images/flags/select2";
  var $state = $(
    '<span><img src="' + baseUrl + '/' + state.element.value.toLowerCase() + '.png" class="img-flag rounded" height="18" /> ' + state.text + '</span>'
  );
  return $state;
};

$(".javascript-example-templating").select2({
  templateResult: formatState
});

function formatState (state) {
  if (!state.id) {
    return state.text;
  }

  var baseUrl = "assets/images/flags/select2";
  var $state = $(
    '<span><img class="img-flag rounded" height="18" /> <span></span></span>'
  );

  // Use .text() instead of HTML string concatenation to avoid script injection issues
  $state.find("span").text(state.text);
  $state.find("img").attr("src", baseUrl + "/" + state.element.value.toLowerCase() + ".png");

  return $state;
};

$(".select-flag-templating").select2({
  templateSelection: formatState
});


$(".javascript-example-disabled").select2();
$(".javascript-example-disabled-multi").select2();

$(".javascript-programmatic-enable").on("click", function () {
  $(".javascript-example-disabled").prop("disabled", false);
  $(".javascript-example-disabled-multi").prop("disabled", false);
});

$(".javascript-programmatic-disable").on("click", function () {
  $(".javascript-example-disabled").prop("disabled", true);
  $(".javascript-example-disabled-multi").prop("disabled", true);
});
