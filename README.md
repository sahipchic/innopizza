# InnoPizza

This project is created for if you would like to start a new pizza delivery business. Task is to create a web application for
ordering pizza for your clients, which contains a shopping cart. Taking the pizza order and the
delivery address and contact details for the client. Login is not required but could be available
for checking the history of orders. 

Project consists of 3 main parts - `Main Page`, where you can find 
`Menu` section, there are all pizzas which are available for your order,
`Reviews` section, there are shown all reviews, which were written by customers
and were moderated by administrator. Also there is a section, 
where customers can leave their own review, which will be sent for moderation.
Likewise there is a `Phone request` section, where you can leave a request to call the operator to clarify something.

Second part of project is a `Place Order Page`, where you have to 
place your order - fill delivery address, contact details and bank details for online payment.

Third part - `Admin Page`, which consists of authorization form, which is required
because only admins have to have access to this page.
Also there are 4 tabs to manage all processes - history of orders,
active reviews, which are shown on the main page, waiting reviews, 
which are waiting for moderating by admin, and waiting phone requests.

`Link for main` - [Main Page](https://innopizza1.herokuapp.com/)

`Link for placing order` - [Place Order Page](https://innopizza1.herokuapp.com/placeOrder.php)

`Link for admins` - [Admin Page](https://innopizza1.herokuapp.com/admin.php)

###Now let's get to the details

There are 5 tables in the database:
1) `admin_info` - contains information about the admin's username and password
2) `areviews` - contains information about waiting, active, rejected and deleted reviews, which can be edited by admin
3) `arequests` - contains information about actual and closed phone requests which are sent by customers
4) `apizzas` - contains information about pizzas, which are shown in the `Menu` section on the `Main Page`
5) `aorders` - contains information about pizza orders that are placed on the page `Place Order`

Tabs on the admin page:
1) History - there is a table which consists of the main details of user's orders
2) Waiting reviews - table with the fields of review info and 2 buttons - `Accept` or `Reject` current waiting review
3) Active reviews - table with the reviews with `active` status and which are also shown on the `Main Page`, that can be deleted by admin
4) Waiting requests - table with unprocessed requests, which can be closed after the operator dials the person who left the request

Also there are 2 buttons - `update` the page and `exit` back to the login form.


Main Page:
 1) It has a `shopping cart` that displays all selected pizzas with a further possible transition to ordering for them.
2) `Place order` button is responsible for moving to checkout your current order.
3) `Request form` for a phone call from the operator is located on the second slide of the carousel under the header.
4) `Menu` has 9 different cards with pizzas with their own photo, description and `Add to Cart` button.
5) `Reviews` is a carousel in which all active reviews from users are rotated.
6) `Write your own review` is a form where you can write review about the service and send it for admin's moderating

*Framework used for design* - `Bootstrap`

FrontEnd part - `index.php`, `placeOrder.php`, `admin.php`

BackEnd part - all other `php` files






