# op2wp

Opencart to Wordpress
Developer: alexander.rios@gmail.com

This plugin is intended to get the user session from Opencart to Wordpress.
Right now is a very basic plugin and was written for a specific necessity for a client. But if any one else find a starter point here, feel free to use it and help to improve it.

What do this plugin?

Currently, this plugin is able to get the user's session data and the user's cart data, if the user is logged in.

TODO
Get guest user's session and guest's cart data

How this plugin work?

This plugin is built using WordPress Plugin Boilerplate (https://github.com/DevinVinson/WordPress-Plugin-Boilerplate), and currently it is just using the public face. So, you will find the admin face just how it comes from DevinVinson's repository.

Basically, this plugin import some opencart libraries and query the opencart db.

How to setup?

Setup your opencart data:
1. Open public/op2wp_public.php class file
2. Edit function get_opencart_data to fit your paths and db passwd.
3. Edit function get_oc_db with your opencart db data.

How to use it?

In your wordpress frontend, you can instantiate the class and therefore use the method $op2wp->get_opencart_data() to know if the user is logged in and retrieve his data.

eg:
$op2wp=new op2wp_public('op2wp','1.0.0');
$ocUser=$op2wp->get_opencart_data();
if($ocUser !== false){
 //print user data
}else{
  //print another else thing here
}

