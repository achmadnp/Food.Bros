var originalValues = {};

function editField(field) {
  var input = document.getElementById(field);
  var editBtn = input.nextElementSibling;
  var confirmPasswordContainer = document.getElementById('confirmPasswordContainer');
  var confirmPasswordField = document.getElementById('confirmPassword');

  if (input.disabled) {
    originalValues[field] = input.value;
    input.disabled = false;
    editBtn.textContent = 'Speichern';

    if (field === 'password') {
      confirmPasswordContainer.classList.remove('hidden');
      confirmPasswordField.disabled = false;
      confirmPasswordField.classList.remove('hidden');
      input.type = 'text';
    }
  } else {
    var confirmMatch = true;

    if (field === 'password') {
      var passwordField = document.getElementById('password');
      if (passwordField.value !== confirmPasswordField.value) {
        confirmMatch = false;
        alert('Passwort und Bestätigungspasswort stimmen nicht überein');
      }
    }

    if (confirmMatch) {
      input.disabled = true;
      editBtn.textContent = 'Bearbeiten';

      if (field === 'password') {
        confirmPasswordContainer.classList.add('hidden');
        confirmPasswordField.value = '';
        confirmPasswordField.classList.add('hidden');
        input.type = 'password';
      }
    }
  }
}
