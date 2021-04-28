# mi eCommerce

mi-eCommerce is a simple eCommerce website with basic e-commerce functionalities, made with codeIgniter 3 

## Features

- Customer

```bash
- Register
- Login
- Searching product
- Add Product to wishlist
- Create Order
- View Order
```
- Seller

```bash
- Login
- View & Edit Product
- View & Edit Product Categories
- Confirm Order
- View Sales Report
```

## Installation

- Copy the env.example file then rename to .env

```bash
cp .env.example .env
```
- create database then modify .env file to match your database settings

- migrate the database

### migrate by browser
```bash
http://localhost/mi-ecommerce/migration
```
### migrate by CLI

```bash
php index.php migration
```

## Demo
# images
1. **home page**

    Home page menampilkan list product yang ditampilkan dengan paging per page 8

![1.Homepage](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/1.homepage.PNG?raw=true)  
2. **login page**

    Halaman login, pengguna dapat login setelah melakukan registrasi

![2.Login](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/2.login%20page.PNG?raw=true)  
3. **registration page**

    Halaman Registrasi, pengguna dapat melakukan pendaftaran dengan menggunakan alamat email

![3.registration](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/3.registration%20page.PNG?raw=true)  
4. **forgot page**

    Halaman Forgot password (hanya tampilan, tidak ada fungsionalitas)

![4.forgot](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/4.forgot%20page.PNG?raw=true)  
5. **cart page**

    Halaman Cart, cart disimpan di session dan belum terikat ke user yang login

![5.cart](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/5.cart%20page.PNG?raw=true)  
6. **checkout adress page**

    Halaman Checkout adress

![6.checkout](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/6.checkout%20address.PNG?raw=true)  
7. **checkout delivery page**

    Halaman Checkout delivery

![7.checkout](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/7.checkout%20delivery.PNG?raw=true)  
8. **checkout payment page**

    Halaman Checkout payment

![8.checkout](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/8.checkout%20payment.PNG?raw=true)  
9. **checkout review page**

    Halaman Checkout review

![9.checkout](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/9.checkout%20review.PNG?raw=true)  
10. **product detail page**  

    Halaman detail product, pengguna dapat menambahkan product ke ke keranjang atau menambah item ke wishlist

![9.product](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/9.product%20detail%20page.PNG?raw=true)  
11. **customer order page**  

    Halaman profile, pengguna dapat melihat daftar pesanan pada menu profile, pengguna diwajibkan login terlebih dahulu

![10.profile](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/10.profile%20-%20order%20page.PNG?raw=true)  
12. **customer wishlist page**  

    Halaman wishlist, produk yang ditambahkan ke wishlist akan muncul disini

![11.profile](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/11.profile%20-%20wishlist%20page.PNG?raw=true)  
13. **customer profile page**  

    Halaman profile, pengguna dapat mengganti password, dan mengubah nama pengiriman serta alamat pengiriman disini

![12.profile](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/12.profile%20-%20account%20page.PNG?raw=true)  
14. **seller dashboard page**  

    Halaman dashboard seller, menampilkan rekap transakdi dalam bentuk chart

![13.seller](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/13.seller%20dashboard%20page.PNG?raw=true)  
15. **seller login page**  

    Halaman login seller, seller dapat mengakses halaman seller setelah login

![13.seller](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/13.seller%20login%20page.PNG?raw=true)  
16. **seller confirm order page**  

    Halaman confirm order, seller dapat mengkonfirmasi pesanan di halaman ini

![14.seller](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/14.seller%20confirm%20order%20page.PNG?raw=true)  
17. **seller detail order page**  

    Halaman detail order, berisi informasi pesanan yang dibuat

![15.seller](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/15.seller%20detail%20order%20page.PNG?raw=true)  
18. **seller list product page**  

    Halaman list product, menampilkan list master product

![16.seller](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/16.seller%20master%20product%20page.PNG?raw=true)  
19. **seller input product page**  

    Halaman input product, merupakan tampilan jika melakukan insert/ edit product

![17.seller](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/17.seller%20modify%20product%20page.PNG?raw=true)  
20. **seller sales report page**  

    Halaman Sales report

![18.seller](https://github.com/agussuwerdo/images/blob/main/mi_ecommerce/18.seller%20sales%20report%20page.PNG?raw=true)  

## Live Demo
- Live demo can be found at [live-demo](https://mi-ecommerce.kaosbandungan.co.id) 

## Footnote
- This project was made to complete task "Test Membuat System E-commerce mini berbasis WEB" from codehouse.com

## Templates used
- admin backend : [adminlte](https://adminlte.io)
- frontend : [universal free e-commerce template](https://bootstrapious.com/p/universal-business-e-commerce-template)

## License
Under [MIT license](http://www.opensource.org/licenses/mit-license.php)
