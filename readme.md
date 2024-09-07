
# mi eCommerce

mi-eCommerce is a simple eCommerce website with basic e-commerce functionalities, made with **CodeIgniter 3**.

## Features

- **Customer**:
  ```bash
  - Register
  - Login
  - Search for products
  - Add products to wishlist
  - Create orders
  - View orders
  ```

- **Seller**:
  ```bash
  - Login
  - View & Edit Products
  - View & Edit Product Categories
  - Confirm Orders
  - View Sales Reports
  ```

## Installation

- Copy the env.example file then rename it to .env

```bash
cp .env.example .env
```

- Create a database then modify the `.env` file to match your database settings.

- Migrate the database:

### Migrate by Browser
```bash
http://localhost/mi-ecommerce/migration
```

### Migrate by CLI
```bash
php index.php migration
```

## Demo
# Images

1. **Home Page**  
   The homepage displays a list of products, paginated to show 8 products per page.  

   ![1.Homepage](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/1.homepage.PNG?raw=true)  

2. **Login Page**  
   Users can log in after registration.  

   ![2.Login](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/2.login%20page.PNG?raw=true)  

3. **Registration Page**  
   Users can register using an email address.  

   ![3.registration](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/3.registration%20page.PNG?raw=true)  

4. **Forgot Password Page**  
   Forgot password page (UI only, no functionality).  

   ![4.forgot](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/4.forgot%20page.PNG?raw=true)  

5. **Cart Page**  
   Cart is stored in the session and is not yet linked to the logged-in user.  

   ![5.cart](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/5.cart%20page.PNG?raw=true)  

6. **Checkout Address Page**  
   Users can input the shipping address.  

   ![6.checkout](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/6.checkout%20address.PNG?raw=true)  

7. **Checkout Delivery Page**  
   Users can choose a delivery method.  

   ![7.checkout](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/7.checkout%20delivery.PNG?raw=true)  

8. **Checkout Payment Page**  
   Payment method selection page.  

   ![8.checkout](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/8.checkout%20payment.PNG?raw=true)  

9. **Checkout Review Page**  
   Users can review their order before placing it.  

   ![9.checkout](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/9.checkout%20review.PNG?raw=true)  

10. **Product Detail Page**  
    Users can add products to the cart or wishlist.  

    ![9.product](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/9.product%20detail%20page.PNG?raw=true)  

11. **Customer Order Page**  
    Users can view their orders in the profile section.  

    ![10.profile](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/10.profile%20-%20order%20page.PNG?raw=true)  

12. **Customer Wishlist Page**  
    Products added to the wishlist are displayed here.  

    ![11.profile](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/11.profile%20-%20wishlist%20page.PNG?raw=true)  

13. **Customer Profile Page**  
    Users can change their password and update their shipping details.  

    ![12.profile](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/12.profile%20-%20account%20page.PNG?raw=true)  

14. **Seller Dashboard Page**  
    Displays transaction summary in chart form.  

    ![13.seller](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/13.seller%20dashboard%20page.PNG?raw=true)  

15. **Seller Login Page**  
    Seller login page for accessing the seller panel.  

    ![13.seller](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/13.seller%20login%20page.PNG?raw=true)  

16. **Seller Confirm Order Page**  
    Sellers can confirm orders here.  

    ![14.seller](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/14.seller%20confirm%20order%20page.PNG?raw=true)  

17. **Seller Detail Order Page**  
    Displays details of a specific order.  

    ![15.seller](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/15.seller%20detail%20order%20page.PNG?raw=true)  

18. **Seller Product List Page**  
    Displays a list of products for the seller to manage.  

    ![16.seller](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/16.seller%20master%20product%20page.PNG?raw=true)  

19. **Seller Input Product Page**  
    Page to insert or edit products.  

    ![17.seller](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/17.seller%20modify%20product%20page.PNG?raw=true)  

20. **Seller Sales Report Page**  
    Displays sales reports.  

    ![18.seller](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/18.seller%20sales%20report%20page.PNG?raw=true)  

## Live Demo
- Live demo can be found at [live-demo](https://mi-ecommerce-pi.vercel.app/)

## Footnote
- This project was created to complete the task "Test Membuat System E-commerce mini berbasis WEB" from codehouse.com.

## Templates Used
- Admin backend: [adminlte](https://adminlte.io)
- Frontend: [Universal free e-commerce template](https://bootstrapious.com/p/universal-business-e-commerce-template)

## License
Licensed under [MIT license](http://www.opensource.org/licenses/mit-license.php).
