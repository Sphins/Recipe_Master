document.addEventListener('DOMContentLoaded', function() {
    const loadMoreDishes = document.getElementById('loadMoreDishes');
    const loadMoreUsers = document.getElementById('loadMoreUsers');
    
    var offSet = 9;
  
    if(loadMoreDishes !== null){
      loadMoreDishes.addEventListener('click', function(e) {
        e.preventDefault();
        var id = 'dishesList';
        var ajaxurl = 'loadMoreDishes';
        loadMore(id,ajaxurl);
      });
    }
  
    if(loadMoreUsers !== null){
      loadMoreUsers.addEventListener('click', function(e){
        e.preventDefault();
        const id = 'usersList';
        const ajaxurl = 'loadMoreUsers';
        loadMore(id,ajaxurl);
      });
    }
  
    function loadMore(id, ajaxurl) {
      const url = `?ajax=${ajaxurl}&offSet=${offSet}`;
    
      fetch(url)
        .then(function(response) {
          return response.text();
        })
        .then(function(code) {
          const listDishes = document.getElementById(id);
          listDishes.innerHTML += code;
    
          var dishPreviews = listDishes.querySelectorAll('.post-preview:nth-last-child(-n+6)');
          dishPreviews.forEach(function(dishPreview) {
            dishPreview.style.display = 'none';
            setTimeout(function() {
              dishPreview.style.display = 'block';
            }, 1000);
          });
    
          offSet += 9;
        });
    }
  });
  