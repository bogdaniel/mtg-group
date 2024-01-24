// Define the setupScrollModal function (setupScrollModal.js)
let modalShown = false; // Flag to track whether the modal has been shown

export function setupScrollModal() {
  window.addEventListener('scroll', function () {
    if (!modalShown) { // Check if the modal has not been shown yet
      var scrollPercentage = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100;
      if (scrollPercentage >= 50) {
        // Dynamically import Bootstrap using the import statement
        import('bootstrap').then((bootstrap) => {
          // Bootstrap is loaded and available here
          // You can use Bootstrap functionality

          // Create and show the Bootstrap modal
          var myModal = new bootstrap.Modal(document.getElementById('custom-modal'), {});
          myModal.show();

          modalShown = true; // Set the flag to true after showing the modal
        }).catch((error) => {
          console.error('Error loading Bootstrap:', error);
        });
      }
    }
  });
}
