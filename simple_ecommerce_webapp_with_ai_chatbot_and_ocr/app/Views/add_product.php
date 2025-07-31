<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <style>
        body { background: #f4f6f8; font-family: 'Segoe UI', Arial, sans-serif; margin: 0; }
        .form-container {
            background: #fff;
            padding: 2rem 2.5rem;
            border-radius: 10px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            min-width: 350px;
            max-width: 400px;
            margin: 80px auto 0 auto;
        }
        h2 { color: #333; margin-bottom: 1.5rem; text-align:center; }
        label { display: block; margin-bottom: 0.5rem; color: #555; font-weight: 500; }
        input[type="text"], input[type="number"], textarea {
            width: 100%;
            padding: 0.6rem 0.8rem;
            margin-bottom: 1.2rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.2s;
        }
        input[type="text"]:focus, input[type="number"]:focus, textarea:focus {
            border-color: #007bff;
            outline: none;
        }
        button {
            width: 100%;
            padding: 0.7rem;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        button:hover { background: #0056b3; }
        .success { color: #155724; background: #d4edda; border: 1px solid #c3e6cb; padding: 0.8rem 1rem; border-radius: 5px; margin-bottom: 1rem; text-align:center; }
        .error { color: #d8000c; background: #ffd2d2; border: 1px solid #d8000c; padding: 0.8rem 1rem; border-radius: 5px; margin-bottom: 1rem; text-align:center; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Add Product</h2>
        <?php if(session()->getFlashdata('success')): ?>
            <div class="success"><?= session('success') ?></div>
            <div style="text-align:center;margin-bottom:1rem;">
                <a href="<?= site_url('user/home') ?>">
                    <button type="button" style="margin-top:10px;" class="back-btn">Back to Home</button>
                </a>
            </div>
        <?php endif; ?>
        <?php if(isset($validation)): ?>
            <div class="error">
                <?= $validation->listErrors() ?>
            </div>
        <?php endif; ?>
        <form action="<?= site_url('product/add') ?>" method="post">
            <label>Title:</label>
            <input type="text" name="title" required>
            <label>Description:</label>
            <textarea name="description" rows="3"></textarea>
            <label>Price:</label>
            <input type="number" name="price" step="0.01" required>
            <label>Image URL:</label>
            <input type="text" name="image">
            <button type="submit">Add Product</button>
        </form>
    </div>
</body>
</html>
