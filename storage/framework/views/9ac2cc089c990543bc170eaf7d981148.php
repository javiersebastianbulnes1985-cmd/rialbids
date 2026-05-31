<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo e(config('app.name', 'RialBids')); ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body { font-family: 'Inter', sans-serif; }
    .btn-blue { background:#1a56db; color:#fff; padding:10px 20px; border-radius:8px; font-size:14px; font-weight:600; border:none; cursor:pointer; width:100%; transition:background .15s; }
    .btn-blue:hover { background:#1e429f; }
    .input { width:100%; padding:10px 14px; border:1.5px solid #e5e7eb; border-radius:8px; font-size:14px; outline:none; font-family:'Inter',sans-serif; }
    .input:focus { border-color:#1a56db; }
    label { font-size:13px; font-weight:500; color:#374151; display:block; margin-bottom:5px; }
  </style>
</head>
<body style="background:#f3f4f6;min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;">
  <a href="/" style="text-decoration:none;margin-bottom:24px;display:flex;align-items:center;gap:8px;">
    <div style="width:40px;height:40px;background:#1a56db;border-radius:8px;display:flex;align-items:center;justify-content:center;">
      <span style="color:#fff;font-weight:800;font-size:18px;">R</span>
    </div>
    <span style="font-weight:700;font-size:20px;color:#1a56db;">RialBids</span>
  </a>
  <div style="background:#fff;border-radius:12px;padding:32px;width:100%;max-width:420px;box-shadow:0 4px 20px rgba(0,0,0,0.08);">
    <?php echo e($slot); ?>

  </div>
</body>
</html>
<?php /**PATH /home/u396549633/domains/rialbids.com/public_html/resources/views/layouts/guest.blade.php ENDPATH**/ ?>