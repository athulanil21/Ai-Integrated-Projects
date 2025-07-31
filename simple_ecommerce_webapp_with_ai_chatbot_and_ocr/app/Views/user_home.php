<!DOCTYPE html>
<html>
<head>
    <title>User Home</title>
    <style>
        body {
            background: #f4f6f8;
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            min-height: 100vh;
        }
        .topbar {
            width: 100vw;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 1rem 2rem 1rem 1rem;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 10;
        }
        .topbar .actions {
            display: flex;
            gap: 1.2rem;
            align-items: center;
        }
        .topbar form {
            margin: 0;
        }
        .icon-btn, .logout-btn {
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: 600;
            padding: 0.5rem 1.1rem;
            cursor: pointer;
            transition: background 0.2s;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }
        .icon-btn:hover, .logout-btn:hover {
            background: #0056b3;
        }
        .main-content {
            margin-top: 90px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .home-container {
            background: #fff;
            padding: 2rem 2.5rem;
            border-radius: 10px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            min-width: 350px;
            text-align: center;
            margin-bottom: 2rem;
        }
        h2 {
            color: #333;
            margin-bottom: 1rem;
        }
        .welcome {
            font-size: 1.2rem;
            color: #555;
            margin-bottom: 2rem;
        }
        .products {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            justify-content: center;
        }
        .product-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
            width: 240px;
            padding: 1.2rem 1rem 1.5rem 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: box-shadow 0.2s;
        }
        .product-card:hover {
            box-shadow: 0 6px 24px rgba(0,123,255,0.13);
        }
        .product-card img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 1rem;
        }
        .product-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #222;
            margin-bottom: 0.5rem;
        }
        .product-desc {
            font-size: 0.97rem;
            color: #666;
            margin-bottom: 0.7rem;
        }
        .product-price {
            font-size: 1.05rem;
            color: #007bff;
            font-weight: 600;
            margin-bottom: 0.7rem;
        }
        .product-actions button {
            background: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 0.5rem 1rem;
            font-size: 0.97rem;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
        }
        .product-actions button:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <div class="topbar">
        <div class="actions">
            <button class="icon-btn" title="Compare">
                <span>🔍</span> Compare
            </button>
            <form action="<?= site_url('user/cart') ?>" method="get" style="display:inline;">
                <button class="icon-btn" title="Cart" type="submit">
                    <span>🛒</span> Cart
                </button>
            </form>
            <form action="<?= site_url('user/profile') ?>" method="get" style="display:inline;">
                <button class="icon-btn" title="Profile" type="submit">
                    <span>👤</span> Profile
                </button>
            </form>
            <form action="<?= site_url('product/add') ?>" method="get" style="display:inline;">
                <button class="icon-btn" title="Add Product" type="submit">
                    <span>➕</span> Add Product
                </button>
            </form>
            <form action="<?= site_url('user/logout') ?>" method="post" style="display:inline;">
                <button class="logout-btn" type="submit">Logout</button>
            </form>
        </div>
    </div>
    <?php if(session()->getFlashdata('success')): ?>
        <div style="margin-top:100px;text-align:center;">
            <div style="display:inline-block;background:#d4edda;color:#155724;padding:0.8rem 1.5rem;border-radius:6px;border:1px solid #c3e6cb;"> 
                <?= session('success') ?>
            </div>
        </div>
    <?php elseif(session()->getFlashdata('error')): ?>
        <div style="margin-top:100px;text-align:center;">
            <div style="display:inline-block;background:#f8d7da;color:#721c24;padding:0.8rem 1.5rem;border-radius:6px;border:1px solid #f5c6cb;"> 
                <?= session('error') ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="main-content">
        <div class="home-container">
            <h2>Welcome, <?= esc($name) ?>!</h2>
            <div class="welcome">You have successfully logged in.</div>
            <hr style="margin:2rem 0;">
            <form action="<?= site_url('home/ocr') ?>" method="post" enctype="multipart/form-data" style="margin-bottom:1.5rem;">
                <label for="ocr_image" style="font-weight:600;">Upload Image for OCR:</label><br>
                <input type="file" name="ocr_image" id="ocr_image" accept="image/*" required style="margin:1rem 0;">
                <button type="submit" class="icon-btn">Run OCR</button>
            </form>
            <?php if(isset($ocr_text)): ?>
                <div style="background:#f1f1f1;padding:1rem 1.5rem;border-radius:8px;margin-bottom:1rem;text-align:left;max-width:600px;margin:auto;">
                    <strong>OCR Result:</strong><br>
                    <pre style="white-space:pre-wrap;word-break:break-word;"><?= esc($ocr_text) ?></pre>
                </div>
            <?php endif; ?>
            <?php if(isset($ocr_error)): ?>
                <div style="background:#f8d7da;color:#721c24;padding:0.8rem 1.5rem;border-radius:6px;border:1px solid #f5c6cb;margin-bottom:1rem;"> 
                    <?= esc($ocr_error) ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="products">
            <div class="product-card">
                <img src="https://images.unsplash.com/photo-1513708927688-890fe41c2e99?auto=format&fit=crop&w=400&q=80" alt="Product 1">
                <div class="product-title">Wireless Headphones</div>
                <div class="product-desc">High quality sound, noise cancelling, 20h battery.</div>
                <div class="product-price">$99.99</div>
                <div class="product-actions">
                    <form class="add-to-cart-form" method="post" action="<?= site_url('user/addToCart') ?>">
                        <input type="hidden" name="product_id" value="1">
                        <button type="submit">Add to Cart</button>
                    </form>
                </div>
            </div>
            <div class="product-card">
                <img src="https://images.unsplash.com/photo-1503602642458-232111445657?auto=format&fit=crop&w=400&q=80" alt="Product 2">
                <div class="product-title">Smart Watch</div>
                <div class="product-desc">Fitness tracking, notifications, waterproof.</div>
                <div class="product-price">$149.99</div>
                <div class="product-actions">
                    <form class="add-to-cart-form" method="post" action="<?= site_url('user/addToCart') ?>">
                        <input type="hidden" name="product_id" value="2">
                        <button type="submit">Add to Cart</button>
                    </form>
                </div>
            </div>
            <div class="product-card">
                <img src="https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=400&q=80" alt="Product 3">
                <div class="product-title">Bluetooth Speaker</div>
                <div class="product-desc">Portable, waterproof, 12h playtime.</div>
                <div class="product-price">$59.99</div>
                <div class="product-actions">
                    <form class="add-to-cart-form" method="post" action="<?= site_url('user/addToCart') ?>">
                        <input type="hidden" name="product_id" value="3">
                        <button type="submit">Add to Cart</button>
                    </form>
                </div>
            </div>
</style>
<script>
// Optionally, use AJAX for Add to Cart (uncomment to enable AJAX)
// document.querySelectorAll('.add-to-cart-form').forEach(form => {
//     form.addEventListener('submit', function(e) {
//         e.preventDefault();
//         const formData = new FormData(form);
//         fetch(form.action, {
//             method: 'POST',
//             body: formData
//         })
//         .then(res => res.json())
//         .then(data => {
//             if(data.success) alert('Added to cart!');
//             else alert('Error adding to cart');
//         });
//     });
// });
</script>
        </div>
    </div>
</body>
<script> window.chtlConfig = { chatbotId: "2964486384" } </script>
<script async data-id="2964486384" id="chtl-script" type="text/javascript" src="https://chatling.ai/js/embed.js"></script>
</html>
