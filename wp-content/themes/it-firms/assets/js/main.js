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


document.addEventListener('DOMContentLoaded', function() {
    const moreBtns = document.querySelectorAll('.read-text .read-more'); // Select all read more buttons

    moreBtns.forEach(function(moreBtn) {
        const addMore = moreBtn.previousElementSibling; // Get the previous sibling element, assuming it's the .add-read-more paragraph
        
        moreBtn.addEventListener('click', function() {
            // Toggle the class show-more-content on the add-read-more paragraph
            addMore.classList.toggle('show-more-content');
            
            // Adjust the button text based on the state
            if (addMore.classList.contains('show-more-content')) {
                moreBtn.textContent = 'Read Less';
            } else {
                moreBtn.textContent = 'Read More';
            }
        });

        // Check initial height on page load
        const elementHeight = addMore.clientHeight;
        
        // If height is less than 108 pixels, hide the read more button
        if (elementHeight < 135) {
            moreBtn.style.display = 'none';
        }
    });
});




