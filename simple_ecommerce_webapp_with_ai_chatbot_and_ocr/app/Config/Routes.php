 <?php
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->match(['get', 'post'], 'product/add', 'Product::add');
$routes->get('user/cart', 'User::cart');
$routes->post('user/addToCart', 'User::addToCart');
$routes->get('user/profile', 'User::profile');
$routes->get('/', 'Home::index');
$routes->post('home/ocr', 'Home::ocr');
