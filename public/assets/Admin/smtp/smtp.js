// const switchBtn = document.getElementById('flexSwitchCheckDefault');
// const smtpSettings = document.querySelector('.smtp-settings');
// const emailFromGroup = document.getElementById('email_from_group');
// const emailFromNameGroup = document.getElementById('email_from_name_group');
// const contactEmailGroup = document.getElementById('contact_email_group');

// switchBtn.addEventListener('change', function() {
//     if (this.checked) {
//         smtpSettings.style.display = 'block';
      
//     } else {
//         smtpSettings.style.display = 'none';
//         emailFromGroup.style.display = 'block';
//         emailFromNameGroup.style.display = 'block';
//         contactEmailGroup.style.display = 'block';
//     }
// });


document.addEventListener('DOMContentLoaded', function() {
    // Get elements for the switch button and SMTP settings fields
    const switchBtn = document.getElementById('flexSwitchCheckDefault');
    const smtpSettings = document.querySelector('.smtp-settings');

    // Set initial display of SMTP settings based on switch status
    smtpSettings.style.display = switchBtn.checked ? 'block' : 'none';

    // Add an event listener to toggle the display when the switch changes
    switchBtn.addEventListener('change', function() {
        smtpSettings.style.display = this.checked ? 'block' : 'none';
    });
});