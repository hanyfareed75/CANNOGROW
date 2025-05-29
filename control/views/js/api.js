const API_BASE = 'http://yourdomain.com/api.php?endpoint='; // عدّل المسار حسب الحاجة

// 🟢 GET request to any endpoint
async function getData(endpoint) {
    try {
        const response = await fetch(API_BASE + endpoint);
        if (!response.ok) throw new Error(`HTTP error! ${response.status}`);
        const data = await response.json();
        console.log(`GET ${endpoint}:`, data);
        return data;
    } catch (error) {
        console.error(`Error fetching ${endpoint}:`, error);
    }
}

// 🟠 POST request to any endpoint with JSON body
async function postData(endpoint, payload) {
    try {
        const response = await fetch(API_BASE + endpoint, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });
        if (!response.ok) throw new Error(`HTTP error! ${response.status}`);
        const data = await response.json();
        console.log(`POST ${endpoint}:`, data);
        return data;
    } catch (error) {
        console.error(`Error posting to ${endpoint}:`, error);
    }
}

// ✅ Examples of usage:

// Get all customers
// getData('customers');

// Create a customer
// postData('customers', { name: 'Ali', phone: '0123456789' });

// Get all products
// getData('products');

// Add new product
// postData('products', { name: 'Chicken Meal', price: 55.00 });

// Get all orders
// getData('orders');

// Add new delivery assignment
// postData('delivary', { order_id: 1, agent_id: 3, status: 'assigned' });

