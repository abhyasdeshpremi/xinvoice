<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['login'] = 'login';
$route['logout'] = 'login/logout';
$route['firm'] = 'firm';
$route['createfirm'] = 'firm/createfirm';
$route['firmdetails(/:num)?'] = 'firm/firmdetails$1';
$route['deletefirm'] = 'firm/deleteFirm';
$route['updatefirm/(:any)'] = 'firm/updateFirm/$1';
$route['createitem'] = 'item/createItem';
$route['updateitem/(:any)'] = 'item/updateItem/$1';
$route['deleteitem'] = 'item/deleteItem';
$route['itemdetails(/:num)?'] = 'item/itemdetails$1';
$route['createuser'] = 'user/createUser';
$route['userdetails(/:num)?'] = 'user/userdetails$1';
$route['deleteuser'] = 'user/deleteUser';
$route['updateuser/(:any)'] = 'user/updateUser/$1';
$route['createclient'] = 'client/createClient';
$route['clientdetails(/:num)?'] = 'client/clientdetails$1';
$route['deleteclient'] = 'client/deleteClient';
$route['updateclient/(:any)'] = 'client/updateClient/$1';
$route['getclientid'] = 'client/getclientID';
$route['createcompany'] = 'company/createCompany';
$route['companydetails(/:num)?'] = 'company/companydetails$1';
$route['deletecompany'] = 'company/deleteCompany';
$route['updatecompany/(:any)'] = 'company/updateCompany/$1';
$route['createinvoice'] = 'invoice/createinvoiceID';
$route['createinvoice/(:any)'] = 'invoice/createinvoice/$1';
$route['createinvoicepdf/(:any)/(:any)/(:num)'] = 'invoice/createInvoicePDF/$1/$2/$3';
$route['invoicedetail(/:num)?'] = 'invoice/invoicedetails$1';
$route['getinvoicelist'] = 'invoice/getinvoicelist';
$route['savevoiceheader'] = 'invoice/saveInvoiceHeader';
$route['deleteinvoiceitem'] = 'invoice/deleteInvoiceItem';
$route['getitemcode'] = 'invoice/getItemCode';
$route['saveitemininvoce'] = 'invoice/saveItemInInvoice';
$route['updateitemininvoce'] = 'invoice/updateItemInInvoice';
$route['getstockquantity'] = 'invoice/getStockQuantity';
$route['updateinvoicestatus'] = 'invoice/updateInvoiceStatus';

$route['createpurchaseinvoice'] = 'purchase/createinvoiceID';
$route['createpurchaseinvoice/(:any)'] = 'purchase/createinvoice/$1';
$route['createpurchaseinvoicepdf/(:any)/(:any)/(:num)'] = 'purchase/createInvoicePDF/$1/$2/$3';

$route['savepurchaseiteminvoice'] = 'purchase/saveItemInInvoice';
$route['updatepurchaseitemininvoce'] = 'purchase/updateItemInInvoice';

$route['invoicepurchasedetail(/:num)?'] = 'purchase/invoicedetails$1';
$route['getPurchaseinvoicelist'] = 'purchase/getinvoicelist';
$route['deletepurchaseinvoiceitem'] = 'purchase/deleteInvoiceItem';

$route['getstock(/:num)?'] = 'stock/getStock$1';
$route['getstocklog(/:num)?'] = 'stock/getstocklog$1';
$route['savestock'] = 'stock/saveStock';

$route['purchase'] = 'purchase_invoice/purchaseInvoice';

$route['ledger'] = 'ledger/getledger';
$route['stock'] = 'ledger/getstock';
$route['sales'] = 'ledger/getsaleresister';
$route['stockreport'] = 'ledger/stockReport';

$route['getaccount(/:num)?'] = 'account/getAccount$1';
$route['getaccounthistory(/:num)?'] = 'account/getAccountHistory$1';
$route['getclientaccounthistory/:any(/:num)?'] = 'account/getClientAccountHistory$1$2';
$route['saveamount'] = 'account/saveAmount';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
