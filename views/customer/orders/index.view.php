<?php
include __DIR__ . '/../../partials/header.view.php';
include __DIR__ . '/../nav.view.php';

function statusGroup($status) {
    switch ($status) {
        case 'pending':
        case 'accepted':
        case 'preparing':
        case 'out for delivery':
            return 'active';
        case 'delivered':
            return 'completed';
        case 'cancelled':
            return 'cancelled';
        default:
            return 'all';
    }
}

function statusStyle($status) {
    $map = [
        'pending'           => ['bg' => '#FEF3E2', 'color' => '#D08700'],
        'accepted'          => ['bg' => '#E8F1FE', 'color' => '#2563EB'],
        'preparing'         => ['bg' => '#FEF0E2', 'color' => '#D9720E'],
        'out for delivery'  => ['bg' => '#E8F1FE', 'color' => '#2563EB'],
        'delivered'         => ['bg' => '#E7F7EE', 'color' => '#1F9254'],
        'cancelled'         => ['bg' => '#FDEAEA', 'color' => '#DC2626'],
    ];
    return $map[$status] ?? ['bg' => '#EEE', 'color' => '#333'];
}

$counts = ['all' => count($orders), 'active' => 0, 'completed' => 0, 'cancelled' => 0];
foreach ($orders as $o) {
    $counts[statusGroup($o['status'])]++;
}

$activeTab = isset($_GET['tab']) ? $_GET['tab'] : 'all';
$validTabs = ['all', 'active', 'completed', 'cancelled'];
if (!in_array($activeTab, $validTabs)) {
    $activeTab = 'all';
}

$filteredOrders = array_filter($orders, function ($o) use ($activeTab) {
    return $activeTab === 'all' || statusGroup($o['status']) === $activeTab;
});
?>

<link rel="stylesheet" href="/Talabat/public/CSS/orders.css">

<style>
  .orders-content { padding: 28px 32px 60px; max-width: 1180px; margin: 0 auto; }
  .orders-content h1.title { font-size: 24px; color: #1a1a1a; margin-bottom: 18px; }

  .tabs {
    display:flex; background:#fff; border-radius:8px; padding:4px;
    width:fit-content; margin-bottom:20px; gap:2px;
  }
  .tab {
    padding:9px 18px; border-radius:6px; font-size:14px; color:#777;
    text-decoration:none; display:flex; align-items:center; gap:6px;
  }
  .tab.active { background:#f6f1ea; color:#1a1a1a; font-weight:600; box-shadow: inset 0 0 0 1px #eee; }
  .tab-count { background:#eee; color:#666; font-size:11px; padding:1px 6px; border-radius:8px; }
  .tab.active .tab-count { background:#f3402c; color:#fff; }

  .order-card { background:#fff; border-radius:10px; padding:18px 20px; margin-bottom:14px; }
  .order-top { display:flex; justify-content:space-between; align-items:flex-start; }
  .order-info .restaurant { font-size:15px; font-weight:700; color:#1a1a1a; margin-bottom:2px; }
  .order-info .order-id { font-size:12px; color:#999; margin-bottom:8px; }
  .order-info .items { font-size:13px; color:#555; margin-bottom:10px; }

  .status-pill {
    font-size:12px; font-weight:600; padding:4px 12px; border-radius:20px;
    display:flex; align-items:center; gap:5px; white-space:nowrap;
  }
  .status-pill .dot { width:6px; height:6px; border-radius:50%; background:currentColor; }

  .order-bottom { display:flex; justify-content:space-between; align-items:flex-end; margin-top:4px; }
  .price { font-size:16px; font-weight:700; color:#1a1a1a; }
  .date { font-size:12px; color:#999; margin-top:2px; }
  .view-details { font-size:13px; color:#555; text-decoration:none; font-weight:500; }
  .view-details:hover { color:#f3402c; }

  .review {
    margin-top:14px; padding-top:12px; border-top:1px solid #f0f0f0;
    font-size:13px; color:#555; display:flex; align-items:center; gap:8px;
  }
  .stars { color:#f5a623; letter-spacing:1px; font-size:13px; }

  .empty-state { text-align:center; color:#999; padding:60px 0; font-size:14px; }
</style>

<div class="orders-content">
  <h1 class="title">My Orders</h1>

  <div class="tabs">
    <a href="?tab=all" class="tab <?= $activeTab === 'all' ? 'active' : '' ?>">
      All <span class="tab-count"><?= $counts['all'] ?></span>
    </a>
    <a href="?tab=active" class="tab <?= $activeTab === 'active' ? 'active' : '' ?>">
      Active <span class="tab-count"><?= $counts['active'] ?></span>
    </a>
    <a href="?tab=completed" class="tab <?= $activeTab === 'completed' ? 'active' : '' ?>">
      Completed <span class="tab-count"><?= $counts['completed'] ?></span>
    </a>
    <a href="?tab=cancelled" class="tab <?= $activeTab === 'cancelled' ? 'active' : '' ?>">
      Cancelled <span class="tab-count"><?= $counts['cancelled'] ?></span>
    </a>
  </div>

  <?php if (empty($filteredOrders)): ?>
    <div class="empty-state">لا توجد طلبات في هذا القسم</div>
  <?php else: ?>
    <?php foreach ($filteredOrders as $order): ?>
      <?php $st = statusStyle($order['status']); ?>
      <div class="order-card">
        <div class="order-top">
          <div class="order-info">
            <?php if (!empty($order['restaurant_name'])): ?>
              <div class="restaurant"><?= htmlspecialchars($order['restaurant_name']) ?></div>
            <?php endif; ?>
            <div class="order-id">#ORD-<?= htmlspecialchars($order['id']) ?></div>
            <div class="items"><?= htmlspecialchars(implode(', ', $order['items'])) ?></div>
          </div>
          <div class="status-pill" style="background:<?= $st['bg'] ?>; color:<?= $st['color'] ?>;">
            <span class="dot"></span><?= htmlspecialchars(ucfirst($order['status'])) ?>
          </div>
        </div>
        <div class="order-bottom">
          <div>
            <div class="price"><?= number_format($order['total_price'], 2) ?> EGP</div>
            <div class="date"><?= htmlspecialchars(date('M j, Y', strtotime($order['created_at']))) ?></div>
          </div>
          <a href="#" class="view-details">View details ›</a>
        </div>
        <?php if (!empty($order['rating'])): ?>
          <div class="review">
            <span class="stars"><?= str_repeat('★', $order['rating']) . str_repeat('☆', 5 - $order['rating']) ?></span>
            <?= htmlspecialchars($order['review']) ?>
          </div>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

<?php include __DIR__ . '/../../partials/footer.view.php'; ?>