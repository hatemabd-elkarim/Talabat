<?php
include __DIR__ . '/../partials/header.view.php';
include __DIR__ . '/nav.view.php';
?>

<style>
  .checkout-wrap {
    max-width: 1100px;
    margin: 24px auto 60px;
    padding: 0 24px;
    font-family: 'Segoe UI', Arial, sans-serif;
  }
  .checkout-topbar {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
    font-size: 14px;
    color: #666;
  }
  .checkout-topbar a {
    color: #1a1a1a;
    text-decoration: none;
    font-weight: 600;
  }

  .checkout-grid {
    display: grid;
    grid-template-columns: 1.6fr 1fr;
    gap: 20px;
  }
  @media (max-width: 800px) {
    .checkout-grid { grid-template-columns: 1fr; }
  }

  .checkout-card {
    background: #fff;
    border-radius: 12px;
    padding: 20px 22px;
    box-shadow: 0 1px 4px rgba(0,0,0,.06);
    margin-bottom: 18px;
  }
  .checkout-card h3 {
    font-size: 15px;
    color: #1a1a1a;
    margin: 0 0 14px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .checkout-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 10px 0;
    border-bottom: 1px solid #f2f2f2;
  }
  .checkout-item:last-child { border-bottom: none; }
  .checkout-item img {
    width: 56px; height: 56px; border-radius: 8px; object-fit: cover; background: #f0f0f0;
  }
  .checkout-item-info { flex: 1; min-width: 0; }
  .checkout-item-info h4 { margin: 0 0 2px; font-size: 14px; color: #1a1a1a; }
  .checkout-item-info span { font-size: 12px; color: #f3402c; font-weight: 600; }

  .qty-box {
    display: flex; align-items: center; gap: 8px;
    background: #f6f1ea; border-radius: 8px; padding: 4px 8px;
  }
  .qty-box button {
    width: 22px; height: 22px; border-radius: 50%; border: none;
    background: #fff; color: #f3402c; font-weight: 700; cursor: pointer;
  }
  .checkout-item-total { min-width: 70px; text-align: right; font-size: 14px; font-weight: 600; }

  .address-box {
    background: #f6f1ea; border-radius: 8px; padding: 12px 14px; font-size: 14px; color: #333;
  }
  .change-address { display: inline-block; margin-top: 8px; font-size: 13px; color: #f3402c; text-decoration: none; font-weight: 600; }

  .payment-options { display: flex; gap: 12px; }
  .payment-option {
    flex: 1; border: 2px solid #eee; border-radius: 10px; padding: 14px; text-align: center;
    cursor: pointer; font-size: 14px; color: #555; transition: border-color .15s ease, background .15s ease;
  }
  .payment-option.selected { border-color: #f3402c; background: #fef3f1; color: #f3402c; font-weight: 700; }

  .summary-row { display: flex; justify-content: space-between; font-size: 14px; color: #555; margin-bottom: 10px; }
  .summary-total { display: flex; justify-content: space-between; font-size: 18px; font-weight: 700; color: #1a1a1a; margin-top: 12px; padding-top: 12px; border-top: 1px solid #eee; }
  .summary-note { font-size: 12px; color: #999; margin-top: 6px; }

  .btn-place-order {
    width: 100%; background: #f3402c; color: #fff; border: none; padding: 14px;
    border-radius: 10px; font-size: 15px; font-weight: 700; cursor: pointer; margin-top: 14px;
    transition: background .15s ease, transform .15s ease;
  }
  .btn-place-order:hover { background: #d9331f; transform: translateY(-2px); }
  .btn-place-order:disabled { opacity: .6; cursor: not-allowed; transform: none; }

  .checkout-empty { text-align: center; padding: 80px 0; color: #999; }
</style>

<div class="checkout-wrap">

  <div class="checkout-topbar">
    <a href="/customer/cart">← Back to cart</a>
  </div>

  <div id="checkoutEmpty" class="checkout-empty" style="display:none;">
    السلة فاضية، ارجع لصفحة الكارت وضيف أصناف الأول.
  </div>

  <div id="checkoutContent" class="checkout-grid" style="display:none;">

    <div>
      <div class="checkout-card">
        <h3>Items</h3>
        <div id="checkoutItemsList"></div>
      </div>

      <div class="checkout-card">
        <h3>📍 Delivery address</h3>
        <div class="address-box"><?= htmlspecialchars($address) ?></div>
        <a href="/customer/profile" class="change-address">Change address →</a>
      </div>

      <div class="checkout-card">
        <h3>💳 Payment method</h3>
        <div class="payment-options">
          <div class="payment-option selected" data-method="COD" onclick="selectPayment('COD')">
            Cash on delivery
          </div>
          <div class="payment-option" data-method="Online" onclick="selectPayment('Online')">
            Online payment
          </div>
        </div>
      </div>
    </div>

    <div>
      <div class="checkout-card">
        <h3>Order summary</h3>
        <div class="summary-row">
          <span>Subtotal</span>
          <span id="summarySubtotal">0.00 EGP</span>
        </div>
        <div class="summary-row">
          <span>Delivery fee</span>
          <span id="summaryDelivery">15.00 EGP</span>
        </div>
        <div class="summary-total">
          <span>Total</span>
          <span id="summaryTotal">0.00 EGP</span>
        </div>
        <div class="summary-note">Estimated delivery: 15–25 min</div>

        <button class="btn-place-order" id="placeOrderBtn" onclick="placeOrder()">
          Place order
        </button>
      </div>
    </div>

  </div>

</div>

<?php include __DIR__ . '/../partials/footer.view.php'; ?>

<script>
const DELIVERY_FEE = 15;
let selectedPayment = 'COD';

function getCart() {
    return JSON.parse(localStorage.getItem('cart')) || [];
}

function renderCheckout() {
    const cart = getCart();
    const empty = document.getElementById('checkoutEmpty');
    const content = document.getElementById('checkoutContent');

    if (cart.length === 0) {
        empty.style.display = 'block';
        content.style.display = 'none';
        return;
    }

    empty.style.display = 'none';
    content.style.display = 'grid';

    const list = document.getElementById('checkoutItemsList');
    list.innerHTML = '';
    let subtotal = 0;

    cart.forEach(function(item) {
        const itemTotal = item.price * item.qty;
        subtotal += itemTotal;

        const row = document.createElement('div');
        row.className = 'checkout-item';
        row.innerHTML = `
            <img src="${item.image}" alt="${item.name}">
            <div class="checkout-item-info">
                <h4>${item.name}</h4>
                <span>${item.price.toFixed(2)} EGP</span>
            </div>
            <div class="qty-box">
                <span>${item.qty}</span>
            </div>
            <div class="checkout-item-total">${itemTotal.toFixed(2)} EGP</div>
        `;
        list.appendChild(row);
    });

    document.getElementById('summarySubtotal').textContent = subtotal.toFixed(2) + ' EGP';
    document.getElementById('summaryDelivery').textContent = DELIVERY_FEE.toFixed(2) + ' EGP';
    document.getElementById('summaryTotal').textContent = (subtotal + DELIVERY_FEE).toFixed(2) + ' EGP';
}

function selectPayment(method) {
    selectedPayment = method;
    document.querySelectorAll('.payment-option').forEach(function(el) {
        el.classList.toggle('selected', el.dataset.method === method);
    });
}

function placeOrder() {
    const cart = getCart();

    if (cart.length === 0) {
        alert('السلة فاضية');
        return;
    }

    if (!cart[0].restaurantId) {
        alert('في مشكلة في بيانات المطعم، جرب تضيف المنتجات تاني من صفحة المطعم');
        return;
    }

    const btn = document.getElementById('placeOrderBtn');
    btn.disabled = true;
    btn.textContent = 'جاري إرسال الطلب...';

    fetch('/customer/checkout', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            items: cart,
            payment_method: selectedPayment,
        }),
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            localStorage.removeItem('cart');
            alert('تم إنشاء طلبك بنجاح! رقم الطلب: ' + data.order_id);
            window.location.href = '/customer/orders';
        } else {
            alert('حصل خطأ: ' + (data.message || 'حاول تاني'));
            btn.disabled = false;
            btn.textContent = 'Place order';
        }
    })
    .catch(() => {
        alert('حصل خطأ في الاتصال، حاول تاني');
        btn.disabled = false;
        btn.textContent = 'Place order';
    });
}

renderCheckout();
</script>