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
    .checkout-grid {
      grid-template-columns: 1fr;
    }
  }

  .checkout-card {
    background: #fff;
    border-radius: 12px;
    padding: 20px 22px;
    box-shadow: 0 1px 4px rgba(0, 0, 0, .06);
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

  .checkout-item:last-child {
    border-bottom: none;
  }

  .checkout-item img {
    width: 56px;
    height: 56px;
    border-radius: 8px;
    object-fit: cover;
    background: #f0f0f0;
  }

  .checkout-item-info {
    flex: 1;
    min-width: 0;
  }

  .checkout-item-info h4 {
    margin: 0 0 2px;
    font-size: 14px;
    color: #1a1a1a;
  }

  .checkout-item-info span {
    font-size: 12px;
    color: #f3402c;
    font-weight: 600;
  }

  .qty-box {
    display: flex;
    align-items: center;
    gap: 8px;
    background: #f6f1ea;
    border-radius: 8px;
    padding: 4px 8px;
  }

  .qty-box button {
    width: 22px;
    height: 22px;
    border-radius: 50%;
    border: none;
    background: #fff;
    color: #f3402c;
    font-weight: 700;
    cursor: pointer;
  }

  .checkout-item-total {
    min-width: 70px;
    text-align: right;
    font-size: 14px;
    font-weight: 600;
  }

  .address-box {
    background: #f6f1ea;
    border-radius: 8px;
    padding: 12px 14px;
    font-size: 14px;
    color: #333;
  }

  .change-address {
    display: inline-block;
    margin-top: 8px;
    font-size: 13px;
    color: #f3402c;
    text-decoration: none;
    font-weight: 600;
  }

  .payment-options {
    display: flex;
    gap: 12px;
  }

  .payment-option {
    flex: 1;
    border: 2px solid #eee;
    border-radius: 10px;
    padding: 14px;
    text-align: center;
    cursor: pointer;
    font-size: 14px;
    color: #555;
    transition: border-color .15s ease, background .15s ease;
  }

  .payment-option.selected {
    border-color: #f3402c;
    background: #fef3f1;
    color: #f3402c;
    font-weight: 700;
  }

  .summary-row {
    display: flex;
    justify-content: space-between;
    font-size: 14px;
    color: #555;
    margin-bottom: 10px;
  }

  .summary-total {
    display: flex;
    justify-content: space-between;
    font-size: 18px;
    font-weight: 700;
    color: #1a1a1a;
    margin-top: 12px;
    padding-top: 12px;
    border-top: 1px solid #eee;
  }

  .summary-note {
    font-size: 12px;
    color: #999;
    margin-top: 6px;
  }

  .btn-place-order {
    width: 100%;
    background: #f3402c;
    color: #fff;
    border: none;
    padding: 14px;
    border-radius: 10px;
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    margin-top: 14px;
    transition: background .15s ease, transform .15s ease;
  }

  .btn-place-order:hover {
    background: #d9331f;
    transform: translateY(-2px);
  }

  .btn-place-order:disabled {
    opacity: .6;
    cursor: not-allowed;
    transform: none;
  }

  .checkout-empty {
    text-align: center;
    padding: 80px 0;
    color: #999;
  }

  .coupon-card {
    padding: 18px 22px;
  }

  .coupon-input-group {
    display: flex;
    gap: 8px;
    padding-top: 12px;
  }

  .coupon-input-group input {
    flex: 1;
    height: 42px;
    padding: 0 12px;
    border: 1px solid #e5e1dd;
    border-radius: 8px;
    outline: none;
    font-size: 13px;
    transition: border-color .2s ease, box-shadow .2s ease;
    text-transform: uppercase;
  }

  .coupon-input-group input:focus {
    border-color: #f3402c;
    box-shadow: 0 0 0 3px rgba(243, 64, 44, .1);
  }

  .coupon-input-group button {
    border: none;
    border-radius: 8px;
    padding: 0 16px;
    background: #f3402c;
    color: #fff;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: background .2s ease, transform .2s ease;
  }

  .coupon-input-group button:hover {
    background: #d9331f;
    transform: translateY(-1px);
  }

  .coupon-input-group button:disabled {
    opacity: .6;
    cursor: not-allowed;
    transform: none;
  }

  .coupon-message {
    min-height: 18px;
    margin: 8px 0 0;
    font-size: 12px;
  }

  .coupon-message.success {
    font-weight: bold;
    color: #2e8b57;
  }

  .coupon-message.error {
    font-weight: bold;
    color: #d9331f;
  }
</style>

<div class="checkout-wrap">

  <div class="checkout-topbar">
    <a href="/customer/cart">← Back to cart</a>
  </div>

  <div id="checkoutEmpty" class="checkout-empty" style="display:none;">
    Your cart is empty, Go and make your order now!
  </div>

  <div id="checkoutContent" class="checkout-grid" style="display:none;">

    <div>

      <div class="checkout-card">

        <h3>Items</h3>

        <div id="checkoutItemsList"></div>

      </div>

      <div class="checkout-card">

        <h3> <?php include '../public/assets/icons/map-pin.php'; ?> Delivery address</h3>

        <div class="address-box">
          <?= htmlspecialchars($address) ?>
        </div>

        <a href="/customer/profile" class="change-address">
          Change address →
        </a>

      </div>

      <div class="checkout-card">

        <h3><?php include '../public/assets/icons/online-payment.php'; ?> Payment method</h3>

        <div class="payment-options">

          <div
            class="payment-option selected"
            data-method="COD"
            onclick="selectPayment('COD')">

            Cash on delivery

          </div>

          <div
            class="payment-option"
            data-method="Online"
            onclick="selectPayment('Online')">

            Online payment

          </div>

        </div>

      </div>

    </div>

    <div>

      <div class="checkout-card coupon-card">

        <h3><?php include '../public/assets/icons/coupon.php'; ?> Have a coupon?</h3>

        <div class="coupon-input-group">

          <input
            type="text"
            id="couponCode"
            placeholder="Enter coupon code"
            autocomplete="off">

          <button
            type="button"
            id="applyCouponBtn"
            onclick="applyCoupon()">

            Apply

          </button>

        </div>

        <p id="couponMessage" class="coupon-message"></p>

      </div>

      <div class="checkout-card">

        <h3>Order summary</h3>

        <div class="summary-row">

          <span>Subtotal</span>

          <span id="summarySubtotal">0.00 EGP</span>

        </div>

        <div class="summary-row">

          <span>Delivery fee</span>

          <span id="summaryDelivery">0.00 EGP</span>

        </div>

        <div
          class="summary-row"
          id="discountRow"
          style="display: none;">

          <span>Discount</span>

          <span id="summaryDiscount">-0.00 EGP</span>

        </div>

        <div class="summary-total">

          <span>Total</span>

          <span id="summaryTotal">0.00 EGP</span>

        </div>

        <div
          class="summary-note"
          id="deliveryTime">
        </div>

        <button
          class="btn-place-order"
          id="placeOrderBtn"
          onclick="placeOrder()">

          Place order

        </button>

      </div>

    </div>

  </div>

</div>

<?php include __DIR__ . '/../partials/footer.view.php'; ?>

<script>
  let selectedPayment = 'COD';
  let appliedCoupon = null;
  let discount = 0;


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


    const deliveryFee = Number(cart[0].deliveryFee) || 0;
    const deliveryTime = Number(cart[0].deliveryTime) || 0;

    const list = document.getElementById('checkoutItemsList');

    list.innerHTML = '';

    let subtotal = 0;


    cart.forEach(function(item) {

      const price = Number(item.price) || 0;
      const quantity = Number(item.qty) || 0;

      const itemTotal = price * quantity;

      subtotal += itemTotal;


      const row = document.createElement('div');

      row.className = 'checkout-item';

      row.innerHTML = `
        <img
          src="${item.image}"
          alt="${item.name}">

        <div class="checkout-item-info">

          <h4>${item.name}</h4>

          <span>${price.toFixed(2)} EGP</span>

        </div>

        <div class="qty-box">

          <span>${quantity}</span>

        </div>

        <div class="checkout-item-total">

          ${itemTotal.toFixed(2)} EGP

        </div>
      `;

      list.appendChild(row);

    });


    const total = Math.max(
      0,
      subtotal + deliveryFee - discount
    );


    document.getElementById('summarySubtotal').textContent =
      subtotal.toFixed(2) + ' EGP';

    document.getElementById('summaryDelivery').textContent =
      deliveryFee.toFixed(2) + ' EGP';


    const discountRow = document.getElementById('discountRow');

    if (discountRow) {

      discountRow.style.display =
        discount > 0 ? 'flex' : 'none';

    }


    document.getElementById('summaryDiscount').textContent =
      '-' + discount.toFixed(2) + ' EGP';


    document.getElementById('summaryTotal').textContent =
      total.toFixed(2) + ' EGP';


    document.getElementById('deliveryTime').textContent =
      `Estimated delivery: ${deliveryTime}–${deliveryTime + 5} min`;

  }


  function selectPayment(method) {

    selectedPayment = method;

    document.querySelectorAll('.payment-option').forEach(function(el) {

      el.classList.toggle(
        'selected',
        el.dataset.method === method
      );

    });

  }


  function applyCoupon() {

    const couponInput = document.getElementById('couponCode');
    const couponMessage = document.getElementById('couponMessage');
    const button = document.getElementById('applyCouponBtn');

    const code = couponInput.value.trim();

    if (!code) {

      couponMessage.textContent =
        'Please enter a coupon code.';

      couponMessage.className =
        'coupon-message error';

      return;
    }


    const cart = getCart();

    if (cart.length === 0) {
      return;
    }


    const subtotal = cart.reduce(function(total, item) {

      const price = Number(item.price) || 0;
      const quantity = Number(item.qty) || 0;

      return total + (price * quantity);

    }, 0);


    button.disabled = true;
    button.textContent = 'Applying...';


    fetch('/customer/coupon/apply', {

        method: 'POST',

        headers: {
          'Content-Type': 'application/json'
        },

        body: JSON.stringify({
          code: code,
          subtotal: subtotal
        })

      })

      .then(function(response) {

        return response.json();

      })

      .then(function(data) {

        if (!data.success) {

          discount = 0;
          appliedCoupon = null;

          couponMessage.textContent =
            data.message;

          couponMessage.className =
            'coupon-message error';

          renderCheckout();

          return;
        }


        discount = Number(data.discount) || 0;

        appliedCoupon = data.coupon;


        couponMessage.textContent =
          'Coupon applied. You saved ' +
          discount.toFixed(2) +
          ' EGP';

        couponMessage.className =
          'coupon-message success';


        renderCheckout();

      })

      .catch(function(error) {

        console.error('Coupon error:', error);

        discount = 0;
        appliedCoupon = null;

        couponMessage.textContent =
          'Something went wrong. Please try again.';

        couponMessage.className =
          'coupon-message error';

      })

      .finally(function() {

        button.disabled = false;
        button.textContent = 'Apply';

      });

  }


  function placeOrder() {

    const cart = getCart();

    if (cart.length === 0) {
      return;
    }

    if (!cart[0].restaurantId) {
      return;
    }


    const btn = document.getElementById('placeOrderBtn');

    btn.disabled = true;


    fetch('/customer/checkout', {

        method: 'POST',

        headers: {
          'Content-Type': 'application/json'
        },

        body: JSON.stringify({

          items: cart,

          payment_method: selectedPayment,

          coupon: appliedCoupon

        })

      })

      .then(function(res) {

        return res.json();

      })

      .then(function(data) {

        if (data.success) {

          localStorage.removeItem('cart');

          window.location.href =
            '/customer/orders';

          return;
        }


        btn.disabled = false;

        btn.textContent = 'Place order';

      })

      .catch(function(error) {

        console.error('Checkout error:', error);

        btn.disabled = false;

        btn.textContent = 'Place order';

      });

  }
  renderCheckout();
</script>