// script.js
document.addEventListener('DOMContentLoaded', function() {
    const products = document.querySelectorAll('.product');
    const orderItemsContainer = document.getElementById('order-items');
    let orderItems = [];
    let totalPrice = 0;

    products.forEach(product => {
        product.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            const productName = this.getAttribute('data-name');
            const productPrice = parseFloat(this.getAttribute('data-price'));

            let orderItem = orderItems.find(item => item.id === productId);

            if (orderItem) {
                orderItem.quantity++;
                orderItem.element.querySelector('.quantity').innerText = orderItem.quantity;
            } else {
                orderItem = {
                    id: productId,
                    name: productName,
                    price: productPrice,
                    quantity: 1,
                    element: createOrderItemElement(productId, productName, productPrice)
                };
                orderItems.push(orderItem);
                orderItemsContainer.appendChild(orderItem.element);
            }

            updateTotalPrice();
        });
    });

    function createOrderItemElement(productId, productName, productPrice) {
        const itemElement = document.createElement('div');
        itemElement.classList.add('order-item');

        itemElement.innerHTML = `
            <p>${productName}</p>
            <p>Price: EGP ${productPrice}</p>
            <p>Quantity: <span class="quantity">1</span></p>
            <button class="remove-btn" data-id="${productId}">Remove</button>
            <input type="hidden" name="products[${productId}][id]" value="${productId}">
            <input type="hidden" name="products[${productId}][price]" value="${productPrice}">
            <input type="hidden" name="products[${productId}][quantity]" value="1" class="quantity-input">
        `;

        itemElement.querySelector('.remove-btn').addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            orderItems = orderItems.filter(item => item.id !== id);
            itemElement.remove();
            updateTotalPrice();
        });

        return itemElement;
    }

    function updateTotalPrice() {
        totalPrice = orderItems.reduce((total, item) => total + (item.price * item.quantity), 0);
        document.getElementById('total-price').innerText = `EGP ${totalPrice}`;
        
     
        orderItems.forEach(item => {
            item.element.querySelector('.quantity-input').value = item.quantity;
        });
    }
});
