document.addEventListener('DOMContentLoaded', function() {
    var navItems = document.querySelectorAll('.nav-item.dropdown');
    navItems.forEach(function(navItem) {
        var navLink = navItem.querySelector('.nav-link');
        navLink.addEventListener('click', function(e) {
            e.preventDefault();
            // Remove active class from all nav-items
            navItems.forEach(function(item) {
                item.classList.remove('show');
            });
            // Toggle show class on the clicked nav-item
            navItem.classList.toggle('show');
        });
    });
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.nav-item')) {
            // Remove show class from all nav-items if clicked outside
            navItems.forEach(function(item) {
                item.classList.remove('show');
            });
        }
    });
});

// ---- on hover add class of mega menu-----
document.addEventListener('DOMContentLoaded', function () {
    const navLinks = document.querySelectorAll('.big-nav .nav .nav-link');
    const tabContent = document.querySelectorAll('.big-nav .tab-content .tab-pane');

    navLinks.forEach(link => {
        link.addEventListener('mouseover', function () {
            // Remove active class from all nav-links and tab-panes
            navLinks.forEach(nav => nav.classList.remove('active'));
            tabContent.forEach(tab => tab.classList.remove('show', 'active'));
            // Add active class to the hovered nav-link and corresponding tab-pane
            this.classList.add('active');
            const targetId = this.getAttribute('data-bs-target');
            const targetTab = document.querySelector(targetId);
            targetTab.classList.add('show', 'active');
        });
    });
});


// document.addEventListener('DOMContentLoaded', function() {
//     const moreBtns = document.querySelectorAll('.read-text .read-more'); // Select all read more buttons

//     moreBtns.forEach(function(moreBtn) {
//         const addMore = moreBtn.previousElementSibling; // Get the previous sibling element, assuming it's the .add-read-more paragraph
        
//         moreBtn.addEventListener('click', function() {
//             // Toggle the class show-more-content on the add-read-more paragraph
//             addMore.classList.toggle('show-more-content');
            
//             // Adjust the button text based on the state
//             if (addMore.classList.contains('show-more-content')) {
//                 moreBtn.textContent = 'Read Less';
//             } else {
//                 moreBtn.textContent = 'Read More';
//             }
//         });

//         // Check initial height on page load
//         const elementHeight = addMore.clientHeight;
        
//         // If height is less than 108 pixels, hide the read more button
//         if (elementHeight < 135) {
//             moreBtn.style.display = 'none';
//         }
//     });
// });



/*window.addEventListener('load', function() {
	setTimeout(function() {
		var myModal = new bootstrap.Modal(document.getElementById('aboutproject'));
		myModal.show();
	}, 15000); 
});*/

const secheader = document.querySelector(".sec_top_header");
const toggleClass = "is-sticky";

window.addEventListener("scroll", () => {
  const currentScroll = window.pageYOffset;
  if (currentScroll > 150) {
    secheader.classList.add(toggleClass);
  } else {
    secheader.classList.remove(toggleClass);
  }
});

jQuery(document).ready(function($) {
	$('.badge_height').on('input', function() {
		var newValue = $(this).val();
		var id = $(this).data("id");

		$('span[data-id="badge_height'+id+'"]').text(newValue+"px");
	});
	
	$('.badge_width').on('input', function() {
		var newValue = $(this).val();
		var id = $(this).data("id");

		$('span[data-id="badge_width'+id+'"]').text(newValue+"px");
	});
});



// document.addEventListener('DOMContentLoaded', function() {
//     function AddReadMore(charLimit, readMoreTxt, readLessTxt, selector, toggle) {
//         // Function to toggle the visibility of the text sections
//         function toggleSections(event) {
//             var parent = event.target.closest(selector);
//             var secondSection = parent.querySelector(".second-section");
//             var readMoreBtn = parent.querySelector(".read-more");
//             var readLessBtn = parent.querySelector(".read-less");

//             if (secondSection.style.display === "none") {
//                 secondSection.style.display = "inline";
//                 readMoreBtn.style.display = "none";
//                 if (readLessBtn) readLessBtn.style.display = "inline";
//             } else {
//                 secondSection.style.display = "none";
//                 readMoreBtn.style.display = "inline";
//                 if (readLessBtn) readLessBtn.style.display = "none";
//             }
//         }

//         // Traverse all selectors and manipulate HTML to show Read More
//         document.querySelectorAll(selector).forEach(function(element) {
//             // Skip if the element is already processed
//             if (element.querySelector(".first-section")) return;

//             var allstr = element.textContent.trim();
//             if (allstr.length > charLimit) {
//                 var visibleText = allstr.substring(0, charLimit);
//                 var hiddenText = allstr.substring(charLimit);
// 				var strtoadd = visibleText;
// 				if( toggle === true ){
// 					var strtoadd = visibleText + "<span class='second-section' style='display:none;'>" + hiddenText + "</span><span class='read-more' title='Click to Show More'>" + readMoreTxt + "</span>";
// 					if (readLessTxt) {
// 					    strtoadd += "<span class='read-less' title='Click to Show Less' style='display:none;'>" + readLessTxt + "</span>";
// 					}
// 				}
//                 element.innerHTML = strtoadd;
//             }
//         });

//         // Add event listeners for read more and read less buttons
//         document.querySelectorAll(selector + " .read-more, " + selector + " .read-less").forEach(function(element) {
//             element.addEventListener("click", toggleSections);
//         });
//     }

//     // Initialize the AddReadMore function with desired parameters
// 	AddReadMore(540, " ...read more", " read less", ".add-read-more span", false);
// 	AddReadMore(540, " ...read more", " read less", ".trim-text", true);
// });
// 
// 

  document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function(){
      function addReadMore(charLimit, readMoreText, readLessText, selector) {
          // Select all elements that match the selector
          var elements = document.querySelectorAll(selector);

          elements.forEach(function(element) {
              var content = element.textContent.trim();

              // Check if the content length exceeds the character limit
              if (content.length > charLimit) {
                  var visibleText = content.slice(0, charLimit);
                  var hiddenText = content.slice(charLimit);

                  // Build the new content with Read More / Read Less
                  var newContent = `${visibleText}<span class="dots">...</span><span class="more-text" style="display:none;">${hiddenText}</span>`;
                  newContent += `<span class="read-more" style="color:blue; cursor:pointer;">${readMoreText}</span>`;
                  newContent += `<span class="read-less" style="color:blue; cursor:pointer; display:none;">${readLessText}</span>`;

                  // Replace the original content
                  element.innerHTML = newContent;

                  // Add event listeners for the Read More and Read Less links
                  element.querySelector('.read-more').addEventListener('click', function() {
                      element.querySelector('.dots').style.display = 'none';
                      element.querySelector('.more-text').style.display = 'inline';
                      this.style.display = 'none';
                      element.querySelector('.read-less').style.display = 'inline';
                  });

                  element.querySelector('.read-less').addEventListener('click', function() {
                      element.querySelector('.dots').style.display = 'inline';
                      element.querySelector('.more-text').style.display = 'none';
                      this.style.display = 'none';
                      element.querySelector('.read-more').style.display = 'inline';
                  });
              }
          });
      }

      // Initialize the function with the desired settings
      addReadMore(620, "Read More", "Read Less", ".trim-text");
      },1000);
});