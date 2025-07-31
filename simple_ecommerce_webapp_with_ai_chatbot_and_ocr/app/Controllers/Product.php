<?php
namespace App\Controllers;

use App\Models\ProductModel;
use CodeIgniter\Controller;

class Product extends Controller
{
    public function add()
    {
        helper(['form']);
        $validation = \Config\Services::validation();
        $validation->setRules([
            'title' => 'required',
            'price' => 'required|numeric',
        ]);

        if ($this->request->getMethod() === 'post') {
            if (! $validation->withRequest($this->request)->run()) {
                return view('add_product', [
                    'validation' => $validation
                ]);
            }
            $productModel = new ProductModel();
            $productModel->save([
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'price' => $this->request->getPost('price'),
                'image' => $this->request->getPost('image'),
            ]);
            return redirect()->to(site_url('product/add'))->with('success', 'Product added successfully!');
        }
        return view('add_product');
    }
}
