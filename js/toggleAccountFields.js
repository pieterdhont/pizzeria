function toggleAccountFields() {
  const checkbox = document.getElementById("createAccount");
  const fields = document.getElementById("accountFields");
  const submitButton = document.querySelector('input[type="submit"]');
  
  if (!checkbox) return; 
  
  if (checkbox.checked) {
      fields.style.display = "block";
      submitButton.disabled = false;
  } else {
      fields.style.display = "none";
      submitButton.disabled = true;
  }
}
