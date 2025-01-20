const loginSection = document.getElementById('login-section');
const registerSection = document.getElementById('register-section');
const dashboard = document.getElementById('dashboard');
const userNameSpan = document.getElementById('user-name');
const expenseList = document.getElementById('expense-list');

const apiUrl = './php';

// Handle Login
document.getElementById('login-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const username = document.getElementById('login-username').value;
    const password = document.getElementById('login-password').value;

    const response = await fetch(`${apiUrl}/login.php`, {
        method: 'POST',
        body: JSON.stringify({ username, password }),
        headers: { 'Content-Type': 'application/json' },
    });

    const data = await response.json();
    if (data.success) {
        showDashboard(data.username);
    } else {
        document.getElementById('login-message').textContent = data.message;
    }
});

// Handle Registration
document.getElementById('register-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const username = document.getElementById('register-username').value;
    const password = document.getElementById('register-password').value;

    const response = await fetch(`${apiUrl}/register.php`, {
        method: 'POST',
        body: JSON.stringify({ username, password }),
        headers: { 'Content-Type': 'application/json' },
    });

    const data = await response.json();
    document.getElementById('register-message').textContent = data.message;
});

// Handle Adding Expenses
document.getElementById('expense-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const description = document.getElementById('description').value;
    const amount = document.getElementById('amount').value;

    const response = await fetch(`${apiUrl}/add_expense.php`, {
        method: 'POST',
        body: JSON.stringify({ description, amount }),
        headers: { 'Content-Type': 'application/json' },
    });

    const data = await response.json();
    if (data.success) {
        fetchExpenses();
    }
});

// Show Dashboard
function showDashboard(username) {
    loginSection.style.display = 'none';
    registerSection.style.display = 'none';
    dashboard.style.display = 'block';
    userNameSpan.textContent = username;
    fetchExpenses();
}

// Fetch Expenses
async function fetchExpenses() {
    const response = await fetch(`${apiUrl}/get_expenses.php`);
    const data = await response.json();
    expenseList.innerHTML = data.map((exp) => `<li>${exp.description} - ${exp.amount}</li>`).join('');
}

// Logout
document.getElementById('logout-btn').addEventListener('click', () => {
    loginSection.style.display = 'block';
    registerSection.style.display = 'block';
    dashboard.style.display = 'none';
    expenseList.innerHTML = '';
});
