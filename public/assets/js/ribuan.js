function formatNumber(num) {
    // Check if input is a valid number
    if (isNaN(num)) {
        return num; // If not a number, return it unchanged
    }

    // Convert number to string
    let numStr = num.toString();

    // Split the number into integer and decimal parts
    let parts = numStr.split(".");
    let integerPart = parts[0];
    let decimalPart = parts.length > 1 ? "," + parts[1] : "";

    // Add dot as thousands separator to integer part
    integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

    // Combine integer part and decimal part
    return integerPart + decimalPart;
}

// Function to format text content of elements with specified class name
function formatElements(className) {
    // Find all elements with the specified class name
    let elements = document.getElementsByClassName(className);

    // Iterate over found elements and format their text content
    Array.prototype.forEach.call(elements, function (element) {
        // Get current text content and convert it to a number
        let num = parseFloat(element.textContent.replace(/,/g, "."));

        // Format the number and set the formatted text back to the element
        element.textContent = formatNumber(num);
    });
}

// Function to format input value on keyup event
function formatInputValue(event) {
    // Get the input element
    let input = event.target;

    // Get the current input value
    let value = input.value;

    // Remove any existing dots
    let sanitizedValue = value.replace(/\./g, "");

    // Convert the value to a number
    let num = parseFloat(sanitizedValue.replace(/,/g, "."));

    // Format the number with dot as thousands separator and comma as decimal
    input.value = formatNumber(num);
}

// Example of triggering the formatting function on page load
document.addEventListener("DOMContentLoaded", function () {
    formatElements("formatted-number");

    // Add event listeners for input elements with the specified class name
    let inputs = document.getElementsByClassName("number-input");
    Array.prototype.forEach.call(inputs, function (input) {
        input.addEventListener("keyup", formatInputValue);
    });
});

// Mengatur nilai input menggunakan setValue()
function setValue(inputId, value) {
    var input = document.getElementById(inputId);
    input.value = value;
    formatNumber(input);
}
