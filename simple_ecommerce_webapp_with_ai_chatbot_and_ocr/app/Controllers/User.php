<?php
namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class User extends Controller
{
    // Show cart contents
    public function cart()
    {
        $cart = session()->get('cart') ?? [];
        return view('cart', ['cart' => $cart]);
    }
    // Add product to cart (by product id)
    public function addToCart()
    {
        $productId = $this->request->getPost('product_id');
        // For demo, use static product info. In real app, fetch from DB.
        $products = [
            1 => ['id' => 1, 'title' => 'Wireless Headphones', 'price' => 99.99],
            2 => ['id' => 2, 'title' => 'Smart Watch', 'price' => 149.99],
            3 => ['id' => 3, 'title' => 'Bluetooth Speaker', 'price' => 59.99],
        ];
        if (!isset($products[$productId])) {
            return redirect()->back()->with('error', 'Invalid product');
        }
        $cart = session()->get('cart') ?? [];
        if (isset($cart[$productId])) {
            $cart[$productId]['qty'] += 1;
        } else {
            $cart[$productId] = $products[$productId] + ['qty' => 1];
        }
        session()->set('cart', $cart);
        return redirect()->back()->with('success', $products[$productId]['title'] . ' added to cart!');
    }

    // Show user profile info
    public function profile()
    {
        $name = session()->get('name') ?? '';
        $email = '';
        // Try to get email from DB if not in session
        if (session()->has('email')) {
            $email = session()->get('email');
        } else {
            $userModel = new UserModel();
            $user = $userModel->where('name', $name)->first();
            if ($user) {
                $email = $user['email'];
                session()->set('email', $email);
            }
        }
        return view('user_profile', ['name' => $name, 'email' => $email]);
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to(site_url('user/create'));
    }
    public function home()
    {
        // In a real app, get user info from session. Here, just demo with posted name if available.
        $name = session()->get('name') ?? 'User';
        return view('user_home', ['name' => $name]);
    }
    public function create()
    {
        helper(['form']);
        echo view('user_form');
    }

    public function save()
    {
        helper(['form']);
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'name' => 'required',
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]'
        ]);

        if (! $validation->withRequest($this->request)->run()) {
            return view('user_form', [
                'validation' => $validation
            ]);
        }

        $userModel = new UserModel();
        $userModel->save([
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
        ]);

        // Save user name in session and redirect to home
        session()->set('name', $this->request->getPost('name'));
        return redirect()->to(site_url('user/home'));
    }
}
