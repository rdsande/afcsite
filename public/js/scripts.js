  //Change Language Image
  const imageList = document.getElementById('langSwitch');
  const imageToChange = document.getElementById('selectLang');

  imageList.addEventListener('click', (event) => {
    if (event.target.tagName === 'LI') {
      const newImageSrc = event.target.getAttribute('data-src');
      imageToChange.src = newImageSrc;
    }
  });


  //Carousel
  const items = document.querySelectorAll('.afc-slide');

// Function to remove the 'active' class from all items
function removeActiveClass() {
  items.forEach(item => {
    item.classList.remove('active');
  });
}

// Event listener to add the 'active' class on hover
items.forEach(item => {
  item.addEventListener('mouseover', () => {
    removeActiveClass(); // Remove the 'active' class from all items first
    item.classList.add('active'); // Add the 'active' class to the current hovered item
  });
});




