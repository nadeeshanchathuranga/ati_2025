@extends('layouts.app')

@section('content')
<div class="container mt-5">
         <div class="row mb-3">

<div class="col-lg-6 text-start">
 <a href="{{ route('sales.index') }}" class="btn btn-info text-white back-btn px-4 py-2 rounded-3">
    Back
</a>
</div>

 </div>
    <div class="row">


  <div class="col-lg-5">
            <h1 class="h1-font text-dark pb-3">
                Customer Details
            </h1>

            <div class="mb-3">
                <label for="name" class="form-label text-white">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label text-white">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label text-white">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone number">
            </div>

              <div class="mb-3">
                <label for="address" class="form-label text-white">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Enter address number">
            </div>
        </div>









        <div class="col-lg-7">
            <div class="billing-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-bold">Billing Details</h4>
                    <a href="#" class="small text-decoration-none text-primary" data-bs-toggle="modal" data-bs-target="#userManualModal">
                        User Manual <i class="bi bi-sliders"></i>
                    </a>
                </div>

                <!-- Selected Items List -->
                <div class="mb-3" id="selectedItemsList">
                    <h6>Selected Items:</h6>
                    <div id="itemsContainer">
                        <p class="text-muted small" id="noItemsMessage">No items selected</p>
                    </div>
                </div>

                <!-- Subtotal -->
                <div class="d-flex justify-content-between">
                    <span>Sub Total</span>
                    <span id="subTotal">0.00 LKR</span>
                </div>

                <!-- Custom Discount -->
                <div class="mb-3">
                    <label class="form-label">Custom Discount</label>
                    <div class="input-group">
                        <input type="number" class="form-control" placeholder="0.00" id="customDiscountValue" oninput="calculateTotal()">
                        <select class="form-select" style="max-width: 80px;" id="discountType" onchange="calculateTotal()">
                            <option value="%">%</option>
                            <option value="LKR">LKR</option>
                        </select>
                    </div>
                </div>

                <!-- Discount Amount Display -->
                <div class="d-flex justify-content-between">
                    <span>Discount Amount</span>
                    <span id="discountAmount">0.00 LKR</span>
                </div>

                <!-- Total -->
                <div class="d-flex justify-content-between">
                    <strong>Total</strong>
                    <strong id="totalAmount">0.00 LKR</strong>
                </div>

                <!-- Cash -->
                <div class="mb-3">
                    <label class="form-label">Cash</label>
                    <div class="input-group">
                        <input type="number" class="form-control" placeholder="0.00" id="cashAmount" oninput="calculateBalance()">
                        <span class="input-group-text">LKR</span>
                    </div>
                </div>

                <!-- Balance -->
                <div class="d-flex justify-content-between mb-3 small-label">
                    <span>Balance</span>
                    <span id="balanceAmount">0.00 LKR</span>
                </div>

                <!-- Payment Method -->
                <div class="mb-3">
                    <label class="form-label">Payment Method :</label>
                    <div class="d-flex gap-3">
                        <div class="payment-option active text-center" onclick="selectPayment(this)">
                           
                              <img src="{{ asset('images/2331966.png') }}" width="50" alt="Fertilizer">
                        </div>
                        <div class="payment-option text-center" onclick="selectPayment(this)">


            <img src="{{ asset('images/633611.png') }}" width="50" alt="Fertilizer">



                        </div>
                    </div>
                </div>

                <!-- Confirm Button -->
                <button class="btn w-100 confirm-btn" onclick="confirmOrder()">● CONFIRM ORDER</button>
            </div>
        </div>
    </div>
</div>

