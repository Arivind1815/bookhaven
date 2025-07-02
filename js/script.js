document.addEventListener('DOMContentLoaded', () => {

   const userBox = document.querySelector('.header .header-2 .user-box');
   const navbar = document.querySelector('.header .header-2 .navbar');
   const userBtn = document.querySelector('#user-btn');
   const menuBtn = document.querySelector('#menu-btn');
   const header2 = document.querySelector('.header .header-2');

   // Toggle user box
   if (userBtn && userBox) {
      userBtn.addEventListener('click', (e) => {
         e.stopPropagation();
         userBox.classList.toggle('active');
         navbar?.classList.remove('active');
      });

      userBtn.addEventListener('touchstart', (e) => {
         e.preventDefault();
         userBox.classList.toggle('active');
         navbar?.classList.remove('active');
      }, { passive: true });
   }

   // Toggle navbar
   if (menuBtn && navbar) {
      menuBtn.addEventListener('click', (e) => {
         e.stopPropagation();
         navbar.classList.toggle('active');
         userBox?.classList.remove('active');
      });

      menuBtn.addEventListener('touchstart', (e) => {
         e.preventDefault();
         navbar.classList.toggle('active');
         userBox?.classList.remove('active');
      }, { passive: true });
   }

   // Scroll behavior for sticky header
   window.addEventListener('scroll', () => {
      userBox?.classList.remove('active');
      navbar?.classList.remove('active');

      if (header2) {
         if (window.scrollY > 60) {
            header2.classList.add('active');
         } else {
            header2.classList.remove('active');
         }
      }
   });

   // Click outside to close dropdowns
   document.addEventListener('click', (e) => {
      if (userBox && !userBox.contains(e.target) && !userBtn.contains(e.target)) {
         userBox.classList.remove('active');
      }

      if (navbar && !navbar.contains(e.target) && !menuBtn.contains(e.target)) {
         navbar.classList.remove('active');
      }
   });

});
