let formatTimeout;

// Function to format a number
function formatNumber(num) {
    if (isNaN(num)) {
        return num;
    }

    let numStr = num.toString();
    let parts = numStr.split(".");
    let integerPart = parts[0];
    let decimalPart = parts.length > 1 ? "," + parts[1] : "";

    integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    return integerPart + decimalPart;
}

// Function to format text content of elements with specified class name
function formatElements(className) {
    let elements = document.getElementsByClassName(className);
    Array.prototype.forEach.call(elements, function (element) {
        let num = parseFloat(element.textContent.replace(/,/g, "."));
        element.textContent = formatNumber(num);
    });
}

// Function to format input value immediately for thousands separator
function formatThousandsSeparator(event) {
    let input = event.target;
    let value = input.value;

    // Only format for thousands separator if there is no comma
    if (!value.includes(",")) {
        let sanitizedValue = value.replace(/\./g, "");
        let num = parseFloat(sanitizedValue.replace(/,/g, "."));

        if (!isNaN(num)) {
            input.value = formatNumber(num);
        }
    }
}

// Function to format input value on keyup event with delay for decimal point
function formatInputValueWithDelay(event) {
    clearTimeout(formatTimeout);

    formatTimeout = setTimeout(() => {
        let input = event.target;
        let value = input.value;

        let sanitizedValue = value.replace(/\./g, "");
        let num = parseFloat(sanitizedValue.replace(/,/g, "."));

        if (!isNaN(num)) {
            input.value = formatNumber(num);
        }
    }, 5000); // 5-second delay
}

// Function to trigger formatting on page load
document.addEventListener("DOMContentLoaded", function () {
    formatElements("formatted-number");

    let inputs = document.getElementsByClassName("number-input");
    Array.prototype.forEach.call(inputs, function (input) {
        input.addEventListener("input", formatThousandsSeparator); // Trigger immediately on input
        input.addEventListener("keyup", formatInputValueWithDelay); // Delay for decimal point
    });
});

// Function to set input value and format it
function setValue(inputId, value) {
    var input = document.getElementById(inputId);
    input.value = value;
    clearTimeout(formatTimeout);
    formatTimeout = setTimeout(() => {
        formatInputValueWithDelay({ target: input });
    }, 5000);
}