<!-- User Manual Modal -->
<div class="modal fade" id="userManualModal" tabindex="-1" aria-labelledby="userManualLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userManualLabel">Select Tea Products</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="overflow-auto" style="white-space: nowrap;">
                    <div class="d-flex flex-row" style="gap: 1rem;">
                        @foreach($teas as $tea)
                       <div class="card h-100 border-dark tea-card {{ $tea->total_weight <= 0 ? 'disabled' : '' }}"
     style="min-width: 300px; cursor: pointer; position: relative;"
     data-tea-grade="{{ $tea->tea_grade }}"
     data-buy-price="{{ $tea->buy_price }}"
     data-selling-price="{{ $tea->selling_price }}"
     data-date="{{ $tea->date }}"
     data-total-weight="{{ $tea->total_weight }}"
     onclick="{{ $tea->total_weight > 0 ? 'selectTeaItem(this)' : '' }}">

                            <div class="card-body text-black">

                                <h5 class="card-title text-black text-uppercase">{{ $tea->tea_grade }}</h5>
                                <p class="card-text mb-1 text-black"><strong>Buy Price:</strong> {{ number_format($tea->buy_price, 2) }} LKR</p>
                                <p class="card-text mb-1 text-black"><strong>Selling Price:</strong> {{ number_format($tea->selling_price, 2) }} LKR</p>
                       <p class="card-text mb-1 text-black"><strong>Tea Weight :</strong> <strong>{{ number_format($tea->total_weight, 2) }} g</strong>

    @if($tea->total_weight <= 0)
        <span class="out-of-stock-badge fw-bolder text-danger fs-6">Out of Stock</span>
    @endif</p>
                                <p class="card-text mb-1 text-black"><strong>Date:</strong> {{ $tea->date }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="addSelectedItems()">Add Selected Items</button>
            </div>
        </div>
    </div>
</div>

<style>
.item-row {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 10px;
    background-color: #f8f9fa;
}

.item-details {
    margin-bottom: 10px;
}

.item-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
}

.weight-control {
    display: flex;
    align-items: center;
    gap: 5px;
}

.weight-input {
    width: 80px;
    text-align: center;
}

.remove-btn {
    background-color: #dc3545;
    color: white;
    border: none;
    border-radius: 50%;
    width: 25px;
    height: 25px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    line-height: 1;
}

.remove-btn:hover {
    background-color: #c82333;
}

.tea-card.selected {
    border: 2px solid #007bff;
    background-color: #e3f2fd;
}

.tea-card.disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.item-total {
    font-weight: bold;
    color: #28a745;
}

.weight-warning {
    color: #dc3545;
    font-size: 0.8em;
}

