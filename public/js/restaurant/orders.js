const orderTabs = document.querySelectorAll('.orders-tab');
const orders = document.querySelectorAll('.orders-content');

const statusMap = {
    all: 'all',
    pending: 'preparing',
    active: 'accepted',
    completed: 'delivered'
};

orderTabs.forEach(tab => {
    tab.addEventListener('click', () => {

        // Active tab
        orderTabs.forEach(tab => {
            tab.classList.remove('active');
        });

        tab.classList.add('active');

        const selectedStatus = statusMap[tab.dataset.status];

        orders.forEach(order => {
            const orderStatus = order.dataset.orderStatus;

            if (selectedStatus === 'all' || orderStatus === selectedStatus) {
                order.style.display = '';
            } else {
                order.style.display = 'none';
            }
        });
    });
});

const orderActions = document.querySelectorAll('.order-actions');

const actionMap = {
    accepted: {
        text: 'Start Preparing',
        nextStatus: 'preparing'
    },

    preparing: {
        text: 'Mark as Ready',
        nextStatus: 'ready'
    },

    ready: {
        text: 'Mark as Delivered',
        nextStatus: 'delivered'
    }
};

orderActions.forEach(action => {
    const order = action.closest('.orders-content');
    const status = order.dataset.orderStatus;

    if (actionMap[status]) {
        const button = document.createElement('button');

        button.textContent = actionMap[status].text;
        button.classList.add('order-action-button');

        action.appendChild(button);
    }
});

orderActions.forEach(action => {
    const order = action.closest('.orders-content');

    action.addEventListener('click', (event) => {
        if (!event.target.classList.contains('order-action-button')) {
            return;
        }

        const currentStatus = order.dataset.orderStatus;
        const nextStatus = actionMap[currentStatus]?.nextStatus;

        if (!nextStatus) {
            return;
        }

        order.dataset.orderStatus = nextStatus;

        action.innerHTML = '';

        if (actionMap[nextStatus]) {
            const button = document.createElement('button');

            button.textContent = actionMap[nextStatus].text;
            button.classList.add('order-action-button');

            action.appendChild(button);
        }
    });
});