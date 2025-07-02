document.addEventListener('DOMContentLoaded', () => {

   const navbar = document.querySelector('.header .navbar');
   const accountBox = document.querySelector('.header .account-box');
   const menuBtn = document.querySelector('#menu-btn');
   const userBtn = document.querySelector('#user-btn');
   const closeUpdateBtn = document.querySelector('#close-update');
   const editProductForm = document.querySelector('.edit-product-form');

   // Toggle navbar visibility
   if (menuBtn && navbar && accountBox) {
      menuBtn.addEventListener('click', (e) => {
         e.stopPropagation();
         navbar.classList.toggle('active');
         accountBox.classList.remove('active');
      });
   }

   // Toggle user/account box
   if (userBtn && accountBox && navbar) {
      userBtn.addEventListener('click', (e) => {
         e.stopPropagation();
         accountBox.classList.toggle('active');
         navbar.classList.remove('active');
      });
   }

   // Close on scroll
   window.addEventListener('scroll', () => {
      navbar?.classList.remove('active');
      accountBox?.classList.remove('active');
   });

   // Close edit product form and redirect
   if (closeUpdateBtn && editProductForm) {
      closeUpdateBtn.addEventListener('click', () => {
         editProductForm.style.display = 'none';
         window.location.href = 'admin_products.php';
      });
   }

   // Click outside to close dropdowns (optional but useful)
   document.addEventListener('click', (e) => {
      if (!navbar?.contains(e.target) && !menuBtn?.contains(e.target)) {
         navbar?.classList.remove('active');
      }
      if (!accountBox?.contains(e.target) && !userBtn?.contains(e.target)) {
         accountBox?.classList.remove('active');
      }
   });

});