.payment-option {
    cursor: pointer;
    padding: 10px;
    border: 2px solid transparent;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.payment-option:hover {
    border-color: #007bff;
}

.payment-option.active {
    border-color: #007bff;
    background-color: #e3f2fd;
}

.billing-card {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    border: 1px solid #dee2e6;
}

.confirm-btn {
    background-color: #28a745;
    color: white;
    border: none;
    padding: 12px;
    border-radius: 8px;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

.confirm-btn:hover {
    background-color: #218838;
}
</style>

<script>
let selectedItems = [];
let tempSelectedCards = [];

function selectTeaItem(card) {
    const teaGrade = card.getAttribute('data-tea-grade');
    const buyPrice = parseFloat(card.getAttribute('data-buy-price'));
    const sellingPrice = parseFloat(card.getAttribute('data-selling-price'));
    const date = card.getAttribute('data-date');
    const totalWeight = parseFloat(card.getAttribute('data-total-weight'));

    if (totalWeight <= 0) {
        alert(`"${teaGrade}" is out of stock and cannot be selected.`);
        return;
    }

    card.classList.toggle('selected');

    if (card.classList.contains('selected')) {
        tempSelectedCards.push({
            grade: teaGrade,
            buyPrice: buyPrice,
            sellingPrice: sellingPrice,
            date: date,
            totalWeight: totalWeight
        });
    } else {
        tempSelectedCards = tempSelectedCards.filter(item => item.grade !== teaGrade);
    }
}

function addSelectedItems() {
    tempSelectedCards.forEach(item => {
        // Check if item already exists
        const existingItem = selectedItems.find(existing => existing.grade === item.grade);

        if (!existingItem) {
            selectedItems.push({
                grade: item.grade,
                buyPrice: parseFloat(item.buyPrice),
                sellingPrice: parseFloat(item.sellingPrice),
                date: item.date,
                totalWeight: parseFloat(item.totalWeight),
                selectedWeight: 0 // Default weight
            });
        }
    });

    // Clear temp selection
    tempSelectedCards = [];

    // Remove selected class from all cards
    document.querySelectorAll('.tea-card').forEach(card => {
        card.classList.remove('selected');
    });

    // Close modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('userManualModal'));
    modal.hide();

    // Update UI
    updateItemsList();
    calculateTotal();
}

function updateItemsList() {
    const container = document.getElementById('itemsContainer');
    const noItemsMessage = document.getElementById('noItemsMessage');

    if (selectedItems.length === 0) {
        if (noItemsMessage) noItemsMessage.style.display = 'block';
        container.innerHTML = '<p class="text-muted small" id="noItemsMessage">No items selected</p>';
        return;
    }

    if (noItemsMessage) noItemsMessage.style.display = 'none';

    container.innerHTML = selectedItems.map((item, index) => {
        const itemTotal = calculateItemTotal(item);
        const weightWarning = item.selectedWeight > item.totalWeight
            ? `<div class="weight-warning">Warning: Exceeds available weight (${item.totalWeight}g)</div>`
            : '';

        return `
            <div class="item-row">
                <div class="item-details">
                    <strong>${item.grade}</strong><br>
                    <small class="text-muted">Selling Price: ${parseFloat(item.sellingPrice).toFixed(2)} LKR per gram</small><br>
                    <small class="text-muted">Available: ${item.totalWeight}g</small>
                </div>
                <div class="item-controls">
                    <div class="weight-control">
                        <label class="small">Weight:</label>
                        <input type="number"
                               class="form-control weight-input"
                               value="${item.selectedWeight}"
                               min="0"
                               max="${item.totalWeight}"
                               step="0.1"
                               onchange="updateWeight(${index}, this.value)"
                               oninput="validateWeightInput(${index}, this)"
                               onkeypress="return validateWeightKeypress(event)"
                               onpaste="return validateWeightPaste(event, ${index}, this)">
                        <span class="small">g</span>
                    </div>
                    <span class="item-total" id="itemTotal_${index}">${itemTotal.toFixed(2)} LKR</span>
                    <button class="remove-btn" onclick="removeItem(${index})">&times;</button>
                </div>
                ${weightWarning}
            </div>
        `;
    }).join('');
}

// Validation functions for weight input
function validateWeightInput(index, input) {
    const weightValue = parseFloat(input.value) || 0;
    const item = selectedItems[index];

    // Real-time validation during typing
    if (weightValue > item.totalWeight) {
        input.style.borderColor = '#dc3545';
        input.style.backgroundColor = '#fff5f5';
        showWeightError(index, `Cannot exceed ${item.totalWeight}g`);
    } else if (weightValue < 0) {
        input.style.borderColor = '#dc3545';
        input.style.backgroundColor = '#fff5f5';
        showWeightError(index, `Weight cannot be negative`);
    } else {
        input.style.borderColor = '#28a745';
        input.style.backgroundColor = '#f8fff8';
        hideWeightError(index);
        updateWeight(index, input.value);
    }
}

function validateWeightKeypress(event) {
    // Allow: backspace, delete, tab, escape, enter, period for decimals
    if ([46, 8, 9, 27, 13, 110, 190].indexOf(event.keyCode) !== -1 ||
        // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
        (event.keyCode === 65 && event.ctrlKey === true) ||
        (event.keyCode === 67 && event.ctrlKey === true) ||
        (event.keyCode === 86 && event.ctrlKey === true) ||
        (event.keyCode === 88 && event.ctrlKey === true) ||
        // Allow: home, end, left, right, down, up
        (event.keyCode >= 35 && event.keyCode <= 40)) {
        return true;
    }
    // Ensure that it is a number and stop the keypress
    if ((event.shiftKey || (event.keyCode < 48 || event.keyCode > 57)) && (event.keyCode < 96 || event.keyCode > 105)) {
        event.preventDefault();
        return false;
    }
    return true;
}

function validateWeightPaste(event, index, input) {
    setTimeout(() => {
        const pastedValue = parseFloat(input.value) || 0;
        const item = selectedItems[index];

        if (pastedValue > item.totalWeight) {
            input.value = item.totalWeight;
            alert(`Pasted value exceeded available quantity. Set to maximum available: ${item.totalWeight}g`);
        } else if (pastedValue < 0) {
            input.value = 0;
            alert(`Negative values are not allowed. Set to 0g`);
        }

        updateWeight(index, input.value);
    }, 10);

    return true;
}

function showWeightError(index, message) {
    const itemRows = document.querySelectorAll('.item-row');
    const currentRow = itemRows[index];

    if (currentRow) {
        let errorDiv = currentRow.querySelector('.weight-error');
        if (!errorDiv) {
            errorDiv = document.createElement('div');
            errorDiv.className = 'weight-error';
            errorDiv.style.color = '#dc3545';
            errorDiv.style.fontSize = '0.8em';
            errorDiv.style.marginTop = '5px';
            currentRow.appendChild(errorDiv);
        }
        errorDiv.textContent = message;
    }
}

function hideWeightError(index) {
    const itemRows = document.querySelectorAll('.item-row');
    const currentRow = itemRows[index];

    if (currentRow) {
        const errorDiv = currentRow.querySelector('.weight-error');
        if (errorDiv) {
            errorDiv.remove();
        }
    }
}

function updateWeight(index, weight) {
    const weightValue = parseFloat(weight) || 0;
    const item = selectedItems[index];
    const weightInput = document.querySelector(`input[onchange*="updateWeight(${index}"]`);

    // Validate weight against available quantity
    if (weightValue > item.totalWeight) {
        // Show error message
        alert(`Error: Entered weight (${weightValue}g) exceeds available quantity (${item.totalWeight}g) for ${item.grade}`);

        // Reset to maximum available weight
        weightInput.value = item.totalWeight;
        selectedItems[index].selectedWeight = item.totalWeight;

        // Update the display immediately
        const itemTotal = calculateItemTotal(selectedItems[index]);
        const itemTotalElement = document.getElementById(`itemTotal_${index}`);
        if (itemTotalElement) {
            itemTotalElement.textContent = itemTotal.toFixed(2) + ' LKR';
        }

        calculateTotal();
        return;
    }

    // Validate for negative values
    if (weightValue < 0) {
        alert(`Error: Weight cannot be negative for ${item.grade}`);
        weightInput.value = 0;
        selectedItems[index].selectedWeight = 0;

        const itemTotal = calculateItemTotal(selectedItems[index]);
        const itemTotalElement = document.getElementById(`itemTotal_${index}`);
        if (itemTotalElement) {
            itemTotalElement.textContent = itemTotal.toFixed(2) + ' LKR';
        }

        calculateTotal();
        return;
    }

    selectedItems[index].selectedWeight = weightValue;

    // Calculate and update item total immediately
    const itemTotal = calculateItemTotal(selectedItems[index]);
    const itemTotalElement = document.getElementById(`itemTotal_${index}`);
    if (itemTotalElement) {
        itemTotalElement.textContent = itemTotal.toFixed(2) + ' LKR';
    }

    // Update overall calculations
    calculateTotal();

    // Update weight warning if needed (this is now just for visual feedback)
    const weightWarning = item.selectedWeight > item.totalWeight;

    // Find the item row and update warning
    const itemRows = document.querySelectorAll('.item-row');
    const currentRow = itemRows[index];
    if (currentRow) {
        const existingWarning = currentRow.querySelector('.weight-warning');
        if (existingWarning) {
            existingWarning.remove();
        }

        if (weightWarning) {
            const warningDiv = document.createElement('div');
            warningDiv.className = 'weight-warning';
            warningDiv.textContent = `Warning: Exceeds available weight (${item.totalWeight}g)`;
            currentRow.appendChild(warningDiv);
        }
    }
}

function calculateItemTotal(item) {
    if (!item.selectedWeight || item.selectedWeight <= 0) return 0;

    const total = parseFloat(item.sellingPrice) * parseFloat(item.selectedWeight);
    return isNaN(total) ? 0 : total;
}

function removeItem(index) {
    selectedItems.splice(index, 1);
    updateItemsList();
    calculateTotal();
}

function calculateTotal() {
    const subtotal = selectedItems.reduce((total, item) => {
        return total + calculateItemTotal(item);
    }, 0);

    const discountValue = parseFloat(document.getElementById('customDiscountValue').value) || 0;
    const discountType = document.getElementById('discountType').value;

    let discountAmount = 0;
    if (discountValue > 0) {
        if (discountType === '%') {
            discountAmount = (subtotal * discountValue) / 100;
        } else {
            discountAmount = discountValue;
        }
    }

    const total = Math.max(0, subtotal - discountAmount); // Ensure total is not negative

    // Update display
    document.getElementById('subTotal').textContent = subtotal.toFixed(2) + ' LKR';
    document.getElementById('discountAmount').textContent = discountAmount.toFixed(2) + ' LKR';
    document.getElementById('totalAmount').textContent = total.toFixed(2) + ' LKR';

    // Recalculate balance
    calculateBalance();
}

function calculateBalance() {
    const totalText = document.getElementById('totalAmount').textContent;
    const total = parseFloat(totalText.replace(' LKR', '')) || 0;
    const cash = parseFloat(document.getElementById('cashAmount').value) || 0;

    const balance = cash - total;
    const balanceElement = document.getElementById('balanceAmount');

    balanceElement.textContent = balance.toFixed(2) + ' LKR';

    // Change color based on balance
    if (balance < 0) {
        balanceElement.style.color = '#dc3545'; // Red for negative balance
    } else if (balance === 0) {
        balanceElement.style.color = '#28a745'; // Green for exact amount
    } else {
        balanceElement.style.color = '#007bff'; // Blue for positive balance
    }
}

function selectPayment(element) {
    document.querySelectorAll('.payment-option').forEach(e => e.classList.remove('active'));
    element.classList.add('active');
}


function confirmOrder() {
    try {
        if (!selectedItems || selectedItems.length === 0) {
            alert('Please select at least one item.');
            return;
        }

        const hasWeightSelected = selectedItems.some(item =>
            item.selectedWeight && parseFloat(item.selectedWeight) > 0
        );

        if (!hasWeightSelected) {
            alert('Please enter weight for at least one item.');
            return;
        }

        const invalidWeightItems = selectedItems.filter(item =>
            parseFloat(item.selectedWeight) > parseFloat(item.totalWeight)
        );

        if (invalidWeightItems.length > 0) {
            const itemNames = invalidWeightItems.map(item => item.grade).join(', ');
            alert(`Error: The following items exceed available weight: ${itemNames}`);
            return;
        }

        const total = parseFloat(document.getElementById('totalAmount')?.textContent.replace(' LKR', '')) || 0;
        const cash = parseFloat(document.getElementById('cashAmount')?.value) || 0;
        const subtotal = parseFloat(document.getElementById('subTotal')?.textContent.replace(' LKR', '')) || 0;
        const discountAmount = parseFloat(document.getElementById('discountAmount')?.textContent.replace(' LKR', '')) || 0;
        const balance = parseFloat(document.getElementById('balanceAmount')?.textContent.replace(' LKR', '')) || 0;

        if (cash <= 0 || cash < total) {
            alert(`Please enter valid and sufficient cash amount. Required: ${total.toFixed(2)} LKR`);
            return;
        }

        const selectedPaymentMethod = document.querySelector('.payment-option.active img')?.alt || 'Cash';
        const discountValue = parseFloat(document.getElementById('customDiscountValue')?.value) || 0;
        const discountType = document.getElementById('discountType')?.value;

        if (discountValue < 0 || (discountType === '%' && discountValue > 100)) {
            alert('Invalid discount value');
            return;
        }

        const formatDate = (dateStr) => new Date(dateStr).toISOString().split('T')[0];

        const items = selectedItems
            .filter(item => item.selectedWeight && parseFloat(item.selectedWeight) > 0)
            .map(item => {
                const weight = parseFloat(item.selectedWeight.toFixed(2));
                const unitPrice = parseFloat(item.sellingPrice.toFixed(2));
                const itemTotal = parseFloat((weight * unitPrice).toFixed(2));
                const buyPrice = parseFloat(item.buyPrice || 0);

                if (weight > parseFloat(item.totalWeight)) {
                    throw new Error(`Weight exceeds available quantity for item: ${item.grade}`);
                }

                return {
                    tea_grade: item.grade,
                    weight,
                    unit_price: unitPrice,
                    item_total: itemTotal,
                    date: formatDate(item.date),
                    buy_price: buyPrice
                };
            });

        if (items.length === 0) {
            alert('No valid items to process');
            return;
        }

        const orderData = {
            customer_id: null,
            total_cost: total,
            cash,
            discount: discountAmount,
            items,
            subtotal,
            discount_value: discountValue,
            discount_type: discountType,
            balance,
            payment_method: selectedPaymentMethod,
            order_date: new Date().toISOString().split('T')[0],
            order_time: new Date().toTimeString().split(' ')[0],

              customer: {
        name: document.getElementById('name')?.value || '',
        email: document.getElementById('email')?.value || '',
        phone: document.getElementById('phone')?.value || '',
        address: document.getElementById('address')?.value || ''
    },
        };

        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) {
            alert('Error: CSRF token not found');
            return;
        }

        const confirmButton = document.querySelector('.confirm-btn');
        const originalButtonText = confirmButton.textContent;
        confirmButton.textContent = 'Processing...';
        confirmButton.disabled = true;

        fetch('/sales/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify(orderData)
        })
        .then(async response => {
            const contentType = response.headers.get("content-type");
            const data = contentType?.includes("application/json")
                ? await response.json()
                : await response.text();

            if (response.ok && data.success) {
    alert('Sale completed successfully!');
    console.log('Sale Details:', data.data);

    // Open printable receipt
    const receiptUrl = `/sales/receipt/${data.data.sale_id}`;
    window.open(receiptUrl, '_blank');

    resetForm();
}
 else {
                const errorMessage = data.message || 'Failed to process sale';
                throw new Error(errorMessage);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            let msg = error.message || 'An error occurred';
            if (msg.includes('Failed to fetch')) msg = 'Network error';
            if (msg.includes('CSRF')) msg = 'Session expired. Please refresh.';
            alert('Error: ' + msg);
        })
        .finally(() => {
            confirmButton.textContent = originalButtonText;
            confirmButton.disabled = false;
        });

    } catch (error) {
        alert('Error: ' + (error.message || 'Unexpected validation error'));
    }
}




 function resetForm() {
    try {
        // Reset arrays
        selectedItems = [];
        tempSelectedCards = [];

        // Reset customer fields
        const customerFields = ['name', 'email', 'phone', 'address'];
        customerFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) field.value = '';
        });

        // Reset form elements safely
        const elements = {
            customDiscountValue: document.getElementById('customDiscountValue'),
            cashAmount: document.getElementById('cashAmount'),
            discountType: document.getElementById('discountType')
        };

        Object.entries(elements).forEach(([key, element]) => {
            if (element) {
                if (key === 'discountType') {
                    element.value = '%'; // Reset to default
                } else {
                    element.value = '';
                }
            }
        });

        // Reset payment method to first option
        const paymentOptions = document.querySelectorAll('.payment-option');
        paymentOptions.forEach(e => e.classList.remove('active'));
        if (paymentOptions.length > 0) {
            paymentOptions[0].classList.add('active');
        }

        // Reset selected cards in modal
        document.querySelectorAll('.tea-card').forEach(card => {
            card.classList.remove('selected');
        });

        // Update UI
        updateItemsList();
        calculateTotal();

        console.log('Form reset successfully');

    } catch (error) {
        console.error('Error resetting form:', error);
    }
}



// Enhanced error handling for network issues
function handleNetworkError(error) {
    console.error('Network error:', error);

    if (!navigator.onLine) {
        return 'No internet connection. Please check your connection and try again.';
    }

    if (error.name === 'TypeError' && error.message.includes('Failed to fetch')) {
        return 'Unable to connect to server. Please try again later.';
    }

    return 'Network error occurred. Please try again.';
}

// Add form validation helper
function validateFormBeforeSubmit() {
    const requiredElements = [
        'totalAmount',
        'cashAmount',
        'subTotal',
        'discountAmount',
        'balanceAmount'
    ];

    const missingElements = requiredElements.filter(id => !document.getElementById(id));

    if (missingElements.length > 0) {
        console.error('Missing required elements:', missingElements);
        return false;
    }

    return true;
}

// Add this to your DOMContentLoaded event
document.addEventListener('DOMContentLoaded', function() {
    // Validate form structure on load
    if (!validateFormBeforeSubmit()) {
        console.error('Form validation failed on load');
    }

    // Add keyboard shortcut for confirm (optional)
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.key === 'Enter') {
            e.preventDefault();
            confirmOrder();
        }
    });

    updateItemsList();
    calculateTotal();
});


</script>

@endsection
