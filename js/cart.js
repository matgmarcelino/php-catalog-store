const items = document.querySelectorAll('.cart-item');

items.forEach(item => {
    const quantityField = item.querySelector('input[name="quantity"]');

    quantityField.addEventListener('input', updateTotals);

    quantityField.addEventListener('keydown', event => {
        if (event.key === 'Enter') {
            event.preventDefault();
        }
    });
});

document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', () => {
        const field = document.createElement('input');
        field.type = 'hidden';
        field.name = 'cart-quantities';
        field.value = JSON.stringify(getQuantities());
        form.append(field);
    });
});

function getQuantity(item) {
    return parseInt(item.querySelector('input[name="quantity"]').value);
}

function getQuantities() {
    const quantities = {};
    items.forEach(item => {
        const quantity = getQuantity(item);
        if (!isNaN(quantity)) {
            quantities[item.dataset.id] = quantity;
        }
    });
    return quantities;
}

function updateTotals() {
    let subtotal = 0;

    items.forEach(item => {
        const total = item.dataset.price * Math.max(0, getQuantity(item) || 0);
        item.querySelector('.cart-line-total').textContent = formatPrice(total);
        subtotal += total;
    });

    document.querySelector('#cart-subtotal').textContent = formatPrice(subtotal);
    document.querySelector('#cart-tax').textContent = formatPrice(subtotal / 10);
    document.querySelector('#cart-total').textContent = formatPrice(subtotal * 1.1);
}

function formatPrice(value) {
    return '$' + value.toFixed(2);
}
