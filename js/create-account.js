const passwordField = document.querySelector('#password');
const verifyPasswordField = document.querySelector('#verifyPassword');
const containsNumber = /\d/;

passwordField.addEventListener('input', () => {
    const value = passwordField.value;

    document.querySelector('#passMsg')?.remove();

    if (value.length < 8) {
        passwordField.after(createMessage('passMsg', 'Password must be at least 8 characters long.'));
    } else if (!containsNumber.test(value)) {
        passwordField.after(createMessage('passMsg', 'Password must contain at least one digit.'));
    }

    updateValidity(passwordField);
});

verifyPasswordField.addEventListener('input', () => {
    const passwordValue = passwordField.value;
    const verifyPasswordValue = verifyPasswordField.value;

    document.querySelector('#passVerMsg')?.remove();
    document.querySelector('#verMsg')?.remove();

    if (passwordValue !== verifyPasswordValue) {
        passwordField.after(createMessage('passVerMsg', 'Passwords do not match!'));
        verifyPasswordField.after(createMessage('verMsg', 'Passwords do not match!'));
    }

    updateValidity(passwordField);
    updateValidity(verifyPasswordField);
});

function createMessage(id, textContent) {
    const msg = document.createElement('div');
    msg.id = id;
    msg.classList.add('invalid-feedback');
    msg.textContent = textContent;
    return msg;
}

function updateValidity(field) {
    const hasMessage = field.parentElement.querySelector('.invalid-feedback') !== null;
    field.classList.toggle('is-invalid', hasMessage);
}
