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
$route['register'] = 'login/register';
$route['logout'] = 'login/logout';
$route['checkfirmuniquecode'] = 'login/checkfirmuniquecode';
$route['checkuseremail'] = 'login/checkuseremail';
$route['checkusername'] = 'login/checkusername';
$route['registeruser'] = 'login/registeruser';
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
$route['viewinvoicepdf/(:any)/(:any)/(:num)'] = 'invoice/viewInvoicePDF/$1/$2/$3';
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
$route['viewpurchaseinvoicepdf/(:any)/(:any)/(:num)'] = 'purchase/viewInvoicePDF/$1/$2/$3';

$route['savepurchaseiteminvoice'] = 'purchase/saveItemInInvoice';
$route['updatepurchaseitemininvoce'] = 'purchase/updateItemInInvoice';

$route['invoicepurchasedetail(/:num)?'] = 'purchase/invoicedetails$1';
$route['getPurchaseinvoicelist'] = 'purchase/getinvoicelist';
$route['deletepurchaseinvoiceitem'] = 'purchase/deleteInvoiceItem';

$route['getstock(/:num)?'] = 'stock/getStock$1';
$route['getstocklog(/:num)?'] = 'stock/getstocklog$1';
$route['getitemstocklog/:any(/:num)?'] = 'stock/getItemStocklog$1$2';
$route['savestock'] = 'stock/saveStock';

$route['orders(/:num)?'] = 'order/ordersList$1';
$route['createorder'] = 'order/createorderID';
$route['createorder/(:any)'] = 'order/createorder/$1';
$route['saveorderheader'] = 'order/saveOrderHeader';
$route['updateorderstatus'] = 'order/updateOrderStatus';
$route['saveitemorder'] = 'order/saveItemInOrder';
$route['updateitemorder'] = 'order/updateItemInOrder';
$route['deleteorderitem'] = 'order/deleteOrderItem';
$route['createorderpdf/(:any)/(:any)/(:num)'] = 'order/createOrderPDF/$1/$2/$3';

$route['purchase'] = 'purchase_invoice/purchaseInvoice';

$route['ledger'] = 'ledger/getClient';
$route['invoice'] = 'ledger/getInvoice';
$route['stock'] = 'ledger/getstock';
$route['sales'] = 'ledger/getsaleresister';
$route['stockreport'] = 'ledger/stockReport';
$route['downloadpdf/:any/:any'] = 'ledger/getPDF/$1/$2';

$route['clientreport'] = 'ledger/clientReport';
$route['downloadclientpdf/:any/:any'] = 'ledger/getClinetPDF/$1/$2';

$route['invoicereport'] = 'ledger/invoiceReport';
$route['downloadinvoicepdf/:any/:any'] = 'ledger/getinvoicePDF/$1/$2';

$route['salereport'] = 'ledger/saleReport';
$route['downloadsalepdf/:any/:any'] = 'ledger/getSalePDF/$1/$2';

$route['getaccount(/:num)?'] = 'account/getAccount$1';
$route['getaccounthistory(/:num)?'] = 'account/getAccountHistory$1';
$route['getclientaccounthistory/:any(/:num)?'] = 'account/getClientAccountHistory$1$2';
$route['saveamount'] = 'account/saveAmount';

$route['account/:any'] = 'profile/Account/$1';
$route['changepassword'] = 'profile/ChangePassword';
$route['changedpassword'] = 'profile/ChangedPassword';


$route['newaccountholder'] = 'piggyBank/NewAccountHolder';
$route['accountholderlist(/:num)?'] = 'piggyBank/accountHolderList$1';
$route['updateaccountholder/(:any)'] = 'piggyBank/updateAccountHolder/$1';
$route['deleteaccountholder'] = 'piggyBank/deleteAccountHolder';
$route['accountholderbalance(/:num)?'] = 'piggyBank/accountHolderBalance$1';
$route['savepiggybankamount'] = 'piggyBank/savePiggyBankAmount';

$route['getaccountholderhistory(/:num)?'] = 'piggyBank/getAccountHolderHistory$1';
$route['getclientaccountholderhistory/:any(/:num)?'] = 'piggyBank/getClientAccountHolderHistory$1$2';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
