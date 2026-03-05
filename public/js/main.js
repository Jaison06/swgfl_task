// input filed capitalize
function capitalize(str) {
  if (!str) return str;
  return str.charAt(0).toUpperCase() + str.slice(1);
}

// Validate input filed
function validateInput(fieldName, ruleString) {
  const input = document.querySelector(`[name="${fieldName}"]`);
  const error = document.querySelector(`.${fieldName}-error`);
  const value = input.value.trim();

  let isValid = true;
  error.textContent = "";

  const rules = ruleString.split("|");

  for (const rule of rules) {
    const [ruleName, ruleValue] = rule.split(":");

    switch (ruleName) {
      case "required":
        if (!value) {
          error.textContent = `${capitalize(fieldName)} is required`;
          isValid = false;
        }
        break;

      case "min":
        if (value.length < parseInt(ruleValue)) {
          error.textContent = `${capitalize(fieldName)} must be at least ${ruleValue} characters`;
          isValid = false;
        }
        break;

      case "max":
        if (value.length > parseInt(ruleValue)) {
          error.textContent = `${capitalize(fieldName)} must not exceed ${ruleValue} characters`;
          isValid = false;
        }
        break;

      case "non-numeric":
        if (!isNaN(value)) {
          error.textContent = `${capitalize(fieldName)} cannot be only numbers`;
          isValid = false;
        }
        break;

      case "email":
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
          error.textContent = "Enter a valid email address";
          isValid = false;
        }
        break;
    }

    if (!isValid) break;
  }

  return isValid;
}

// Validate form
function isValid() {
  const fields = [
    { name: "name", rules: "required|min:3|max:55|non-numeric" },
    { name: "email", rules: "required|email" },
    { name: "reason", rules: "required|min:5|max:55|non-numeric" },
    { name: "message", rules: "required|min:10|max:1000|non-numeric" },
  ];

  let formIsValid = true;

  fields.forEach((field) => {
    const valid = validateInput(field.name, field.rules);
    if (!valid) formIsValid = false;
  });

  return formIsValid;
}

// form submission
const contactForm = document.getElementById("contact-form");

contactForm.addEventListener("submit", (e) => {
  e.preventDefault();

  if (isValid()) {
    console.log("Form valid. Submitting...");
    contactForm.submit();
  } else {
    console.log("Validation failed.");
  }
});
